<?php

namespace App\Http\Controllers;

use App\Imports\ProfessorsImport;
use App\Jobs\SendProfessorEmail;
use App\Models\EmailCampaign;
use App\Models\EmailTemplate;
use App\Models\EmailTracking;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Mail\MailManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class EmailCampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $templates = EmailTemplate::where('user_id', Auth::id())->get();

        return view('campaigns.create', compact('templates'));
    }


    public function startCampaign(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:email_templates,id',
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $user = Auth::user();

        if (empty($user->gmail_email) || empty($user->gmail_password)) {
            return response()->json(['error' => 'Gmail credentials not configured'], 400);
        }
        $mailer = app(MailManager::class)->mailer('smtp');

        // Create a custom transport on the fly:
        $transport = new \Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport(
            config('mail.mailers.smtp.host'),
            config('mail.mailers.smtp.port'),
            config('mail.mailers.smtp.encryption')
        );

        $transport->setUsername($user->gmail_email);
        $transport->setPassword($user->gmail_password);

        // Set it manually
        $mailer->setSymfonyTransport($transport);

        try {
            $transport->start(); // Manually test SMTP connection
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid Gmail credentials.',
                'details' => $e->getMessage(),
            ], 500);
        }

        $campaign = new EmailCampaign();
        $campaign->template_id = $request->template_id;
        $campaign->name = $request->name;
        $campaign->user_id = Auth::id();
        $campaign->status = 'completed';
        $campaign->save();

        Professor::truncate();
        Excel::import(new ProfessorsImport, $request->file('excel_file'));

        $professors = Professor::all();

        $total = $professors->count();
        $sent = 0;

        foreach ($professors as $professor) {
            $tracking = EmailTracking::create([
                'recipient_email' => $professor->email,
            ]);
            $emails = array_map('trim', explode(',', $professor->email));
            Mail::to($emails)
                ->send(new \App\Mail\ProfessorEmail(
                    $professor,
                    $campaign->template,
                    $tracking->id,
                    $user->gmail_email,
                    $user->gmail_username
                ));
            $sent++;
        }
        $campaign->sent_count = $sent;
        $campaign->save();

        return response()->json([
            'message' => 'Campaign completed.',
            'sent' => $sent,
            'total' => $total,
        ]);
    }
}

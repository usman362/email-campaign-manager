<?php

namespace App\Http\Controllers;

use App\Imports\ProfessorsImport;
use App\Jobs\SendProfessorEmail;
use App\Models\EmailCampaign;
use App\Models\EmailTemplate;
use App\Models\EmailTracking;
use App\Models\Professor;
use Illuminate\Http\Request;
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

        $campaign = new EmailCampaign();
        $campaign->template_id = $request->template_id;
        $campaign->daily_limit = 40;
        $campaign->user_id = Auth::id();
        $campaign->status = 'running';
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
                ->send(new \App\Mail\ProfessorEmail($professor, $campaign->template,$tracking->id));
            $sent++;
        }

        return response()->json([
            'message' => 'Campaign completed.',
            'sent' => $sent,
            'total' => $total,
        ]);
    }
}

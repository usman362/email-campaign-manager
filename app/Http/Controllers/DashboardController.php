<?php

namespace App\Http\Controllers;

use App\Models\EmailCampaign;
use App\Models\Professor;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalCampaigns = EmailCampaign::where('user_id',Auth::id())->count();
        $totalEmailsSent = EmailCampaign::where('user_id',Auth::id())->sum('sent_count');
        $totalTemplates = EmailTemplate::where('user_id',Auth::id())->count();

        $recentCampaigns = EmailCampaign::with('template')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalCampaigns',
            'totalEmailsSent',
            'totalTemplates',
            'recentCampaigns'
        ));
    }
}

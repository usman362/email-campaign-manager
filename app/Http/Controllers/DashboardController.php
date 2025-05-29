<?php

namespace App\Http\Controllers;

use App\Models\EmailCampaign;
use App\Models\Professor;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProfessors = 1;
        $totalCampaigns = 1;
        $totalEmailsSent = 1;
        $averageOpenRate = 1;

        $recentCampaigns = EmailCampaign::with('template')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProfessors',
            'totalCampaigns',
            'totalEmailsSent',
            'averageOpenRate',
            'recentCampaigns'
        ));
    }
}

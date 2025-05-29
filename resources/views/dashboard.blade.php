@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Professors</h5>
                <p class="card-text display-6">{{ $totalProfessors }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Campaigns</h5>
                <p class="card-text display-6">{{ $totalCampaigns }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Emails Sent</h5>
                <p class="card-text display-6">{{ $totalEmailsSent }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Average Open Rate</h5>
                <p class="card-text display-6">{{ $averageOpenRate }}%</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Recent Campaigns</h4>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>History</th>
                    <th>Total Emails</th>
                    <th>Open Rate</th>
                    <th>Condition</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentCampaigns as $campaign)
                <tr>
                    <td><a href="{{ route('campaigns.show', $campaign->id) }}">{{ $campaign->name }}</a></td>
                    <td>{{ $campaign->created_at->format('d/m/Y') }}</td>
                    <td>{{ $campaign->sent_count }}</td>
                    <td>{{ $campaign->open_rate }}%</td>
                    <td>
                        @if($campaign->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-primary">In Progress</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

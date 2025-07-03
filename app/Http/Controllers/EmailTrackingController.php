<?php

namespace App\Http\Controllers;

use App\Models\EmailTracking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailTrackingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function track($trackingId)
    {
        $tracking = EmailTracking::find($trackingId);

        if ($tracking && !$tracking->opened_at) {
            $tracking->opened_at = now();
            $tracking->save();
        }

        // Return a transparent 1x1 GIF image
        $gif = base64_decode(
            'R0lGODlhAQABAPAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=='
        );

        return Response::make($gif, 200, [
            'Content-Type' => 'image/gif',
            'Content-Length' => strlen($gif),
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}

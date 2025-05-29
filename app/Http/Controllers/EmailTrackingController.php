<?php

namespace App\Http\Controllers;

use App\Models\EmailTracking;
use Illuminate\Http\Request;

class EmailTrackingController extends Controller
{
    public function track($trackingId)
    {
        $tracking = EmailTracking::findOrFail($trackingId);

        // پہلی بار کھولنے کا وقت ریکارڈ کریں
        if (!$tracking->opened_at) {
            $tracking->update([
                'opened_at' => now(),
                'first_opened_at' => now(),
            ]);
        }

        // کھولنے کی تعداد میں اضافہ کریں
        $tracking->increment('open_count');
        $tracking->update(['last_opened_at' => now()]);

        // ایک خالی 1x1 پکسل واپس کریں
        return response(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII='))
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTracking extends Model
{
    protected $fillable = [
        'recipient_email',
        'opened_at'
    ];
}

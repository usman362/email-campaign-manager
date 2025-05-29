<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}

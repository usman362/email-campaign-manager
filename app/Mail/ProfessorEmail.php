<?php

namespace App\Mail;

use App\Models\EmailTracking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ProfessorEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $professor;
    public $template;
    public $trackingId;
    public $senderEmail;
    public $senderName;

    public function __construct($professor, $template, $trackingId, $senderEmail, $senderName)
    {
        $this->professor = $professor;
        $this->template = $template;
        $this->trackingId = $trackingId;
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
    }

    public function build()
    {

        return $this->from($this->senderEmail, $this->senderName)
            ->subject($this->template->subject)
            ->view('emails.professor')
            ->with([
                'professor' => $this->professor,
                'template' => $this->template,
                'content' => $this->template->body,
                'trackingId' => $this->trackingId,
            ]);
    }
}

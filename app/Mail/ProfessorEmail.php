<?php

namespace App\Mail;

use App\Models\EmailTracking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfessorEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $professor;
    public $template;

    public function __construct($professor, $template)
    {
        $this->professor = $professor;
        $this->template = $template;
    }

    public function build()
    {
        return $this->subject($this->template->subject)
            ->view('emails.professor')
            ->with([
                'professor' => $this->professor,
                'template' => $this->template,
                'content' => $this->template->body,
            ]);
    }
}

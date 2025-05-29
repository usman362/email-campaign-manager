<?php

namespace App\Jobs;

use App\Models\Professor;
use App\Models\EmailTemplate;
use App\Mail\ProfessorEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendProfessorEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $professor;
    public $template;

    public function __construct(Professor $professor, EmailTemplate $template)
    {
        $this->professor = $professor;
        $this->template = $template;
    }

    public function handle()
    {
        Mail::to($this->professor->email)
            ->send(new \App\Mail\ProfessorEmail($this->professor, $this->template));
    }
}

<?php

namespace App\Jobs;

use App\Mail\ScheduleChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendScheduleMail implements ShouldQueue
{
    use Queueable;

    protected $mail;

    /**
     * Create a new job instance.
     */
    public function __construct(ScheduleChanged $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::send($this->mail);
    }
}

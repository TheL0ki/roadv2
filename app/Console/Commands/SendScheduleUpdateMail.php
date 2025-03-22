<?php

namespace App\Console\Commands;

use DateTime;
use App\Models\User;
use App\Mail\ScheduleChanged;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendScheduleUpdateMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-schedule-update-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = new DateTime('2025-03-01');
        Mail::to('alexander@dominikus.one')->send(new ScheduleChanged(User::find(1), $date));
    }
}

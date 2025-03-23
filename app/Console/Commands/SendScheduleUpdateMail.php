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
    protected $signature = 'app:send-schedule-update-mail {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $date = new DateTime($this->argument('date'));
        Mail::to($_ENV['ADMIN_EMAIL'])->send(new ScheduleChanged(User::find(1), $date));
    }
}

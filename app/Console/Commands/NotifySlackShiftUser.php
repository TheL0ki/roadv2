<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifySlackShiftUser extends Command
{
    protected $signature = 'app:notify-slack-shift-user
                            {--date= : Target date (Y-m-d) for schedule lookup}
                            {--dry-run : Print the payload without sending to Slack}';

    protected $description = 'Notify Slack about the user scheduled for the configured shift';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $shiftId = config('road.notify_shift_id');

        if (! $shiftId) {
            $this->error('SLACK_NOTIFY_SHIFT_ID must be configured.');

            return self::FAILURE;
        }

        if (! $dryRun && ! config('road.slack_webhook_url')) {
            $this->error('SLACK_WEBHOOK_URL must be configured.');

            return self::FAILURE;
        }

        $targetDate = $this->resolveTargetDate();

        $schedule = Schedule::query()
            ->with('user')
            ->where('shift_id', $shiftId)
            ->where('day', (int) $targetDate->format('d'))
            ->where('month', (int) $targetDate->format('n'))
            ->where('year', (int) $targetDate->format('Y'))
            ->first();

        if ($schedule === null) {
            $this->warn(sprintf(
                'No user scheduled for shift %s on %s.',
                $shiftId,
                $targetDate->format('Y-m-d'),
            ));

            return self::FAILURE;
        }

        $user = $schedule->user;

        if ($user === null || blank($user->slackId)) {
            $this->error('Scheduled user has no Slack ID.');

            return self::FAILURE;
        }

        $payload = ['user' => $user->slackId];

        if ($dryRun) {
            $this->line('[dry-run] Target date: '.$targetDate->format('Y-m-d'));
            $this->line('[dry-run] User: '.$user->firstName.' '.$user->lastName);
            $this->line('[dry-run] Slack ID: '.$user->slackId);
            $this->line('[dry-run] Payload: '.json_encode($payload));

            return self::SUCCESS;
        }

        $response = Http::asJson()
            ->post(config('road.slack_webhook_url'), $payload);

        if (! $response->successful()) {
            Log::error('Slack webhook request failed.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $this->error('Slack webhook request failed.');

            return self::FAILURE;
        }

        $this->info(sprintf(
            'Notified Slack for %s %s (Slack ID: %s) on %s.',
            $user->firstName,
            $user->lastName,
            $user->slackId,
            $targetDate->format('Y-m-d'),
        ));

        return self::SUCCESS;
    }

    private function resolveTargetDate(): Carbon
    {
        $date = $this->option('date');

        if ($date !== null) {
            return Carbon::parse($date, 'Europe/Berlin')->modify('tomorrow')->startOfDay();
        }

        return Carbon::now('Europe/Berlin')->modify('tomorrow')->startOfDay();
    }
}

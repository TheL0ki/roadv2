<?php

namespace App\Console\Commands;

use App\Mail\ShiftReminder;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class NotifyEmailShiftUser extends Command
{
    protected $signature = 'app:notify-email-shift-user
                            {--date= : Target date (Y-m-d) for schedule lookup. Defaults to tomorrow}
                            {--dry-run : Print the recipients without sending email}';

    protected $description = 'Email users the day before a shift they chose to be reminded about';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $targetDate = $this->resolveTargetDate();

        if ($targetDate === null) {
            $this->error('Invalid date. Use Y-m-d (e.g. 2026-05-23).');

            return self::FAILURE;
        }

        $schedules = Schedule::query()
            ->with(['user.reminderShifts', 'shift'])
            ->where('day', (int) $targetDate->format('d'))
            ->where('month', (int) $targetDate->format('n'))
            ->where('year', (int) $targetDate->format('Y'))
            ->get()
            ->unique(fn (Schedule $schedule): string => $schedule->user_id.'-'.$schedule->shift_id);

        $sent = 0;
        $failed = false;

        foreach ($schedules as $schedule) {
            $user = $schedule->user;
            $shift = $schedule->shift;

            if ($user === null || $shift === null) {
                $this->error('Scheduled entry is missing a user or shift.');
                $failed = true;

                continue;
            }

            if (! $user->email_shift_reminder) {
                continue;
            }

            if (! $user->reminderShifts->contains('id', $shift->id)) {
                $this->line(sprintf(
                    'Skipping %s %s for %s (shift not selected).',
                    $user->firstName,
                    $user->lastName,
                    $shift->name,
                ));

                continue;
            }

            if (blank($user->email)) {
                $this->error(sprintf(
                    'User %s %s has no email address.',
                    $user->firstName,
                    $user->lastName,
                ));
                $failed = true;

                continue;
            }

            if ($dryRun) {
                $this->line(sprintf(
                    '[dry-run] Would email %s %s <%s> about %s on %s.',
                    $user->firstName,
                    $user->lastName,
                    $user->email,
                    $shift->name,
                    $targetDate->format('Y-m-d'),
                ));
                $sent++;

                continue;
            }

            if (! $this->sendReminder($user, $shift, $targetDate)) {
                $failed = true;

                continue;
            }

            $sent++;
        }

        if ($sent === 0 && ! $failed) {
            $this->info(sprintf(
                'No shift reminders to send for %s.',
                $targetDate->format('Y-m-d'),
            ));

            return self::SUCCESS;
        }

        if ($failed) {
            return self::FAILURE;
        }

        $this->info(sprintf(
            'Emailed %d reminder(s) for %s.',
            $sent,
            $targetDate->format('Y-m-d'),
        ));

        return self::SUCCESS;
    }

    private function resolveTargetDate(): ?Carbon
    {
        $date = $this->option('date');

        try {
            if (is_string($date) && $date !== '') {
                return Carbon::parse($date, 'Europe/Berlin')->startOfDay();
            }

            return Carbon::now('Europe/Berlin')->addDay()->startOfDay();
        } catch (Throwable) {
            return null;
        }
    }

    private function sendReminder(User $user, Shift $shift, Carbon $targetDate): bool
    {
        try {
            Mail::to($user->email, trim($user->firstName.' '.$user->lastName))
                ->send(new ShiftReminder($user, $shift, $targetDate));
        } catch (Throwable $exception) {
            Log::error('Shift reminder email failed.', [
                'user_id' => $user->id,
                'message' => $exception->getMessage(),
            ]);

            $this->error(sprintf(
                'Failed to email %s %s.',
                $user->firstName,
                $user->lastName,
            ));

            return false;
        }

        return true;
    }
}

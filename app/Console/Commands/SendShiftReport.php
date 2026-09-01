<?php

namespace App\Console\Commands;

use App\Mail\ShiftReport;
use App\Models\Schedule;
use App\Models\Shift;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendShiftReport extends Command
{
    protected $signature = 'app:send-shift-report
                            {shift? : The shift ID}
                            {emails?* : Recipient email addresses}
                            {--month= : Target month (Y-m). Defaults to the current month}
                            {--dry-run : Print the report without sending emails}';

    protected $description = 'Send a monthly shift assignment report to one or more email addresses';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $shiftId = $this->argument('shift') ?? config('road.shift_report_shift_id');
        $emails = $this->resolveEmails();
        $month = $this->resolveMonth();

        Log::info('Shift report command started.', [
            'shift_id' => $shiftId,
            'month' => $month?->format('Y-m'),
            'emails' => $emails,
            'dry_run' => $dryRun,
        ]);

        if ($month === null) {
            $this->error('Invalid month. Use Y-m (e.g. 2026-12).');

            return self::FAILURE;
        }

        if (blank($shiftId)) {
            $this->error('A shift ID is required.');

            return self::FAILURE;
        }

        if ($emails === []) {
            $this->error('At least one recipient email address is required.');

            return self::FAILURE;
        }

        $invalidEmails = array_values(array_filter(
            $emails,
            fn (string $email): bool => filter_var($email, FILTER_VALIDATE_EMAIL) === false,
        ));

        if ($invalidEmails !== []) {
            $this->error('Invalid email address: '.implode(', ', $invalidEmails));

            return self::FAILURE;
        }

        $shift = Shift::query()->find($shiftId);

        if ($shift === null) {
            $this->error("Shift [{$shiftId}] was not found.");

            return self::FAILURE;
        }

        $rows = $this->buildReportRows(
            Schedule::query()
                ->with('user')
                ->where('shift_id', $shift->id)
                ->where('month', (int) $month->format('n'))
                ->where('year', (int) $month->format('Y'))
                ->orderBy('day')
                ->get(),
        );

        if ($dryRun) {
            $this->line('[dry-run] Month: '.$month->format('Y-m'));
            $this->line('[dry-run] Shift: '.$shift->name);
            $this->line('[dry-run] Recipients: '.implode(', ', $emails));

            if ($rows === []) {
                $this->line('[dry-run] No assignments found for this shift in the selected month.');
            }

            foreach ($rows as $row) {
                $this->line('[dry-run] '.implode('; ', $row['dates']).' - '.$row['user']);
            }

            return self::SUCCESS;
        }

        Mail::to($emails)->send(new ShiftReport($shift, $month, $rows));

        $this->info(sprintf(
            'Sent shift report for %s (%s) to %s.',
            $shift->name,
            $month->format('Y-m'),
            implode(', ', $emails),
        ));

        return self::SUCCESS;
    }

    /**
     * @return list<string>
     */
    private function resolveEmails(): array
    {
        $emails = collect($this->argument('emails'))
            ->flatMap(fn (string $email): array => explode(',', $email))
            ->map(fn (string $email): string => trim($email))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($emails !== []) {
            return $emails;
        }

        return config('road.shift_report_emails', []);
    }

    private function resolveMonth(): ?Carbon
    {
        $month = $this->option('month');

        try {
            if ($month === null) {
                return Carbon::now('Europe/Berlin')->startOfMonth();
            }

            return Carbon::parse($month, 'Europe/Berlin')->startOfMonth();
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param  Collection<int, Schedule>  $schedules
     * @return list<array{dates: list<string>, user: string}>
     */
    private function buildReportRows(Collection $schedules): array
    {
        return $schedules
            ->filter(fn (Schedule $schedule): bool => $schedule->user !== null)
            ->groupBy('user_id')
            ->map(function (Collection $userSchedules): array {
                $user = $userSchedules->first()->user;

                $dates = $userSchedules
                    ->sortBy('day')
                    ->map(fn (Schedule $schedule): string => Carbon::create(
                        $schedule->year,
                        $schedule->month,
                        $schedule->day,
                    )->format('d.m.Y'))
                    ->unique()
                    ->values()
                    ->all();

                return [
                    'first_day' => (int) $userSchedules->min('day'),
                    'dates' => $dates,
                    'user' => trim($user->firstName.' '.$user->lastName),
                ];
            })
            ->sortBy('first_day')
            ->values()
            ->map(fn (array $row): array => [
                'dates' => $row['dates'],
                'user' => $row['user'],
            ])
            ->all();
    }
}

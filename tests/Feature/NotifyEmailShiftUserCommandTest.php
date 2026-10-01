<?php

use App\Mail\ShiftReminder;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

function scheduleUser(User $user, Shift $shift, int $day, int $month, int $year): void
{
    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => $day,
        'month' => $month,
        'year' => $year,
    ]);
}

it('emails users about the shifts they selected for tomorrow', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $targetDate = Carbon::now('Europe/Berlin')->addDay();
    $night = Shift::factory()->create([
        'name' => 'Night',
        'hour_start' => '22:00:00',
        'hour_end' => '06:00:00',
    ]);
    $day = Shift::factory()->create(['name' => 'Day']);

    $jane = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
        'email' => 'jane@example.com',
        'email_shift_reminder' => true,
    ]);
    $jane->reminderShifts()->attach($night);

    $bob = User::factory()->create([
        'email' => 'bob@example.com',
        'email_shift_reminder' => true,
    ]);
    $bob->reminderShifts()->attach($day);

    scheduleUser($jane, $night, (int) $targetDate->format('d'), (int) $targetDate->format('n'), (int) $targetDate->format('Y'));
    scheduleUser($bob, $day, (int) $targetDate->format('d'), (int) $targetDate->format('n'), (int) $targetDate->format('Y'));

    $this->artisan('app:notify-email-shift-user')
        ->assertSuccessful()
        ->expectsOutputToContain('Emailed 2 reminder(s) for 2026-05-19');

    Mail::assertSent(ShiftReminder::class, function (ShiftReminder $mail) use ($jane, $night) {
        return $mail->hasTo('jane@example.com')
            && $mail->user->is($jane)
            && $mail->shift->is($night)
            && $mail->date->toDateString() === '2026-05-19'
            && $mail->envelope()->subject === 'Erinnerung: Schicht Night am 19.05.2026';
    });
    Mail::assertSent(ShiftReminder::class, fn (ShiftReminder $mail) => $mail->hasTo('bob@example.com') && $mail->shift->is($day));

    Carbon::setTestNow();
});

it('does not email users who have not enabled the reminder', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $targetDate = Carbon::now('Europe/Berlin')->addDay();
    $shift = Shift::factory()->create();
    $user = User::factory()->create([
        'email_shift_reminder' => false,
    ]);
    $user->reminderShifts()->attach($shift);

    scheduleUser($user, $shift, (int) $targetDate->format('d'), (int) $targetDate->format('n'), (int) $targetDate->format('Y'));

    $this->artisan('app:notify-email-shift-user')
        ->assertSuccessful()
        ->expectsOutputToContain('No shift reminders to send for 2026-05-19');

    Mail::assertNothingSent();

    Carbon::setTestNow();
});

it('does not email an enabled user about a shift they did not select', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $targetDate = Carbon::now('Europe/Berlin')->addDay();
    $night = Shift::factory()->create(['name' => 'Night']);
    $day = Shift::factory()->create(['name' => 'Day']);

    $user = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
        'email' => 'jane@example.com',
        'email_shift_reminder' => true,
    ]);
    $user->reminderShifts()->attach($day);

    scheduleUser($user, $night, (int) $targetDate->format('d'), (int) $targetDate->format('n'), (int) $targetDate->format('Y'));
    scheduleUser($user, $day, (int) $targetDate->format('d'), (int) $targetDate->format('n'), (int) $targetDate->format('Y'));

    $this->artisan('app:notify-email-shift-user')
        ->assertSuccessful()
        ->expectsOutputToContain('Skipping Jane Doe for Night (shift not selected)');

    Mail::assertSent(ShiftReminder::class, 1);
    Mail::assertSent(ShiftReminder::class, fn (ShiftReminder $mail) => $mail->shift->is($day));

    Carbon::setTestNow();
});

it('uses the given date instead of tomorrow', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $shift = Shift::factory()->create(['name' => 'Night']);
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'email_shift_reminder' => true,
    ]);
    $user->reminderShifts()->attach($shift);

    scheduleUser($user, $shift, 23, 5, 2026);

    $this->artisan('app:notify-email-shift-user', ['--date' => '2026-05-23'])
        ->assertSuccessful();

    Mail::assertSent(ShiftReminder::class, fn (ShiftReminder $mail) => $mail->date->toDateString() === '2026-05-23');

    Carbon::setTestNow();
});

it('dry run prints the recipient without sending email', function () {
    Mail::fake();

    $shift = Shift::factory()->create(['name' => 'Night']);
    $user = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
        'email' => 'jane@example.com',
        'email_shift_reminder' => true,
    ]);
    $user->reminderShifts()->attach($shift);

    scheduleUser($user, $shift, 23, 5, 2026);

    $this->artisan('app:notify-email-shift-user', [
        '--date' => '2026-05-23',
        '--dry-run' => true,
    ])
        ->assertSuccessful()
        ->expectsOutputToContain('[dry-run] Would email Jane Doe <jane@example.com> about Night on 2026-05-23.');

    Mail::assertNothingSent();
});

it('succeeds when nobody is scheduled', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $this->artisan('app:notify-email-shift-user')
        ->assertSuccessful()
        ->expectsOutputToContain('No shift reminders to send for 2026-05-19');

    Mail::assertNothingSent();

    Carbon::setTestNow();
});

it('fails when the date option is invalid', function () {
    $this->artisan('app:notify-email-shift-user', ['--date' => 'not-a-date'])
        ->assertFailed()
        ->expectsOutputToContain('Invalid date');
});

it('is scheduled on weekdays at 13:00 in europe berlin', function () {
    $event = collect(app(Illuminate\Console\Scheduling\Schedule::class)->events())
        ->first(fn ($scheduledEvent) => str_contains($scheduledEvent->command ?? '', 'app:notify-email-shift-user'));

    expect($event)->not->toBeNull()
        ->and($event->timezone)->toBe('Europe/Berlin')
        ->and($event->expression)->toBe('0 13 * * 1-5');
});

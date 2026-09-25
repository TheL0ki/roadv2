<?php

use App\Mail\ShiftReminder;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    config(['road.email_notify_shift_id' => 42]);
});

it('emails opted-in users scheduled for the configured shift tomorrow', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $targetDate = Carbon::now('Europe/Berlin')->addDay();
    $shift = Shift::factory()->create([
        'name' => 'Night',
        'hour_start' => '22:00:00',
        'hour_end' => '06:00:00',
    ]);

    config(['road.email_notify_shift_id' => $shift->id]);

    $user = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
        'email' => 'jane@example.com',
        'email_shift_reminder' => true,
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => (int) $targetDate->format('d'),
        'month' => (int) $targetDate->format('n'),
        'year' => (int) $targetDate->format('Y'),
    ]);

    $this->artisan('app:notify-email-shift-user')
        ->assertSuccessful()
        ->expectsOutputToContain('Emailed 1 user(s) about Night');

    Mail::assertSent(ShiftReminder::class, function (ShiftReminder $mail) use ($user, $shift) {
        return $mail->hasTo('jane@example.com')
            && $mail->user->is($user)
            && $mail->shift->is($shift)
            && $mail->date->toDateString() === '2026-05-19'
            && $mail->envelope()->subject === 'Erinnerung: Schicht Night am 19.05.2026';
    });

    Carbon::setTestNow();
});

it('does not email users who have not enabled the reminder', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $targetDate = Carbon::now('Europe/Berlin')->addDay();
    $shift = Shift::factory()->create();

    config(['road.email_notify_shift_id' => $shift->id]);

    $user = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
        'email_shift_reminder' => false,
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => (int) $targetDate->format('d'),
        'month' => (int) $targetDate->format('n'),
        'year' => (int) $targetDate->format('Y'),
    ]);

    $this->artisan('app:notify-email-shift-user')
        ->assertSuccessful()
        ->expectsOutputToContain('Skipping Jane Doe (email reminders disabled)')
        ->expectsOutputToContain('No users with email reminders enabled');

    Mail::assertNothingSent();

    Carbon::setTestNow();
});

it('emails only the users who opted in', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $targetDate = Carbon::now('Europe/Berlin')->addDay();
    $shift = Shift::factory()->create(['name' => 'Night']);

    config(['road.email_notify_shift_id' => $shift->id]);

    $optedIn = User::factory()->create([
        'email' => 'opted-in@example.com',
        'email_shift_reminder' => true,
    ]);
    $optedOut = User::factory()->create([
        'email' => 'opted-out@example.com',
        'email_shift_reminder' => false,
    ]);

    foreach ([$optedIn, $optedOut] as $user) {
        Schedule::factory()->create([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
            'day' => (int) $targetDate->format('d'),
            'month' => (int) $targetDate->format('n'),
            'year' => (int) $targetDate->format('Y'),
        ]);
    }

    $this->artisan('app:notify-email-shift-user')->assertSuccessful();

    Mail::assertSent(ShiftReminder::class, fn (ShiftReminder $mail) => $mail->hasTo('opted-in@example.com'));
    Mail::assertNotSent(ShiftReminder::class, fn (ShiftReminder $mail) => $mail->hasTo('opted-out@example.com'));

    Carbon::setTestNow();
});

it('uses the given date instead of tomorrow', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $shift = Shift::factory()->create(['name' => 'Night']);

    config(['road.email_notify_shift_id' => $shift->id]);

    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'email_shift_reminder' => true,
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => 23,
        'month' => 5,
        'year' => 2026,
    ]);

    $this->artisan('app:notify-email-shift-user', ['--date' => '2026-05-23'])
        ->assertSuccessful();

    Mail::assertSent(ShiftReminder::class, fn (ShiftReminder $mail) => $mail->date->toDateString() === '2026-05-23');

    Carbon::setTestNow();
});

it('dry run prints the recipient without sending email', function () {
    Mail::fake();

    $shift = Shift::factory()->create(['name' => 'Night']);

    config(['road.email_notify_shift_id' => $shift->id]);

    $user = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
        'email' => 'jane@example.com',
        'email_shift_reminder' => true,
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => 23,
        'month' => 5,
        'year' => 2026,
    ]);

    $this->artisan('app:notify-email-shift-user', [
        '--date' => '2026-05-23',
        '--dry-run' => true,
    ])
        ->assertSuccessful()
        ->expectsOutputToContain('[dry-run] Would email Jane Doe <jane@example.com> about Night on 2026-05-23.');

    Mail::assertNothingSent();
});

it('fails when no schedule exists for the configured shift', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Mail::fake();

    $shift = Shift::factory()->create();

    config(['road.email_notify_shift_id' => $shift->id]);

    $this->artisan('app:notify-email-shift-user')
        ->assertFailed()
        ->expectsOutputToContain('No user scheduled for shift');

    Mail::assertNothingSent();

    Carbon::setTestNow();
});

it('fails when the shift id configuration is missing', function () {
    config(['road.email_notify_shift_id' => null]);

    $this->artisan('app:notify-email-shift-user')
        ->assertFailed()
        ->expectsOutputToContain('EMAIL_NOTIFY_SHIFT_ID must be configured');
});

it('fails when the date option is invalid', function () {
    $shift = Shift::factory()->create();

    config(['road.email_notify_shift_id' => $shift->id]);

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

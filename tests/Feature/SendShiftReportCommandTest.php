<?php

use App\Mail\ShiftReport;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

it('sends a grouped shift report for the given month to all recipients', function () {
    Mail::fake();

    $shift = Shift::factory()->create(['name' => 'Night']);
    $otherShift = Shift::factory()->create(['name' => 'Day']);

    $alice = User::factory()->create([
        'firstName' => 'Alice',
        'lastName' => 'Anders',
    ]);
    $bob = User::factory()->create([
        'firstName' => 'Bob',
        'lastName' => 'Berger',
    ]);
    $carol = User::factory()->create([
        'firstName' => 'Carol',
        'lastName' => 'Conrad',
    ]);

    foreach ([1, 2] as $day) {
        Schedule::factory()->create([
            'user_id' => $alice->id,
            'shift_id' => $shift->id,
            'day' => $day,
            'month' => 12,
            'year' => 2026,
        ]);
    }

    foreach ([5, 6, 7] as $day) {
        Schedule::factory()->create([
            'user_id' => $bob->id,
            'shift_id' => $shift->id,
            'day' => $day,
            'month' => 12,
            'year' => 2026,
        ]);
    }

    Schedule::factory()->create([
        'user_id' => $carol->id,
        'shift_id' => $shift->id,
        'day' => 31,
        'month' => 12,
        'year' => 2026,
    ]);

    Schedule::factory()->create([
        'user_id' => $alice->id,
        'shift_id' => $otherShift->id,
        'day' => 3,
        'month' => 12,
        'year' => 2026,
    ]);

    Schedule::factory()->create([
        'user_id' => $bob->id,
        'shift_id' => $shift->id,
        'day' => 5,
        'month' => 11,
        'year' => 2026,
    ]);

    $this->artisan('app:send-shift-report', [
        'shift' => $shift->id,
        'emails' => ['one@example.com', 'two@example.com'],
        '--month' => '2026-12',
    ])
        ->assertSuccessful()
        ->expectsOutputToContain('Sent shift report for Night (2026-12) to one@example.com, two@example.com');

    Mail::assertSent(ShiftReport::class, function (ShiftReport $mail) {
        $html = $mail->render();

        expect($mail->hasTo('one@example.com'))->toBeTrue()
            ->and($mail->hasTo('two@example.com'))->toBeTrue()
            ->and($html)->toContain('border-radius: 999px')
            ->and($html)->toContain('01.12.2026')
            ->and($html)->toContain('02.12.2026')
            ->and($html)->not->toContain('01.12.2026; 02.12.2026')
            ->and($html)->toContain('Alice Anders')
            ->and($html)->toContain('05.12.2026')
            ->and($html)->toContain('06.12.2026')
            ->and($html)->toContain('07.12.2026')
            ->and($html)->toContain('Bob Berger')
            ->and($html)->toContain('31.12.2026')
            ->and($html)->toContain('Carol Conrad')
            ->and($html)->not->toContain('03.12.2026');

        return true;
    });
});

it('defaults to the current month when no month is given', function () {
    Mail::fake();
    Carbon::setTestNow(Carbon::parse('2026-09-15 12:00:00', 'Europe/Berlin'));

    $shift = Shift::factory()->create(['name' => 'Night']);
    $user = User::factory()->create([
        'firstName' => 'Dana',
        'lastName' => 'Diaz',
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => 4,
        'month' => 9,
        'year' => 2026,
    ]);

    $this->artisan('app:send-shift-report', [
        'shift' => $shift->id,
        'emails' => ['report@example.com'],
    ])->assertSuccessful();

    Mail::assertSent(ShiftReport::class, function (ShiftReport $mail) {
        expect($mail->month->format('Y-m'))->toBe('2026-09')
            ->and($mail->render())->toContain('04.09.2026')
            ->and($mail->render())->toContain('Dana Diaz');

        return true;
    });

    Carbon::setTestNow();
});

it('dry run prints the report without sending mail', function () {
    Mail::fake();

    $shift = Shift::factory()->create(['name' => 'Night']);
    $user = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => 1,
        'month' => 12,
        'year' => 2026,
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => 2,
        'month' => 12,
        'year' => 2026,
    ]);

    $this->artisan('app:send-shift-report', [
        'shift' => $shift->id,
        'emails' => ['report@example.com'],
        '--month' => '2026-12',
        '--dry-run' => true,
    ])
        ->assertSuccessful()
        ->expectsOutputToContain('[dry-run] Month: 2026-12')
        ->expectsOutputToContain('[dry-run] Shift: Night')
        ->expectsOutputToContain('[dry-run] Recipients: report@example.com')
        ->expectsOutputToContain('[dry-run] 01.12.2026; 02.12.2026 - Jane Doe');

    Mail::assertNothingSent();
});

it('accepts comma-separated email addresses as a single argument', function () {
    Mail::fake();

    $shift = Shift::factory()->create();

    $this->artisan('app:send-shift-report', [
        'shift' => $shift->id,
        'emails' => ['one@example.com, two@example.com'],
        '--month' => '2026-12',
    ])->assertSuccessful();

    Mail::assertSent(ShiftReport::class, function (ShiftReport $mail) {
        return $mail->hasTo('one@example.com') && $mail->hasTo('two@example.com');
    });
});

it('logs every time the command fires including dry runs', function () {
    Mail::fake();
    Log::spy();

    $shift = Shift::factory()->create();

    $this->artisan('app:send-shift-report', [
        'shift' => $shift->id,
        'emails' => ['report@example.com'],
        '--month' => '2026-12',
        '--dry-run' => true,
    ])->assertSuccessful();

    Log::shouldHaveReceived('info')
        ->once()
        ->withArgs(function (string $message, array $context) use ($shift) {
            return $message === 'Shift report command started.'
                && $context['shift_id'] == $shift->id
                && $context['month'] === '2026-12'
                && $context['emails'] === ['report@example.com']
                && $context['dry_run'] === true;
        });
});

it('fails when the shift does not exist', function () {
    Mail::fake();

    $this->artisan('app:send-shift-report', [
        'shift' => 999,
        'emails' => ['report@example.com'],
        '--month' => '2026-12',
    ])
        ->assertFailed()
        ->expectsOutputToContain('Shift [999] was not found.');

    Mail::assertNothingSent();
});

it('fails when an email address is invalid', function () {
    Mail::fake();

    $shift = Shift::factory()->create();

    $this->artisan('app:send-shift-report', [
        'shift' => $shift->id,
        'emails' => ['not-an-email'],
        '--month' => '2026-12',
    ])
        ->assertFailed()
        ->expectsOutputToContain('Invalid email address: not-an-email');

    Mail::assertNothingSent();
});

it('fails when no shift id is provided and still logs', function () {
    Mail::fake();
    Log::spy();

    $this->artisan('app:send-shift-report')
        ->assertFailed()
        ->expectsOutputToContain('A shift ID is required.');

    Mail::assertNothingSent();

    Log::shouldHaveReceived('info')
        ->once()
        ->withArgs(fn (string $message): bool => $message === 'Shift report command started.');
});

it('fails when the month cannot be parsed', function () {
    Mail::fake();

    $shift = Shift::factory()->create();

    $this->artisan('app:send-shift-report', [
        'shift' => $shift->id,
        'emails' => ['report@example.com'],
        '--month' => 'not-a-month',
    ])
        ->assertFailed()
        ->expectsOutputToContain('Invalid month');

    Mail::assertNothingSent();
});

it('uses configured shift and emails when arguments are omitted', function () {
    Mail::fake();

    $shift = Shift::factory()->create(['name' => 'Night']);

    config([
        'road.shift_report_shift_id' => $shift->id,
        'road.shift_report_emails' => ['configured@example.com'],
    ]);

    $this->artisan('app:send-shift-report', [
        '--month' => '2026-12',
    ])->assertSuccessful();

    Mail::assertSent(ShiftReport::class, fn (ShiftReport $mail) => $mail->hasTo('configured@example.com'));
});

it('is scheduled monthly on the first at 08:00 in europe berlin', function () {
    $event = collect(app(Illuminate\Console\Scheduling\Schedule::class)->events())
        ->first(fn ($scheduledEvent) => str_contains($scheduledEvent->command ?? '', 'app:send-shift-report'));

    expect($event)->not->toBeNull()
        ->and($event->timezone)->toBe('Europe/Berlin')
        ->and($event->expression)->toBe('0 8 1 * *');
});

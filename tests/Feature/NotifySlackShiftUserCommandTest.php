<?php

use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'road.slack_webhook_url' => 'https://hooks.slack.com/services/test',
        'road.notify_shift_id' => 42,
    ]);
});

it('sends the scheduled users slack id to the webhook for tomorrow', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    $targetDate = Carbon::now('Europe/Berlin')->modify('tomorrow');

    $user = User::factory()->create([
        'slackId' => 'U12345678',
    ]);

    $shift = Shift::factory()->create();

    config(['road.notify_shift_id' => $shift->id]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => (int) $targetDate->format('d'),
        'month' => (int) $targetDate->format('n'),
        'year' => (int) $targetDate->format('Y'),
    ]);

    Http::fake([
        'hooks.slack.com/*' => Http::response('ok'),
    ]);

    $this->artisan('app:notify-slack-shift-user')
        ->assertSuccessful()
        ->expectsOutputToContain('Notified Slack for');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://hooks.slack.com/services/test'
            && $request['user'] === 'U12345678';
    });

    Carbon::setTestNow();
});

it('dry run prints payload to console without calling slack', function () {
    $targetDate = Carbon::parse('2026-05-23', 'Europe/Berlin');

    $user = User::factory()->create([
        'firstName' => 'Jane',
        'lastName' => 'Doe',
        'slackId' => 'U12345678',
    ]);

    $shift = Shift::factory()->create();

    config(['road.notify_shift_id' => $shift->id]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => (int) $targetDate->format('d'),
        'month' => (int) $targetDate->format('n'),
        'year' => (int) $targetDate->format('Y'),
    ]);

    Http::fake();

    $this->artisan('app:notify-slack-shift-user', [
        '--date' => '2026-05-23',
        '--dry-run' => true,
    ])
        ->assertSuccessful()
        ->expectsOutputToContain('[dry-run] Target date: 2026-05-23')
        ->expectsOutputToContain('[dry-run] User: Jane Doe')
        ->expectsOutputToContain('[dry-run] Slack ID: U12345678')
        ->expectsOutputToContain('[dry-run] Payload: {"user":"U12345678"}');

    Http::assertNothingSent();
});

it('uses the given date parameter instead of tomorrow', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    $user = User::factory()->create([
        'slackId' => 'U99999999',
    ]);

    $shift = Shift::factory()->create();

    config(['road.notify_shift_id' => $shift->id]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => 23,
        'month' => 5,
        'year' => 2026,
    ]);

    Http::fake([
        'hooks.slack.com/*' => Http::response('ok'),
    ]);

    $this->artisan('app:notify-slack-shift-user', ['--date' => '2026-05-23'])
        ->assertSuccessful();

    Http::assertSent(fn ($request) => $request['user'] === 'U99999999');

    Carbon::setTestNow();
});

it('fails when no schedule exists for the configured shift', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-18 12:00:00', 'Europe/Berlin'));

    Http::fake();

    $this->artisan('app:notify-slack-shift-user')
        ->assertFailed()
        ->expectsOutputToContain('No user scheduled for shift');

    Http::assertNothingSent();

    Carbon::setTestNow();
});

it('fails when shift id configuration is missing', function () {
    config([
        'road.slack_webhook_url' => 'https://hooks.slack.com/services/test',
        'road.notify_shift_id' => null,
    ]);

    $this->artisan('app:notify-slack-shift-user')
        ->assertFailed()
        ->expectsOutputToContain('SLACK_NOTIFY_SHIFT_ID must be configured');
});

it('dry run does not require slack webhook url', function () {
    config(['road.slack_webhook_url' => null]);

    $shift = Shift::factory()->create();

    config(['road.notify_shift_id' => $shift->id]);

    $user = User::factory()->create(['slackId' => 'U12345678']);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'shift_id' => $shift->id,
        'day' => 23,
        'month' => 5,
        'year' => 2026,
    ]);

    $this->artisan('app:notify-slack-shift-user', [
        '--date' => '2026-05-23',
        '--dry-run' => true,
    ])->assertSuccessful();
});

it('is scheduled on weekdays at 12:30 in europe berlin', function () {
    $event = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events())
        ->first(fn ($scheduledEvent) => str_contains($scheduledEvent->command ?? '', 'app:notify-slack-shift-user'));

    expect($event)->not->toBeNull()
        ->and($event->timezone)->toBe('Europe/Berlin')
        ->and($event->expression)->toBe('30 12 * * 1-5');
});

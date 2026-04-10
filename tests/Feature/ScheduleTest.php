<?php

use App\Models\Role;
use App\Models\Shift;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can display a schedule', function () {
    Schedule::factory(10)->create();
    $user = User::with('schedule')->get();

    $table = [];

    foreach ($user as $item) {
        foreach ($item->schedule as $entry) {
            $table[$entry->user_id][$entry->day] = $entry;
        }
    }

    expect(count($table))->toBeGreaterThanOrEqual(1);
    
});

it('can create a new user and login', function () {    
    $user = User::factory()->create();

    Auth::login($user);

    expect(Auth::hasUser())->toBeTrue();
});

it('clears schedule flexLoc when saving to a non-flex shift', function () {
    $adminRole = Role::create(['name' => 'administrator']);
    Role::create(['name' => 'manager']);
    Role::create(['name' => 'user']);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $flexShift = Shift::factory()->create([
        'name' => 'F',
        'display' => 'Flexible',
        'hour_start' => '08:00:00',
        'hour_end' => '16:00:00',
        'flexLoc' => 1,
    ]);

    $fixedShift = Shift::factory()->create([
        'name' => 'N',
        'display' => 'Non Flex',
        'hour_start' => '09:00:00',
        'hour_end' => '17:00:00',
        'flexLoc' => 0,
    ]);

    $user = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    Schedule::factory()->create([
        'user_id' => $user->id,
        'day' => 1,
        'month' => 1,
        'year' => 2026,
        'shift_id' => $flexShift->id,
        'flexLoc' => 1,
    ]);

    $response = $this->actingAs($admin)->patch("/schedule/{$user->id}/update", [
        'user_id' => $user->id,
        'month' => 1,
        'year' => 2026,
        'shift' => [
            1 => [
                'shift' => (string) $fixedShift->id,
                // Simulates stale checkbox value still sent from UI.
                'flexLoc' => 1,
            ],
        ],
    ]);

    $response->assertRedirect('/schedule/2026/1');

    $entry = Schedule::where('user_id', $user->id)
        ->where('day', 1)
        ->where('month', 1)
        ->where('year', 2026)
        ->firstOrFail();

    expect($entry->shift_id)->toBe($fixedShift->id)
        ->and($entry->flexLoc)->toBe(0);
});
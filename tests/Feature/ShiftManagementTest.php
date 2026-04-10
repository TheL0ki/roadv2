<?php

use App\Models\Role;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function shiftPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'M',
        'display' => 'Morning Shift',
        'color' => '#112233',
        'textColor' => '#FFFFFF',
        'hour_start' => '08:00',
        'hour_end' => '16:00',
    ], $overrides);
}

it('updates a shift and persists flexLoc when checkbox is unchecked', function () {
    $adminRole = Role::create(['name' => 'administrator']);
    Role::create(['name' => 'manager']);
    Role::create(['name' => 'user']);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $shift = Shift::factory()->create([
        'name' => 'E',
        'display' => 'Evening Shift',
        'color' => '#000000',
        'textColor' => '#FFFFFF',
        'hour_start' => '14:00',
        'hour_end' => '22:00',
        'flexLoc' => true,
        'override' => true,
    ]);

    $response = $this->actingAs($admin)->patch(
        route('shifts.update', $shift->id),
        shiftPayload([
            'flexLoc' => '0',
            'override' => '0',
        ])
    );

    $response->assertRedirect('/shiftManagement');
    $shift->refresh();

    expect($shift->flexLoc)->toBe(0)
        ->and($shift->override)->toBe(0);
});

it('updates a shift and persists flexLoc when checkbox is checked', function () {
    $adminRole = Role::create(['name' => 'administrator']);
    Role::create(['name' => 'manager']);
    Role::create(['name' => 'user']);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $shift = Shift::factory()->create([
        'hour_start' => '10:00',
        'hour_end' => '18:00',
        'flexLoc' => false,
        'override' => false,
    ]);

    $response = $this->actingAs($admin)->patch(
        route('shifts.update', $shift->id),
        shiftPayload([
            'flexLoc' => '1',
            'override' => '1',
        ])
    );

    $response->assertRedirect('/shiftManagement');
    $shift->refresh();

    expect($shift->flexLoc)->toBe(1)
        ->and($shift->override)->toBe(1);
});

it('updates a shift when time values include seconds', function () {
    $adminRole = Role::create(['name' => 'administrator']);
    Role::create(['name' => 'manager']);
    Role::create(['name' => 'user']);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $shift = Shift::factory()->create([
        'hour_start' => '09:00:00',
        'hour_end' => '17:00:00',
        'flexLoc' => true,
        'override' => true,
    ]);

    $response = $this->actingAs($admin)->patch(
        route('shifts.update', $shift->id),
        shiftPayload([
            'hour_start' => '10:15:00',
            'hour_end' => '18:45:00',
            'flexLoc' => '0',
            'override' => '0',
        ])
    );

    $response->assertRedirect('/shiftManagement');
    $shift->refresh();

    expect($shift->hour_start)->toContain('10:15')
        ->and($shift->hour_end)->toContain('18:45')
        ->and($shift->flexLoc)->toBe(0)
        ->and($shift->override)->toBe(0);
});

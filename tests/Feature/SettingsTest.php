<?php

use App\Models\Role;
use App\Models\Shift;
use App\Models\User;

it('lets a user choose which shifts trigger a reminder', function () {
    $role = Role::create(['name' => 'user']);

    $user = User::factory()->create([
        'role_id' => $role->id,
        'email_shift_reminder' => false,
    ]);

    $night = Shift::factory()->create([
        'name' => 'Night',
        'display' => 'Night shift',
        'color' => '#112233',
        'textColor' => '#FFFFFF',
        'active' => 1,
        'isHoliday' => 0,
    ]);
    $day = Shift::factory()->create([
        'name' => 'Day',
        'display' => 'Day shift',
        'active' => 1,
        'isHoliday' => 0,
    ]);
    $holiday = Shift::factory()->create([
        'name' => 'Holiday',
        'display' => 'Public holiday',
        'active' => 1,
        'isHoliday' => 1,
    ]);

    $this->withoutVite()
        ->actingAs($user)
        ->get('/settings')
        ->assertOk()
        ->assertSee('E-Mail Shift Reminder')
        ->assertSee('shift-reminder-grid', false)
        ->assertSee('shift-reminder-tile', false)
        ->assertSee('Night shift')
        ->assertSee('#112233', false)
        ->assertSee('#FFFFFF', false)
        ->assertSee('Day shift')
        ->assertDontSee('Public holiday')
        ->assertDontSee('(Night)');

    $this->actingAs($user)->patch(route('settings.update'), [
        'email' => $user->email,
        'userId' => $user->id,
        'emailShiftReminder' => '1',
        'reminderShifts' => [$night->id, $holiday->id],
    ])->assertRedirect();

    $user->refresh();

    expect($user->email_shift_reminder)->toBeTrue()
        ->and($user->reminderShifts->pluck('id')->all())->toBe([$night->id]);

    $this->actingAs($user)->patch(route('settings.update'), [
        'email' => $user->email,
        'userId' => $user->id,
        'emailShiftReminder' => '1',
        'reminderShifts' => [$day->id],
    ])->assertRedirect();

    expect($user->fresh()->reminderShifts->pluck('id')->all())->toBe([$day->id]);

    $this->actingAs($user)->patch(route('settings.update'), [
        'email' => $user->email,
        'userId' => $user->id,
    ])->assertRedirect();

    $user->refresh();

    expect($user->email_shift_reminder)->toBeFalse()
        ->and($user->reminderShifts)->toHaveCount(0);
});

it('keeps shift reminder emails off by default', function () {
    $user = User::factory()->create();

    expect($user->fresh()->email_shift_reminder)->toBeFalse()
        ->and($user->reminderShifts)->toHaveCount(0);
});

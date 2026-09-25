<?php

use App\Models\Role;
use App\Models\User;

it('lets a user turn the shift reminder email on and off', function () {
    $role = Role::create(['name' => 'user']);

    $user = User::factory()->create([
        'role_id' => $role->id,
        'email_shift_reminder' => false,
    ]);

    $this->withoutVite()
        ->actingAs($user)
        ->get('/settings')
        ->assertOk()
        ->assertSee('Email me the day before my shift');

    $this->actingAs($user)->patch(route('settings.update'), [
        'email' => $user->email,
        'userId' => $user->id,
        'emailShiftReminder' => '1',
    ])->assertRedirect();

    expect($user->fresh()->email_shift_reminder)->toBeTrue();

    $this->actingAs($user)->patch(route('settings.update'), [
        'email' => $user->email,
        'userId' => $user->id,
    ])->assertRedirect();

    expect($user->fresh()->email_shift_reminder)->toBeFalse();
});

it('keeps shift reminder emails off by default', function () {
    $user = User::factory()->create();

    expect($user->fresh()->email_shift_reminder)->toBeFalse();
});

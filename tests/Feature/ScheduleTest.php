<?php

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

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
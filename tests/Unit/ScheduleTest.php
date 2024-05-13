<?php

use App\Models\User;
use App\Models\Schedule;

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
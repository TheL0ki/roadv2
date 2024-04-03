<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(5)->create();
        $shift = Shift::factory(3)->create();

        Schedule::factory(50)->recycle($user)->recycle($shift)->create();
    }
}

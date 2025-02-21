<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $team = Team::factory(3)->create();

        $user = User::create([
            'firstName' => 'Admin',
            'lastName' => 'God',
            'email' => 'login@password.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'model' => 'VZ',
            'active' => 1,
            'validFrom' => now(),
            'remember_token' => Str::random(10),
        ]);

        $user->team()->associate(Team::find(1));
        $user->role()->associate(Role::find(1));
        $user->save();
        
        
        $user = User::factory(5)->recycle($team)->create(new Sequence(
            [
                'role_id' => 3
            ],
            [
                'role_id' => 2
            ]
        ));
        
        foreach ($team as $item) {
            $shift = Shift::factory(3)->hasAttached($item)->create();
            Schedule::factory(20)->recycle($user)->recycle($shift)->create();
        }
    }
}

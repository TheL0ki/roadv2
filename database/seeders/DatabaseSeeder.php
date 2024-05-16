<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'administrator',
            'manager',
            'user'    
        ];

        foreach($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
        
        $user = User::factory(5)->create();
        $shift = Shift::factory(3)->create();

        Schedule::factory(50)->recycle($user)->recycle($shift)->create();
    }
}

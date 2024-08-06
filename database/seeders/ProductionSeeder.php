<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
        Team::create([
            'name' => 'AdminTeam',
            'displayName' => 'Admin Team'
        ]);

        $user = User::create([
            'firstName' => 'Admin',
            'lastName' => 'God',
            'email' => 'login@password.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'model' => 'ft',
            'active' => 1,
            'validFrom' => now(),
            'remember_token' => Str::random(10),
        ]);

        $user->team()->associate(Team::find(1));
        $user->role()->associate(Role::find(1));
        $user->save();
    }
}

<?php

namespace Database\Factories;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'day' => fake()->dayOfMonth(),
            'month' => fake()->month(),
            'year' => Carbon::now()->year,
            'shift_id' => Shift::factory(),
            'flexLoc' => fake()->boolean(),
        ];
    }
}

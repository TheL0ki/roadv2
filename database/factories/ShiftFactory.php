<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'V',
            'display' => 'V',
            'color' => fake()->hexColor(),
            'textColor' => fake()->hexColor(),
            'hours' => fake()->numberBetween(6,10),
            'active' => 1
        ];
    }
}

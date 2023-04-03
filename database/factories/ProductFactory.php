<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['KeyNetic', 'KeyVibes']),
            'version' => fake()->randomElement(['V1', 'V2', 'V3', 'V4']),
            'weight' => fake()->randomFloat(2, 0, 100),
            'serial_number' => fake()->unique()->ean8(),
        ];
    }
}

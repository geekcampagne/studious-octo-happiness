<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parcel>
 */
class ParcelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_number' => fake()->randomNumber(8),
            'carrier' => fake()->randomElement(['UPS', 'FedEx', 'DHL', 'TNT']),
            'shipping_date' => fake()->dateTimeBetween('-1 week', 'now'),
            'delivery_date' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }
}

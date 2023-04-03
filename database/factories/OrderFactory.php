<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory()->create(),
            'status' => fake()->randomElement(['new', 'partial', 'sent', 'finished']),
            'order_date' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }
}

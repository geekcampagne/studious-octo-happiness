<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Parcel;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Closed Orders
        Order::factory(5)
            ->has(Product::factory()->state(['parcel_id' => null])->count(rand(2, 10)), 'products')
            ->create(
                [
                    'order_date' => fake()->dateTimeBetween('-6 week', '-5 week'),
                    'status' => 'finished',
                    'closing_date' => fake()->dateTimeBetween('-2 day', 'now'),
                ]

            )->each(
                function (Order $order) {
                    $parcels = Parcel::factory()->count(rand(1, 5))->create(['order_id' => $order->id]);
                    $order->products()->each(
                        function (Product $product) use ($parcels) {
                            $product->parcel()->associate(
                                $parcels->random()

                            );
                            $product->save();
                        }
                    );
                }
            );

        // Partial Orders
        Order::factory()->count(5)
            ->create(
                [
                    'status' => 'partial',
                    'order_date' => fake()->dateTimeBetween('-1 week', '-3 day'),
                    'closing_date' => null,
                ]

            )->each(function ($order) {
                $order->products()->saveMany(
                    Product::factory()->state(['parcel_id' => null])->count(rand(3, 8))->make()
                );
                $order->parcels()->saveMany(
                    Parcel::factory()->count(rand(1, 3))->make([
                        'tracking_number' => null,
                        'delivery_date' => null,
                        'shipping_date' => null,
                    ])
                );
            });

        // New Orders
        Order::factory()->count(8)
            ->create(
                [
                    'status' => 'new',
                    'order_date' => fake()->dateTimeBetween('-1 week', '-3 day'),
                    'closing_date' => null,
                ]
            )->each(function ($order) {
                $order->products()->saveMany(
                    Product::factory()->state([
                        'parcel_id' => null,
                        'serial_number' => null,

                    ])->count(rand(3, 8))->make()
                );
            });

        Parcel::all()->each(
            function (Parcel $parcel) {
                if ($parcel->products()->count() === 0) {
                    $parcel->delete();
                }
            }
        );
    }
}

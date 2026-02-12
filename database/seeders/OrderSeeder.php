<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::first()->id;

        // Make orders for test user
        foreach (range(1, 10) as $i) {
            $order = Order::create([
                'user_id'     => $userId,
                'total_price' => fake()->randomFloat(2, 10, 100),
                'status'      => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered']),
            ]);

            $total = 0;

            // Add random items to order
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();

            foreach ($products as $product) {
                $quantity = rand(1, 5);
                $price = $product->price;
                $total += $price * $quantity;

                Order_item::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'price'      => $price,
                ]);
            }

            $order->update(['total_price' => $total]);
        }
    }
}

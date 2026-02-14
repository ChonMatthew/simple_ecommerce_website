<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/products.csv');

        if (! file_exists($path)) {
            $this->command->warn('products.csv not found. Run ProductSeeder after creating database/data/products.csv');

            return;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            Product::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => (float) $data['price'],
                'image' => ! empty($data['image']) ? $data['image'] : null,
            ]);
        }

        fclose($handle);
    }
}

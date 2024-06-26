<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'collection_id' => 1, // Example: Product belongs to collection with ID 1
                'name' => 'Product 1',
                'price' => 19.99,
                'quantity' => 10,
                'description' => 'Description of Product 1',
                'size' => 'medium',
                'rate' => 4,
                'min_level' => 2,
                'is_active' => true,
                'in_stock' => true,
                'on_sale' => false,
                'triggered_at' => now(),
            ],
            [
               'collection_id' => 2, // Example: Product belongs to collection with ID 2
                'name' => 'Product 2',
                'price' => 29.99,
                'quantity' => 20,
                'description' => 'Description of Product 2',
                'size' => 'small',
                'rate' => 5,
                'min_level' => 3,
                'is_active' => true,
                'in_stock' => true,
                'on_sale' => true,
                'triggered_at' => now(),
                
            ],

        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}

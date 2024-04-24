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
                'description' => 'Description of Product 1',
                'size' => 'medium',
                'rate' => 4,
                'is_active' => true,
                'in_stock' => true,
                'on_sale' => false,
            ],
            [
                'collection_id' => 2, // Example: Product belongs to collection with ID 2
                'name' => 'Product 2',
                'price' => 29.99,
                'description' => 'Description of Product 2',
                'size' => 'small',
                'rate' => 5,
                'is_active' => true,
                'in_stock' => true,
                'on_sale' => true,
            ],

        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}

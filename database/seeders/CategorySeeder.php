<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Flowers', 'is_active' => true, 'parent_id' => null],
            ['name' => 'Roses', 'is_active' => true, 'parent_id' => 1], // Roses belong to Flowers (parent_id = 1)
            ['name' => 'Tulips', 'is_active' => true, 'parent_id' => 1], // Tulips belong to Flowers (parent_id = 1)
            ['name' => 'Lilies', 'is_active' => true, 'parent_id' => 1], // Lilies belong to Flowers (parent_id = 1)
            ['name' => 'Plants', 'is_active' => true, 'parent_id' => null],
            ['name' => 'Indoor Plants', 'is_active' => true, 'parent_id' => 5], // Indoor Plants belong to Plants (parent_id = 5)
            ['name' => 'Outdoor Plants', 'is_active' => true, 'parent_id' => 5], // Outdoor Plants belong to Plants (parent_id = 5)
            ['name' => 'Fruits', 'is_active' => true, 'parent_id' => null],
            ['name' => 'Apples', 'is_active' => true, 'parent_id' => 8], // Apples belong to Fruits (parent_id = 8)
            ['name' => 'Bananas', 'is_active' => true, 'parent_id' => 8], // Bananas belong to Fruits (parent_id = 8)
            ['name' => 'Oranges', 'is_active' => true, 'parent_id' => 8], //
        ];
        foreach ($categories as $typeData) {
            Category::create($typeData);
        }
    }
}

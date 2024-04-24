<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            ['name' => 'Spring Collection', 'category_id' => 1], // Example: Spring Collection belongs to category with ID 1
            ['name' => 'Summer Collection', 'category_id' => 2], // Example: Summer Collection belongs to category with ID 1
            ['name' => 'Autumn Collection', 'category_id' => 1], // Example: Autumn Collection belongs to category with ID 1
            ['name' => 'Winter Collection', 'category_id' => 3], // E

        ];

        foreach ($collections as $collectionData) {
            Collection::create($collectionData);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Addition;
use App\Models\TypeAddition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $additions = [
            [
                'type_addition_id' => TypeAddition::where('name', 'Type A')->first()->id,
                'name' => 'Addition 1',
                'description' => 'Description of Addition 1',
                'price' => 20.00,
                'quantity'=> 5
            ],
            [
                'type_addition_id' => TypeAddition::where('name', 'Type B')->first()->id,
                'name' => 'Addition 2',
                'description' => 'Description of Addition 2',
                'price' => 15.00,
                'quantity'=> 10
            ],
            // Add more additions as needed
        ];

        // Insert data into the 'additions' table
        foreach ($additions as $addition) {
            Addition::create($addition);
        }
    }
}

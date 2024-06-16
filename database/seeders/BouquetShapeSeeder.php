<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BouquetShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bouquet_shapes')->insert([
            ['name' => 'Round', 'description' => 'A round bouquet shape.'],
            ['name' => 'Cascade', 'description' => 'A cascading bouquet shape.'],
            ['name' => 'Posy', 'description' => 'A small, compact posy bouquet shape.'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'Red', 'hex_code' => '#FF0000', 'rgb_code' => '255,0,0'],
            ['name' => 'Blue', 'hex_code' => '#0000FF', 'rgb_code' => '0,0,255'],
            ['name' => 'Green', 'hex_code' => '#00FF00', 'rgb_code' => '0,255,0'],
        ]);
    }
}

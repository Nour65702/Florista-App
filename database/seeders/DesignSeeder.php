<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('designs')->insert([
            ['name' => 'Modern', 'description' => 'A modern design with sleek lines and minimalistic features.'],
            ['name' => 'Classic', 'description' => 'A classic design with traditional elements and ornate details.'],
            ['name' => 'Romantic', 'description' => 'A romantic design with soft colors and floral patterns.'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Admin::create([

            'name' => 'Admin',
            'email' => 'nour@gmail.com',
            'password' => Hash::make('123456789'),

        ]);
        
    }
}

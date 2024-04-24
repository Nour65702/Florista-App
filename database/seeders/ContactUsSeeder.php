<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'email' => 'gardenia@gmail.com',
                'address' => 'Damascus - Mazzeh',
                'phone' => '0935296026',
            ],
        ];
            foreach ($contacts as $contact) {
                ContactUs::create($contact);
            }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\MOdels\Admin;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // \App\Models\User::factory(10)->create();

        // $user =  User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        // ]);
        $user1 = User::create([

            'name' => 'Admin',
            'email' => 'obada@gmail.com',
            'password' => Hash::make('123456789'),

        ]);

        $role = Role::create(['name' => 'Admin']);
        $user1->assignRole($role);

        $this->call(CountrySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CollectionSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ContactUsSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call([
            DesignSeeder::class,
            ColorSeeder::class,
            AdditionSeeder::class,
        ]);
    }
}

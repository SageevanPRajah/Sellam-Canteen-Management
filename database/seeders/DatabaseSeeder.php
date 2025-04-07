<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. php artisan db:seed
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'usertype' => 'superadmin',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'usertype' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'usertype' => 'user',
            'password' => bcrypt('password123'),
        ]);
    }
}
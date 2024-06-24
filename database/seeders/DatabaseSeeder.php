<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        User::create([
            'name' => 'HR Manager',
            'role' => 'hr',
            'email' => 'hr@gmail.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Employee',
            'email' => 'employee@gmail.com',
            'role' => 'employee',
            'password' => bcrypt('password'),
        ]);

        
        User::create([
            'name' => 'Employee 2',
            'email' => 'employee2@gmail.com',
            'role' => 'employee',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Officer',
            'email' => 'officer@gmail.com',
            'role' => 'officer',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Finance Manager',
            'email' => 'finance@gmail.com',
            'role' => 'finance',
            'password' => bcrypt('password'),
        ]);
    }
}

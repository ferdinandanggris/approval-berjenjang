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
            'name' => 'Tony HR',
            'role' => 'hr',
            'email' => 'hr@mailnesia.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Agus Emp',
            'email' => 'employee@mailnesia.com',
            'role' => 'employee',
            'password' => bcrypt('password'),
        ]);

        
        User::create([
            'name' => 'Susan Emp',
            'email' => 'employee2@mailnesia.com',
            'role' => 'employee',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Budi Officer',
            'email' => 'officer@mailnesia.com',
            'role' => 'officer',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Ratna Finance',
            'email' => 'finance@mailnesia.com',
            'role' => 'finance',
            'password' => bcrypt('password'),
        ]);
    }
}

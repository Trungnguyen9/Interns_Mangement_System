<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'id_role' => 1
        ]);

        User::factory()->create([
            'name' => 'mentor',
            'email' => 'mentor@example.com',
            'password' => 'password',
            'id_role' => 2
        ]);

        User::factory()->create([
            'name' => 'intern',
            'email' => 'intern@example.com',
            'password' => 'password',
            'id_role' => 3
        ]);
    }
}

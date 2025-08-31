<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Admin
        User::create([
            'name' => 'Admin SISDINI',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // ubah sesuai kebutuhan
            'role' => 'admin',
        ]);

        // User Dokter
        User::create([
            'name' => 'Dokter SISDINI',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('password123'), // ubah sesuai kebutuhan
            'role' => 'dokter',
        ]);
    }
}

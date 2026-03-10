<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // PEMILIK
        User::create([
            'name' => 'Pemilik Rental',
            'email' => 'pemilik@rental.com',
            'password' => Hash::make('123456'),
            'role' => 'pemilik'
        ]);


        // PETUGAS
        User::create([
            'name' => 'Petugas Rental',
            'email' => 'petugas@rental.com',
            'password' => Hash::make('123456'),
            'role' => 'petugas'
        ]);

    }
}

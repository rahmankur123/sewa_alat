<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {

        for ($i = 1; $i <= 30; $i++) {

            User::create([
                'name' => 'Anggota '.$i,
                'email' => 'anggota'.$i.'@gmail.com',
                'password' => Hash::make('111111'),
                'role' => 'anggota',
                'foto' => 'user/CDJQY6r7qwZ9qQUnZjuO5PemsVV31BYVL7muFagn.png',
                'alamat' => 'Solo Raya',
                'no_hp' => '08'.rand(1111111111,9999999999),
            ]);

        }

    }
}
<?php

namespace Database\Seeders;

use App\Models\KepalaDinas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KepalaDinasSeeder extends Seeder
{
    public function run(): void
    {
        KepalaDinas::firstOrCreate(
            ['email' => 'kepaladinas@gmail.com'], // untuk cek data sudah ada atau belum
            [
                'nama' => 'Kepala Dinas',
                'password' => Hash::make('password123'),
            ]
        );
    }
}

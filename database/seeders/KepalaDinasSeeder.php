<?php

namespace Database\Seeders;

use App\Models\KepalaDinas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KepalaDinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KepalaDinas::create([
            'nama' => 'Kepala Dinas',
            'email' => 'kepaladinas@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}

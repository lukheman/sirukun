<?php

namespace Database\Seeders;

use App\Models\Warga;
use Illuminate\Database\Seeder;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Warga::factory()->create([
            'nik' => '1234567890123456',
            'password' => 'password123'
        ]);

        Warga::factory(1)->create();
    }
}

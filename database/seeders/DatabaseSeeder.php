<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            KepalaDinasSeeder::class,
            WargaSeeder::class,
            UnitRumahSeeder::class,
            PengajuanSeeder::class,
            PenempatanSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\UnitRumah;
use Illuminate\Database\Seeder;

class UnitRumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitRumah::factory(20)->create();
    }
}

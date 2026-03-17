<?php

namespace Database\Factories;

use App\Models\Pengajuan;
use App\Models\UnitRumah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penempatan>
 */
class PenempatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pengajuan' => Pengajuan::factory(),
            'id_unit' => UnitRumah::factory(),
            'tanggal_masuk' => $this->faker->date(),
        ];
    }
}

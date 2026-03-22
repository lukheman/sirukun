<?php

namespace Database\Factories;

use App\Enums\StatusKetersediaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitRumah>
 */
class UnitRumahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blok' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'nomor' => $this->faker->numberBetween(1, 100),
            'status_ketersediaan' => $this->faker->randomElement(StatusKetersediaan::cases()),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warga>
 */
class WargaFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->numerify('################'),
            'nkk' => $this->faker->numerify('################'),
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'password' => static::$password ??= Hash::make('password'),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
        ];
    }
}

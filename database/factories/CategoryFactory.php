<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'created_by' => $this->faker->randomElements(User::pluck('id')->toArray(), 1)[0],
            'updated_by' => $this->faker->randomElements(User::pluck('id')->toArray(), 1)[0],
            'name' => $this->faker->randomElement(['Rapat', 'Seminar', 'Workshop', 'Lomba', 'Kegiatan', 'Konsultasi', 'Pelatihan', 'Kegiatan', 'Konsultasi', 'Pelatihan']),
            'type' => $this->faker->randomElement(['HSE', 'EXT', 'INT']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecurringPatternFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
            'count' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}

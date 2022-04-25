<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\RecurringPattern;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
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
            'category_id' => $this->faker->randomElements(Category::pluck('id')->toArray(), 1)[0],
            'created_by' => $this->faker->randomElements(User::pluck('id')->toArray(), 1)[0],
            'updated_by' => $this->faker->randomElements(User::pluck('id')->toArray(), 1)[0],
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'location' => $this->faker->address,
            'start' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'end' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'color' => $this->faker->hexColor,
            'is_active' => $this->faker->numberBetween(0, 1),
        ];
    }
}

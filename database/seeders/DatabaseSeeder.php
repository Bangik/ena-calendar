<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        // \App\Models\Category::factory(7)->create();
        $seed = CategorySeeder::class;
        $this->call($seed);
        // \App\Models\RecurringPattern::factory(10)->create();
        // \App\Models\Event::factory(10)->create();
    }
}

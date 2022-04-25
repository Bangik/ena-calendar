<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::get('id');
        $userId = $user[0]->id;
        
        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Rapat',
            'type' => 'HSE',
            'icon' => 'fa fa-book',
            'color' => '#F8B400',
        ]);

        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Seminar',
            'type' => 'HSE',
            'icon' => 'fa fa-address-book',
            'color' => '#4b9189',
        ]);

        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Workshop',
            'type' => 'HSE',
            'icon' => 'fa fa-address-card',
            'color' => '#83914b',
        ]);

        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Lomba',
            'type' => 'HSE',
            'icon' => 'fa fa-trophy',
            'color' => '#918b4b',
        ]);

        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Kegiatan',
            'type' => 'HSE',
            'icon' => 'fa fa-cogs',
            'color' => '#916f4b',
        ]);

        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Konsultasi',
            'type' => 'HSE',
            'icon' => 'fa fa-comments',
            'color' => '#2b1535',
        ]);

        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Pelatihan',
            'type' => 'HSE',
            'icon' => 'fa fa-graduation-cap',
            'color' => '#00ea0f',
        ]);

        Category::create([
            'id' => (string) Str::uuid(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'name' => 'Hari Libur Nasional',
            'type' => 'EXT',
            'icon' => 'fa fa-calendar-check-o',
            'color' => '#ce0407',
        ]);
    }
}

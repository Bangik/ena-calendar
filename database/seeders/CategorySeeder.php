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
        
        $name = [
            'Kegiatan Sekolah - MPSA',
            'Kegiatan Sekolah - Pekan PBPM',
            'Kegiatan Sekolah - Peka Budaya',
            'Kegiatan Sekolah - Penilaian Tengah Semester',
            'Kegiatan Sekolah - Penilaian Akhir Semester',
            'Kegiatan Sekolah - Penilaian Akhir Tahun',
            'Kegiatan Sekolah - LDKS OSIS',
            'Kegiatan Sekolah - Class Meeting',
            'Kegiatan Sekolah - Wisuda SAI',
            'Persiapan Sekolah - Penyusunan EB-EK',
            'Persiapan Sekolah - Penyusunan kurikulum, anggaran, kaldik unit',
            'Persiapan Sekolah - Penyusunan Silabus',
            'Persiapan Sekolah - Pembuatan RPP',
            'Persiapan Sekolah - Rapat',
            'Persiapan Sekolah - Penyusunan dan pengumpulan perangkat PTS',
            'Hari Libur - Libur Semester 1',
            'Hari Libur - Libur Semester 2',
            'Hari Libur - Kematian Isa Almasih',
            'Hari Peringatan - HUT Indonesia',
            'Hari Peringatan - HUT Pancasila',
        ];

        $type = [
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Hari Libur',
            'Hari Libur',
            'Hari Libur',
            'Hari Peringatan',
            'Hari Peringatan',
        ];

        $color = [
            '#019f26',
            '#019f26',
            '#019f26',
            '#019f26',
            '#019f26',
            '#019f26',
            '#019f26',
            '#019f26',
            '#019f26',
            '#4360f3',
            '#4360f3',
            '#4360f3',
            '#4360f3',
            '#4360f3',
            '#4360f3',
            '#ff4343',
            '#ff4343',
            '#ff4343',
            '#c95102',
            '#c95102',
        ];

        $icon = [
            'fas fa-user-check',
            'fas fa-user-edit',
            'fas fa-users',
            'fas fa-school',
            'fas fa-school',
            'fas fa-school',
            'fas fa-users',
            'fas fa-medal',
            'fas fa-graduation-cap',
            'fas fa-book',
            'fas fa-print',
            'fas fa-folder-open',
            'fas fa-folder-open',
            'fas fa-users',
            'fas fa-book-open',
            'fas fa-calendar-week',
            'fas fa-calendar-week',
            'fas fa-cross',
            'fas fa-calendar-check',
            'fas fa-calendar-check',
        ];
        
        foreach ($name as $key => $value) {
            Category::create([
                'id' => (string) Str::uuid(),
                'created_by' => $userId,
                'updated_by' => $userId,
                'name' => $value,
                'type' => $type[$key],
                'icon' => $icon[$key],
                'color' => $color[$key],
            ]);
        }
    }
}

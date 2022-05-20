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
            '#f44336',
            '#e91e63',
            '#9c27b0',
            '#673ab7',
            '#3f51b5',
            '#2196f3',
            '#03a9f4',
            '#00bcd4',
            '#009688',
            '#4caf50',
            '#8bc34a',
            '#cddc39',
            '#ffeb3b',
            '#ffc107',
            '#ff9800',
            '#ff5722',
            '#795548',
            '#9e9e9e',
            '#607d8b',
            '#F8B400',
        ];
        
        foreach ($name as $key => $value) {
            Category::create([
                'id' => (string) Str::uuid(),
                'created_by' => $userId,
                'updated_by' => $userId,
                'name' => $value,
                'type' => $type[$key],
                'icon' => 'fa fa-book',
                'color' => $color[$key],
            ]);
        }
    }
}

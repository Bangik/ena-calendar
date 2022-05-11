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
            'Kegiatan Sekolah - PBPM',
            'Kegiatan Sekolah - Peka Budaya',
            'Kegiatan Sekolah - Penilaian Tengah Semester',
            'Kegiatan Sekolah - Penilaian Akhir Semester',
            'Kegiatan Sekolah - Penilaian Akhir Tahun',
            'Kegiatan Sekolah - LDKS OSIS',
            'Kegiatan Sekolah - Class Meeting',
            'Kegiatan Sekolah - Sumpah Pemuda',
            'Kegiatan Sekolah - 17 Agustus',
            'Kegiatan Sekolah - Wisuda SAI',
            'Persiapan Sekolah - Penyusunan EB-EK',
            'Persiapan Sekolah - Penyusunan kurikulum, anggaran, kaldik unit',
            'Persiapan Sekolah - Penyusunan Silabus',
            'Persiapan Sekolah - Pembuatan RPP',
            'Persiapan Sekolah - Penyusunan dan pengumpulan perangkat PTS',
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
            'Kegiatan Sekolah',
            'Kegiatan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
            'Persiapan Sekolah',
        ];
        
        foreach ($name as $key => $value) {
            Category::create([
                'id' => (string) Str::uuid(),
                'created_by' => $userId,
                'updated_by' => $userId,
                'name' => $value,
                'type' => $type[$key],
                'icon' => 'fa fa-book',
                'color' => '#F8B400',
            ]);
        }
    }
}

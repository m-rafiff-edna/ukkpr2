<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruang;

class RuangSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan firstOrCreate agar tidak duplikat setiap kali seeder dijalankan
        Ruang::firstOrCreate(
            ['nama_ruang' => 'Lab. Biologi'],
            [
                'deskripsi' => 'Lab Biologi dengan fasilitas yang lengkap',
                'kapasitas' => 30,
            ]
        );
    }
}

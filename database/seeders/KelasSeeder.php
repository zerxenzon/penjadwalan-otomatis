<?php
// ============================================
// 11. KELAS SEEDER
// ============================================
// File: database/seeders/KelasSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = [
            [
                'nama' => 'SI-R-SM3-20251',
                'angkatan_id' => 4, // 2025
                'prodi_id' => 1, // Sistem Informasi
                'semester_id' => 3, // 20251
                'shift_id' => 1, // Pagi Reguler
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'SI-NR-SM3-20251',
                'angkatan_id' => 4, // 2025
                'prodi_id' => 1, // Sistem Informasi
                'semester_id' => 3, // 20251
                'shift_id' => 2, // Siang Non-Reguler
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'SI-R-SM5-20231',
                'angkatan_id' => 3, // 2023
                'prodi_id' => 1, // Sistem Informasi
                'semester_id' => 3, // 20251
                'shift_id' => 1, // Pagi Reguler
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'TI-R-SM3-20251',
                'angkatan_id' => 4, // 2025
                'prodi_id' => 2, // Teknik Informatika
                'semester_id' => 3, // 20251
                'shift_id' => 1, // Pagi Reguler
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert kelas satu per satu dengan pengecekan duplikat
        foreach ($kelasList as $kelas) {
            // Cek apakah kelas dengan nama tersebut sudah ada
            if (!DB::table('kelas')->where('nama', $kelas['nama'])->exists()) {
                DB::table('kelas')->insert($kelas);
            }
        }
    }
}

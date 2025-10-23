<?php
// ============================================
// 6. ANGKATAN SEEDER
// ============================================
// File: database/seeders/AngkatanSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AngkatanSeeder extends Seeder
{
    public function run(): void
    {
        $angkatans = [
            [
                'tahun' => 2022,
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun' => 2023,
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun' => 2024,
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun' => 2025,
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert angkatan satu per satu dengan pengecekan duplikat
        foreach ($angkatans as $angkatan) {
            // Cek apakah kombinasi tahun dan status_id sudah ada
            if (!DB::table('angkatan')->where([
                'tahun' => $angkatan['tahun'],
                'status_id' => $angkatan['status_id']
            ])->exists()) {
                DB::table('angkatan')->insert($angkatan);
            }
        }
    }
}



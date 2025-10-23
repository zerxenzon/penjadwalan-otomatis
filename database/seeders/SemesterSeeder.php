<?php
// ============================================
// 7. SEMESTER SEEDER
// ============================================
// File: database/seeders/SemesterSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        $semesters = [
            [
                'kode_semester' => 20241,
                'tipe' => 'ganjil',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_semester' => 20242,
                'tipe' => 'genap',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_semester' => 20251,
                'tipe' => 'ganjil',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_semester' => 20252,
                'tipe' => 'genap',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert semester satu per satu dengan pengecekan duplikat
        foreach ($semesters as $semester) {
            // Cek kombinasi kode_semester dan tipe yang unik
            if (!DB::table('semester')->where([
                'kode_semester' => $semester['kode_semester'],
                'tipe' => $semester['tipe']
            ])->exists()) {
                DB::table('semester')->insert($semester);
            }
        }
    }
}

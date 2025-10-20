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
        DB::table('semester')->insert([
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
        ]);
    }
}

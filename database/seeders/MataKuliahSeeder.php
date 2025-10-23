<?php
// ============================================
// 9. MATA_KULIAH SEEDER
// ============================================
// File: database/seeders/MataKuliahSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $mataKuliahs = [
            [
                'nama' => 'Pemrograman Web 2',
                'kode' => 'MK001',
                'sks' => 3,
                'prodi_id' => 1, // Sistem Informasi
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Basis Data Lanjut',
                'kode' => 'MK002',
                'sks' => 3,
                'prodi_id' => 1,
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Operasi',
                'kode' => 'MK003',
                'sks' => 3,
                'prodi_id' => 1,
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jaringan Komputer',
                'kode' => 'MK004',
                'sks' => 3,
                'prodi_id' => 1,
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Keamanan Informasi',
                'kode' => 'MK005',
                'sks' => 2,
                'prodi_id' => 1,
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Algoritma dan Struktur Data',
                'kode' => 'MK006',
                'sks' => 3,
                'prodi_id' => 2, // Teknik Informatika
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert mata kuliah satu per satu untuk menghindari error duplikasi
        foreach ($mataKuliahs as $mk) {
            // Cek apakah mata kuliah dengan kode tersebut sudah ada
            if (!DB::table('mata_kuliah')->where('kode', $mk['kode'])->exists()) {
                DB::table('mata_kuliah')->insert($mk);
            }
        }
    }
}

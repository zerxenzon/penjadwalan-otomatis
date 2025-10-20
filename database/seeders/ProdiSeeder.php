<?php
// ============================================
// 5. PRODI SEEDER
// ============================================
// File: database/seeders/ProdiSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prodi')->insert([
            [
                'nama' => 'Sistem Informasi',
                'kode' => 'SI',
                'keterangan' => 'Program Studi Sistem Informasi',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Teknik Informatika',
                'kode' => 'TI',
                'keterangan' => 'Program Studi Teknik Informatika',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Manajemen Informatika',
                'kode' => 'MI',
                'keterangan' => 'Program Studi Manajemen Informatika',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


<?php
// ============================================
// 10. RUANGAN SEEDER
// ============================================
// File: database/seeders/RuanganSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ruangan')->insert([
            [
                'nama' => 'Lab Komputer 1',
                'kapasitas' => 40,
                'keterangan' => 'Laboratorium Komputer 1',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lab Komputer 2',
                'kapasitas' => 35,
                'keterangan' => 'Laboratorium Komputer 2',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ruang Kelas A101',
                'kapasitas' => 50,
                'keterangan' => 'Ruang kelas A101',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ruang Kelas A102',
                'kapasitas' => 45,
                'keterangan' => 'Ruang kelas A102',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ruang Kelas B201',
                'kapasitas' => 50,
                'keterangan' => 'Ruang kelas B201',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ruang Kelas B202',
                'kapasitas' => 45,
                'keterangan' => 'Ruang kelas B202',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Auditorium',
                'kapasitas' => 200,
                'keterangan' => 'Auditorium utama',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

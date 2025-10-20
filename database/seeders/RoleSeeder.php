<?php
// ============================================
// 1. ROLE SEEDER
// ============================================
// File: database/seeders/RoleSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insert([
            [
                'nama' => 'mahasiswa',
                'keterangan' => 'User yang merupakan mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'kaprodi',
                'keterangan' => 'Kepala Program Studi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'dekan',
                'keterangan' => 'Dekan Fakultas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'dosen',
                'keterangan' => 'Dosen Pengajar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'sekprodi',
                'keterangan' => 'Sekretaris Program Studi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'kosma',
                'keterangan' => 'Ketua Organisasi Mahasiswa (Perwakilan Kelas)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

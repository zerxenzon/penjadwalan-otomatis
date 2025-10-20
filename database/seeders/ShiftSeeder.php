<?php
// ============================================
// 8. SHIFT SEEDER
// ============================================
// File: database/seeders/ShiftSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shift')->insert([
            [
                'nama' => 'Pagi Reguler',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '12:00:00',
                'keterangan' => 'Shift pagi untuk kelas reguler (R)',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siang Non-Reguler',
                'jam_mulai' => '12:30:00',
                'jam_selesai' => '17:30:00',
                'keterangan' => 'Shift siang untuk kelas non-reguler (NR)',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Malam',
                'jam_mulai' => '18:00:00',
                'jam_selesai' => '21:00:00',
                'keterangan' => 'Shift malam',
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

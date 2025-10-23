<?php
// ============================================
// 2. STATUS SEEDER
// ============================================
// File: database/seeders/StatusSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'nama' => 'aktif',
                'keterangan' => 'Status aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'nonaktif',
                'keterangan' => 'Status nonaktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'pending',
                'keterangan' => 'Status menunggu approval',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'approved',
                'keterangan' => 'Status approved/disetujui',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'rejected',
                'keterangan' => 'Status rejected/ditolak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'draft',
                'keterangan' => 'Status draft/belum final',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert status satu per satu untuk menghindari error duplikasi
        foreach ($statuses as $status) {
            // Cek apakah status sudah ada
            if (!DB::table('status')->where('nama', $status['nama'])->exists()) {
                DB::table('status')->insert($status);
            }
        }
    }
}

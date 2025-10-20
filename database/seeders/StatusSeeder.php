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
        DB::table('status')->insert([
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
        ]);
    }
}

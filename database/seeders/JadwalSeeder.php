<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // Get IDs
        $statusAktif = DB::table('status')->where('nama', 'aktif')->first()?->id;
        
        // Get ruangan IDs
        $ruanganLabkom1 = DB::table('ruangan')->where('nama', 'Lab Komputer 1')->first()?->id;
        $ruanganLabkom2 = DB::table('ruangan')->where('nama', 'Lab Komputer 2')->first()?->id;
        
        // Get shift IDs
        $shiftPagi = DB::table('shift')->where('nama', 'Pagi Reguler')->first()?->id;
        $shiftSiang = DB::table('shift')->where('nama', 'Siang Non-Reguler')->first()?->id;

        if (!$statusAktif || !$ruanganLabkom1 || !$ruanganLabkom2 || !$shiftPagi || !$shiftSiang) {
            throw new \Exception('Required data missing in database');
        }

        $jadwalSlots = [
            // Senin pagi
            [
                'ruangan_id' => $ruanganLabkom1,
                'shift_id' => $shiftPagi,
                'hari' => 'senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '10:30:00',
                'status_id' => $statusAktif,
                'surat_tugas_mengajar_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Senin siang
            [
                'ruangan_id' => $ruanganLabkom2,
                'shift_id' => $shiftSiang,
                'hari' => 'senin',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:30:00',
                'status_id' => $statusAktif,
                'surat_tugas_mengajar_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Selasa pagi
            [
                'ruangan_id' => $ruanganLabkom1,
                'shift_id' => $shiftPagi,
                'hari' => 'selasa',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '10:30:00',
                'status_id' => $statusAktif,
                'surat_tugas_mengajar_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert jadwal slots satu per satu
        foreach ($jadwalSlots as $slot) {
            // Check if slot already exists
            if (!DB::table('jadwal')->where([
                'ruangan_id' => $slot['ruangan_id'],
                'shift_id' => $slot['shift_id'],
                'hari' => $slot['hari'],
                'jam_mulai' => $slot['jam_mulai']
            ])->exists()) {
                DB::table('jadwal')->insert($slot);
            }
        }
    }
}

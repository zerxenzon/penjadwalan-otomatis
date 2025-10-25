<?php

// ============================================
// DATABASE SEEDER - Data Awal
// ============================================

// File: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,    // 1. Status harus pertama
            RoleSeeder::class,      // 2. Role kedua
            UserSeeder::class,      // 3. User ketiga (perlu Role & Status)
            ProdiSeeder::class,     // 4. Prodi (perlu Status)
            AngkatanSeeder::class,  // 5. Angkatan (perlu Status)
            SemesterSeeder::class,  // 6. Semester (perlu Status) 
            ShiftSeeder::class,     // 7. Shift (perlu Status)
            MataKuliahSeeder::class,// 8. MataKuliah (perlu Prodi & Status)
            RuanganSeeder::class,   // 9. Ruangan (perlu Status)
            KelasSeeder::class,     // 10. Kelas (perlu semua di atas)
            BiodataSeeder::class,   // 11. Biodata (perlu User & Kelas)
            JadwalSeeder::class,    // 12. Jadwal kosong
            BarterJadwalSeeder::class // 13. Sample data barter
        ]);
    }
}

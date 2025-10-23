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
            BiodataSeeder::class,   // 4. Biodata (perlu User)
            ProdiSeeder::class,     // 5. Prodi (perlu Status)
            AngkatanSeeder::class,  // 6. Angkatan (perlu Status)
            SemesterSeeder::class,  // 7. Semester (perlu Status) 
            ShiftSeeder::class,     // 8. Shift (perlu Status)
            MataKuliahSeeder::class,// 9. MataKuliah (perlu Prodi & Status)
            RuanganSeeder::class,   // 10. Ruangan (perlu Status)
            KelasSeeder::class,     // 11. Kelas (perlu semua di atas)
            JadwalSeeder::class,    // 12. Jadwal kosong
            BarterJadwalSeeder::class // 13. Sample data barter
        ]);
    }
}

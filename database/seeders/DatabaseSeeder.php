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
            RoleSeeder::class,
            StatusSeeder::class,
            UserSeeder::class,
            BiodataSeeder::class,
            ProdiSeeder::class,
            AngkatanSeeder::class,
            SemesterSeeder::class,
            ShiftSeeder::class,
            MataKuliahSeeder::class,
            RuanganSeeder::class,
            KelasSeeder::class,
        ]);
    }
}

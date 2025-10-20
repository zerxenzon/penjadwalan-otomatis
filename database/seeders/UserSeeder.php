<?php
// ============================================
// 3. USER SEEDER
// ============================================
// File: database/seeders/UserSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user')->insert([
            // Dekan
            [
                'nama' => 'Ruuqi',
                'username' => 'dekan123',
                'email' => 'dekan@gmail.com',
                'password' => Hash::make('dekan123'),
                'role_id' => 3, // Dekan
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kaprodi
            [
                'nama' => 'Ruuqi',
                'username' => 'kaprodi123',
                'email' => 'kaprodi@gmail.com',
                'password' => Hash::make('kaprodi123'),
                'role_id' => 2, // Kaprodi
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen 1
            [
                'nama' => 'Ruuqi',
                'username' => 'dosen123',
                'email' => 'dosen@gmail.com',
                'password' => Hash::make('dosen123'),
                'role_id' => 4, // Dosen
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen 2
            [
                'nama' => 'Ruuqi',
                'username' => 'dosen_ridwan',
                'email' => 'ridwan@gmail.com',
                'password' => Hash::make('dosen123'),
                'role_id' => 4, // Dosen
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen 3
            [
                'nama' => 'Ruuqi',
                'username' => 'nurjaman12',
                'email' => 'nurjaman@gmail.com',
                'password' => Hash::make('nurjaman12'),
                'role_id' => 4, // Dosen
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KOSMA 1 (Perwakilan Kelas SI-R-SM3)
            [
                'nama' => 'Ruuqi',
                'username' => 'kosma123',
                'email' => 'kosma1@example.com',
                'password' => Hash::make('kosma123'),
                'role_id' => 6, // KOSMA
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KOSMA 2 (Perwakilan Kelas SI-NR-SM3)
            [
                'nama' => 'Putri',
                'username' => 'kosma_putri',
                'email' => 'kosma2@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 6, // KOSMA
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mahasiswa 1
            [
                'nama' => 'Ruuqi',
                'username' => 'mahasiswa123',
                'email' => 'ade@example.com',
                'password' => Hash::make('mahasiswa123'),
                'role_id' => 1, // Mahasiswa
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mahasiswa 2
            [
                'nama' => 'Bima Sakti',
                'username' => 'mhs_bima',
                'email' => 'bima@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Mahasiswa
                'status_id' => 1, // Aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
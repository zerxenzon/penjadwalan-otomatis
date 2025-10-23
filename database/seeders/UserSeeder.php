<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // 1. Dekan
            [
                'nama' => 'Dr. Satria',
                'username' => 'dekan123',
                'email' => 'dekan@ruuqi.ac.id',
                'password' => Hash::make('dekan123'),
                'role_id' => 3, // dekan
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 2. Kaprodi
            [
                'nama' => 'Dr. Budi Santoso',
                'username' => 'kaprodi123', 
                'email' => 'kaprodi@ruuqi.ac.id',
                'password' => Hash::make('kaprodi123'),
                'role_id' => 2, // kaprodi
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambah Sekprodi setelah Kaprodi
            [
                'nama' => 'Dr. Ani Sekprodi', 
                'username' => 'sekprodi123',
                'email' => 'sekprodi@ruuqi.ac.id',
                'password' => Hash::make('sekprodi123'),
                'role_id' => 5, // sekprodi
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3. Dosen
            [
                'nama' => 'Dr. Ahmad',
                'username' => 'dosen123',
                'email' => 'dosen@ruuqi.ac.id', 
                'password' => Hash::make('dosen123'),
                'role_id' => 4, // dosen
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 4. Muhammad Nurjaman
            [
                'nama' => 'Muhammad Nurjaman, M.Kom',
                'username' => 'dosen1234',
                'email' => 'muhammadnurjaman50@ruuqi.ac.id',
                'password' => Hash::make('dosen1234'),
                'role_id' => 4, // dosen
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 5. Muhammad Nurjaman
            [
                'nama' => 'Iin Sholihin .M.Kom',
                'username' => 'dosen12345',
                'email' => 'iinsholihin@ruuqi.ac.id',
                'password' => Hash::make('dosen12345'),
                'role_id' => 4, // dosen
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 5. KOSMA
            [
                'nama' => 'Agus Mahasiswa',
                'username' => 'kosma123',
                'email' => 'kosma@ruuqi.ac.id',
                'password' => Hash::make('kosma123'), 
                'role_id' => 6, // kosma
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 6. Wakil KOSMA
            [
                'nama' => 'Budi Mahasiswa',
                'username' => 'wakilkosma123',
                'email' => 'wakilkosma@ruuqi.ac.id',
                'password' => Hash::make('wakilkosma123'),
                'role_id' => 6, // kosma
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 7. Mahasiswa
            [
                'nama' => 'Cahya Mahasiswa',
                'username' => 'mahasiswa123',
                'email' => 'mahasiswa@ruuqi.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role_id' => 1, // mahasiswa
                'status_id' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert user satu per satu untuk menghindari error duplikasi
        foreach ($users as $user) {
            // Cek apakah user dengan username tersebut sudah ada
            if (!DB::table('user')->where('username', $user['username'])->exists()) {
                DB::table('user')->insert($user);
            }
        }
    }
}
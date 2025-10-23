<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BiodataSeeder extends Seeder
{
    public function run(): void
    {
        $biodatas = [
            // Dekan (user_id: 1)
            [
                'user_id' => 1,
                'nip' => '195508121980031001',
                'nidn' => '195508121980',
                'nik' => '3216052005080001',
                'alamat' => 'Jl. Pendidikan No. 1, Bandung',
                'nomor_telepon' => '082112345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1955-08-12',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kaprodi (user_id: 2)
            [
                'user_id' => 2,
                'nip' => '197203141997031002',
                'nidn' => '197203141997',
                'nik' => '3216052002140002',
                'alamat' => 'Jl. Universitas No. 45, Bandung',
                'nomor_telepon' => '082212345678',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1972-03-14',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sekprodi (user_id: 3)
            [
                'user_id' => 3,
                'nip' => '197501012000032001',
                'nidn' => '0101017501',
                'nik' => '3275014101750001',
                'alamat' => 'Jl. Sukabirus No. 10, Bandung',
                'nomor_telepon' => '08123456789',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1975-01-01',
                'gender' => 'P',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen - Dr. Ahmad (user_id: 4)
            [
                'user_id' => 4,
                'nip' => '197901151994031003',
                'nidn' => '197901151994',
                'nik' => '3216051979015003',
                'alamat' => 'Jl. Cisangkuy No. 12, Bandung',
                'nomor_telepon' => '082312345678',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1979-01-15',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen - Muhammad Nurjaman (user_id: 5)
            [
                'user_id' => 5,
                'nip' => '198507302015041001',
                'nidn' => '198507302015',
                'nik' => '3216051985073001',
                'alamat' => 'Jl. Sunan Kalijaga No. 15, Bandung',
                'nomor_telepon' => '082387654321',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-07-30',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen - Iin Sholihin (user_id: 6)
            [
                'user_id' => 6,
                'nip' => '198005122006041002',
                'nidn' => '0112058003',
                'nik' => '3216051980051002',
                'alamat' => 'Jl. Sukajadi No. 88, Bandung',
                'nomor_telepon' => '082512345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1980-05-12',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KOSMA - Agus Mahasiswa (user_id: 7)
            [
                'user_id' => 7,
                'nip' => null,
                'nidn' => null,
                'nik' => '3216051969021004',
                'alamat' => 'Jl. Setiabudhi No. 250, Bandung',
                'nomor_telepon' => '082412345678',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2003-02-10',
                'gender' => 'L',
                'agama' => 'I',
                'kelas_id' => 1, // Assign ke kelas pertama untuk akses jadwal
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KOSMA - Budi Mahasiswa (user_id: 8)
            [
                'user_id' => 8,
                'nip' => null,
                'nidn' => null,
                'nik' => '3216051980051005',
                'alamat' => 'Jl. Dago No. 88, Bandung',
                'nomor_telepon' => '082612345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-05-12',
                'gender' => 'L',
                'agama' => 'I',
                'kelas_id' => 1, // Assign ke kelas pertama untuk akses jadwal
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mahasiswa - Cahya Mahasiswa (user_id: 12)
            [
                'user_id' => 12,
                'nip' => null,
                'nidn' => null,
                'nik' => '3216052003101006',
                'alamat' => 'Jl. Astana Anyar No. 15, Bandung',
                'nomor_telepon' => '081912345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-10-10',
                'gender' => 'L',
                'agama' => 'I',
                'kelas_id' => 1, // Assign ke kelas pertama untuk akses jadwal
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert biodata one by one to prevent duplicate entries
        foreach ($biodatas as $biodata) {
            // Check if biodata for this user already exists
            if (!DB::table('biodata')->where('user_id', $biodata['user_id'])->exists()) {
                DB::table('biodata')->insert($biodata);
            }
        }
    }
}

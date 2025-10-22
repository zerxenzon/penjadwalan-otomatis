<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BiodataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('biodata')->insert([
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

            // Dosen (user_id: 3)
            [
                'user_id' => 3,
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
            // Muhammad Nurjaman (user_id: 4)
            [
                'user_id' => 4,
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

            // Kosma (user_id: 5)
            [
                'user_id' => 5,
                'nip' => null,
                'nidn' => null,
                'nik' => '3216051969021004',
                'alamat' => 'Jl. Setiabudhi No. 250, Bandung',
                'nomor_telepon' => '082412345678',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2003-02-10',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Wakil Kosma (user_id: 6)
            [
                'user_id' => 6,
                'nip' => null,
                'nidn' => null,
                'nik' => '3216051980051005',
                'alamat' => 'Jl. Dago No. 88, Bandung',
                'nomor_telepon' => '082512345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-05-12',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mahasiswa (user_id: 7)
            [
                'user_id' => 7,
                'nip' => null,
                'nidn' => null,
                'nik' => '3216052003101006',
                'alamat' => 'Jl. Astana Anyar No. 15, Bandung',
                'nomor_telepon' => '081912345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-10-10',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

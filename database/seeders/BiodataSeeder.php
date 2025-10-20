<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BiodataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('biodata')->insert([
            // Dekan
            [
                'user_id' => 1,
                'nip' => '195508121980031001',
                'nik' => '3216052005080010',
                'alamat' => 'Jl. Pendidikan No. 1, Bandung',
                'nomor_telepon' => '082112345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1955-08-12',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kaprodi
            [
                'user_id' => 2,
                'nip' => '197203141997031002',
                'nik' => '3216052002140010',
                'alamat' => 'Jl. Universitas No. 45, Bandung',
                'nomor_telepon' => '082212345678',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1972-03-14',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen 1
            [
                'user_id' => 3,
                'nip' => '197901151994031003',
                'nik' => '3216051979015001',
                'alamat' => 'Jl. Cisangkuy No. 12, Bandung',
                'nomor_telepon' => '082312345678',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1979-01-15',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen 2
            [
                'user_id' => 4,
                'nip' => '196902101990032001',
                'nik' => '3216051969021001',
                'alamat' => 'Jl. Setiabudhi No. 250, Bandung',
                'nomor_telepon' => '082412345678',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1969-02-10',
                'gender' => 'P',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dosen 3
            [
                'user_id' => 5,
                'nip' => '198005121999031001',
                'nik' => '3216051980051201',
                'alamat' => 'Jl. Dago No. 88, Bandung',
                'nomor_telepon' => '082512345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1980-05-12',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KOSMA 1
            [
                'user_id' => 6,
                'nip' => null,
                'nik' => '3216052003101001',
                'alamat' => 'Jl. Astana Anyar No. 15, Bandung',
                'nomor_telepon' => '081912345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-10-10',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KOSMA 2
            [
                'user_id' => 7,
                'nip' => null,
                'nik' => '3216052004051502',
                'alamat' => 'Jl. Riau No. 23, Bandung',
                'nomor_telepon' => '081812345678',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2004-05-15',
                'gender' => 'P',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mahasiswa 1
            [
                'user_id' => 8,
                'nip' => null,
                'nik' => '3216052004011501',
                'alamat' => 'Jl. Pasir Kaliki No. 50, Bandung',
                'nomor_telepon' => '081711345678',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2004-01-15',
                'gender' => 'L',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mahasiswa 2
            [
                'user_id' => 9,
                'nip' => null,
                'nik' => '3216052005081202',
                'alamat' => 'Jl. Cihampelas No. 79, Bandung',
                'nomor_telepon' => '081611345678',
                'tempat_lahir' => 'Cirebon',
                'tanggal_lahir' => '2005-08-12',
                'gender' => 'P',
                'agama' => 'I',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

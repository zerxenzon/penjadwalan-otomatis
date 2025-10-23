<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Biodata;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\SuratTugasMengajar;
use App\Models\Jadwal;
use App\Models\Status;

class BarterJadwalSeeder extends Seeder
{
    public function run()
    {
        // Create dosen role if not exists
        $role = Role::firstOrCreate(
            ['nama' => 'dosen'],
            ['keterangan' => 'Dosen pengajar']
        );

        // Create active status if not exists
        $status = Status::firstOrCreate(
            ['nama' => 'aktif'],
            ['keterangan' => 'Status aktif']
        );

        // Create some sample dosen
        $dosen1 = User::create([
            'nama' => 'Dosen Sample 1',
            'username' => 'dosen1',
            'email' => 'dosen1@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'status_id' => $status->id,
        ]);

        Biodata::create([
            'user_id' => $dosen1->id,
            'nip' => '198001012025011001',
            'nidn' => '0101018001',
            'nik' => '3101010101800001',
            'gender' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'alamat' => 'Jakarta',
            'nomor_telepon' => '08123456789',
            'agama' => 'I',
        ]);

        $dosen2 = User::create([
            'nama' => 'Dosen Sample 2',
            'username' => 'dosen2',
            'email' => 'dosen2@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'status_id' => $status->id,
        ]);

        Biodata::create([
            'user_id' => $dosen2->id,
            'nip' => '198501012025012001',
            'nidn' => '0101018502',
            'nik' => '3201010101850002',
            'gender' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1985-01-01',
            'alamat' => 'Bandung',
            'nomor_telepon' => '08987654321',
            'agama' => 'I',
        ]);

        // Get existing mata kuliah
        $matkul1 = MataKuliah::where('kode', 'MK001')->first(); // Pemrograman Web 2
        $matkul2 = MataKuliah::where('kode', 'MK002')->first(); // Basis Data Lanjut

        // Get existing kelas
        $kelas1 = Kelas::where('nama', 'SI-R-SM3-20251')->first();
        $kelas2 = Kelas::where('nama', 'SI-NR-SM3-20251')->first();

        // Get semester with kode_semester 20251
        $semester = \App\Models\Semester::where('kode_semester', 20251)->first();

        // Create surat tugas mengajar
        $stm1 = SuratTugasMengajar::create([
            'dosen_id' => $dosen1->id,
            'mata_kuliah_id' => $matkul1->id,
            'kelas_id' => $kelas1->id,
            'semester_id' => $semester->id,
            'nomor_surat' => '001/STM/2024',
            'status_id' => $status->id,
        ]);

        $stm2 = SuratTugasMengajar::create([
            'dosen_id' => $dosen2->id,
            'mata_kuliah_id' => $matkul2->id,
            'kelas_id' => $kelas2->id,
            'semester_id' => $semester->id,
            'nomor_surat' => '002/STM/2024',
            'status_id' => $status->id,
        ]);

        // Get existing ruangan and shift
        $ruanganPagi = \App\Models\Ruangan::where('nama', 'Lab Komputer 1')->first();
        $ruanganSiang = \App\Models\Ruangan::where('nama', 'Lab Komputer 2')->first();
        $shiftPagi = \App\Models\Shift::where('nama', 'Pagi Reguler')->first();
        $shiftSiang = \App\Models\Shift::where('nama', 'Siang Non-Reguler')->first();

        // Create jadwal
        Jadwal::create([
            'surat_tugas_mengajar_id' => $stm1->id,
            'ruangan_id' => $ruanganPagi->id,
            'shift_id' => $shiftPagi->id,
            'hari' => 'senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:30',
            'status_id' => $status->id,
        ]);

        Jadwal::create([
            'surat_tugas_mengajar_id' => $stm2->id,
            'ruangan_id' => $ruanganSiang->id,
            'shift_id' => $shiftSiang->id,
            'hari' => 'selasa',
            'jam_mulai' => '13:00',
            'jam_selesai' => '15:30',
            'status_id' => $status->id,
        ]);
    }
}
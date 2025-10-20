<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Kelas;
use App\Models\SuratTugasMengajar;
use App\Models\BarterJadwal;
use App\Models\PindahJadwal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard Dekan
     */
    public function dekan()
    {
        $dosenRoleId = \App\Models\Role::where('nama', 'dosen')->first()->id ?? null;
        $mahasiswaRoleId = \App\Models\Role::where('nama', 'mahasiswa')->first()->id ?? null;

        $data = [
            'total_dosen' => \App\Models\User::where('role_id', $dosenRoleId)->count(),
            'total_mahasiswa' => \App\Models\User::where('role_id', $mahasiswaRoleId)->count(),
            'total_mata_kuliah' => MataKuliah::count(),
            'total_kelas' => Kelas::count(),
            'surat_tugas_pending' => SuratTugasMengajar::where('status_id', 3)->count(),
            'barter_pending' => BarterJadwal::where('status_id', 3)->count(),
            'pindah_pending' => PindahJadwal::where('status_id', 3)->count(),
        ];

        return view('dashboard.dekan', $data);
    }

    /**
     * Dashboard Kaprodi
     */
    public function kaprodi()
    {
        $roleId = \App\Models\Role::where('nama', 'kaprodi')->first()->id ?? null;
        $dosenRoleId = \App\Models\Role::where('nama', 'dosen')->first()->id ?? null;
        $mahasiswaRoleId = \App\Models\Role::where('nama', 'mahasiswa')->first()->id ?? null;

        $data = [
            'total_dosen' => \App\Models\User::where('role_id', $dosenRoleId)->count(),
            'total_mahasiswa' => \App\Models\User::where('role_id', $mahasiswaRoleId)->count(),
            'total_mata_kuliah' => MataKuliah::count(),
            'total_kelas' => Kelas::count(),
            'surat_tugas_draft' => SuratTugasMengajar::where('status_id', 6)->count(),
            'barter_pending' => BarterJadwal::where('status_id', 3)->count(),
        ];

        return view('dashboard.kaprodi', $data);
    }

    /**
     * Dashboard Dosen
     */
    public function dosen()
    {
    $dosenId = \Illuminate\Support\Facades\Auth::id();

        $data = [
            'total_surat_tugas' => SuratTugasMengajar::where('dosen_id', $dosenId)->count(),
            'total_jadwal' => Jadwal::whereHas('suratTugasMengajar', function($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            })->count(),
            'barter_masuk' => BarterJadwal::where('dosen_tujuan_id', $dosenId)
                ->where('status_id', 3)
                ->count(),
            'barter_keluar' => BarterJadwal::where('dosen_pengaju_id', $dosenId)
                ->where('status_id', 3)
                ->count(),
            'jadwal_minggu_ini' => Jadwal::whereHas('suratTugasMengajar', function($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            })->get(),
        ];

        return view('dashboard.dosen', $data);
    }

    /**
     * Dashboard KOSMA
     */
    public function kosma()
    {
        $data = [
            'pindah_pending' => PindahJadwal::where('kosma_id', \Illuminate\Support\Facades\Auth::id())
                ->where('status_id', 3)
                ->count(),
            'pindah_approved' => PindahJadwal::where('kosma_id', \Illuminate\Support\Facades\Auth::id())
                ->where('status_id', 4)
                ->count(),
            'pindah_rejected' => PindahJadwal::where('kosma_id', \Illuminate\Support\Facades\Auth::id())
                ->where('status_id', 5)
                ->count(),
        ];

        return view('dashboard.kosma', $data);
    }

    /**
     * Dashboard Mahasiswa
     */
    public function mahasiswa()
    {
        // Ambil kelas dari biodata atau relasi lainnya
        $data = [
            'jadwal_kelas' => Jadwal::all(), // Simplified, nanti bisa di-filter per kelas
        ];

        return view('dashboard.mahasiswa', $data);
    }

    /**
     * Dashboard Sekprodi
     */
    public function sekprodi()
    {
        $dosenRoleId = \App\Models\Role::where('nama', 'dosen')->first()->id ?? null;
        
        $data = [
            'total_dosen' => \App\Models\User::where('role_id', $dosenRoleId)->count(),
            'total_mata_kuliah' => MataKuliah::count(),
            'total_ruangan' => Ruangan::count(),
        ];

        return view('dashboard.sekprodi', $data);
    }
}

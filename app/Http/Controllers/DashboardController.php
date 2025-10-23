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

        // Ambil STM yang baru di-approve (dalam 7 hari terakhir)
        $recentApprovedSTM = SuratTugasMengajar::where('dosen_id', $dosenId)
            ->where('status_id', 4) // approved
            ->where('updated_at', '>=', now()->subDays(7))
            ->with(['mataKuliah', 'kelas', 'semester'])
            ->latest('updated_at')
            ->get();

        $data = [
            'total_surat_tugas' => SuratTugasMengajar::where('dosen_id', $dosenId)->count(),
            'surat_tugas_approved' => SuratTugasMengajar::where('dosen_id', $dosenId)
                ->where('status_id', 4)
                ->count(),
            'surat_tugas_pending' => SuratTugasMengajar::where('dosen_id', $dosenId)
                ->where('status_id', 3)
                ->count(),
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
            'recent_approved_stm' => $recentApprovedSTM, // Notifikasi STM yang baru di-approve
        ];

        return view('dashboard.dosen', $data);
    }

    /**
     * Dashboard KOSMA
     */
    public function kosma()
    {
        $kosmaId = \Illuminate\Support\Facades\Auth::id();
        
        // Ambil permintaan pindah jadwal yang baru (dalam 7 hari terakhir, status pending)
        $recentPindahRequests = PindahJadwal::with([
            'dosen',
            'jadwalLama.suratTugasMengajar.mataKuliah',
            'jadwalLama.suratTugasMengajar.kelas',
            'jadwalBaru.ruangan'
        ])
        ->where('kosma_id', $kosmaId)
        ->where('status_id', 3) // pending
        ->where('created_at', '>=', now()->subDays(7))
        ->latest('created_at')
        ->get();
        
        $data = [
            'pindah_pending' => PindahJadwal::where('kosma_id', $kosmaId)
                ->where('status_id', 3)
                ->count(),
            'pindah_approved' => PindahJadwal::where('kosma_id', $kosmaId)
                ->where('status_id', 4)
                ->count(),
            'pindah_rejected' => PindahJadwal::where('kosma_id', $kosmaId)
                ->where('status_id', 5)
                ->count(),
            'recent_requests' => $recentPindahRequests, // Notifikasi permintaan baru
        ];

        return view('dashboard.kosma', $data);
    }

    /**
     * KOSMA - Lihat Jadwal Kelas
     */
    public function kosmaJadwalKelas()
    {
        $kosma = \Illuminate\Support\Facades\Auth::user();
        
        // Cari kelas yang di-manage oleh KOSMA ini
        // Asumsi: KOSMA memiliki kelas_id di biodata
        $kelasId = $kosma->biodata->kelas_id ?? null;
        
        if (!$kelasId) {
            return redirect()->back()->with('error', 'Anda belum terdaftar sebagai KOSMA untuk kelas tertentu.');
        }
        
        // Ambil jadwal kelas KOSMA secara realtime
        $jadwalKelas = Jadwal::whereHas('suratTugasMengajar.kelas', function($query) use ($kelasId) {
            $query->where('kelas.id', $kelasId);
        })
        ->with([
            'suratTugasMengajar.dosen',
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.kelas',
            'ruangan',
            'shift'
        ])
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get();
        
        // Group by hari untuk tampilan yang lebih rapi
        $jadwalGrouped = $jadwalKelas->groupBy('hari');
        
        $kelas = \App\Models\Kelas::find($kelasId);
        
        return view('kosma.jadwal-kelas', compact('jadwalGrouped', 'kelas'));
    }

    /**
     * Dashboard Mahasiswa
     */
    public function mahasiswa()
    {
        $controller = new DashboardMahasiswaController();
        return $controller->index();
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

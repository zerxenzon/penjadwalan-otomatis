<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Biodata;
use App\Models\PindahJadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $biodata = Biodata::where('user_id', $user->id)->first();
        
        // Check if biodata exists and has kelas_id
        if (!$biodata || !$biodata->kelas_id) {
            return view('dashboard.mahasiswa', [
                'jadwalList' => collect([]),
                'jadwalGrouped' => collect([]),
                'recentChanges' => collect([]),
                'kelas' => null,
                'error' => 'Data biodata atau kelas Anda belum lengkap. Silakan hubungi admin untuk melengkapi data.'
            ]);
        }
        
        // Get jadwal for student's class
        $jadwalList = Jadwal::whereHas('suratTugasMengajar.kelas', function($query) use ($biodata) {
            $query->where('id', $biodata->kelas_id);
        })
        ->with([
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.dosen',
            'suratTugasMengajar.kelas',
            'ruangan'
        ])
        ->orderBy('hari', 'asc')
        ->orderBy('jam_mulai', 'asc')
        ->get();
        
        // Group jadwal by hari untuk tampilan kalender
        $jadwalGrouped = $jadwalList->groupBy('hari');
        
        // Get recent jadwal changes (pindah jadwal yang approved dalam 7 hari terakhir untuk kelas ini)
        $recentChanges = PindahJadwal::whereHas('jadwalLama.suratTugasMengajar.kelas', function($query) use ($biodata) {
            $query->where('id', $biodata->kelas_id);
        })
        ->where('status_id', 4) // approved
        ->where('updated_at', '>=', now()->subDays(7))
        ->with([
            'jadwalLama.suratTugasMengajar.mataKuliah',
            'jadwalBaru.ruangan',
            'dosen'
        ])
        ->latest('updated_at')
        ->get();
        
        $kelas = \App\Models\Kelas::find($biodata->kelas_id);

        return view('dashboard.mahasiswa', compact('jadwalList', 'jadwalGrouped', 'recentChanges', 'kelas'));
    }
    
    /**
     * Export jadwal to PDF
     */
    public function exportPdf()
    {
        $user = Auth::user();
        $biodata = Biodata::where('user_id', $user->id)->first();
        
        if (!$biodata || !$biodata->kelas_id) {
            return redirect()->back()->with('error', 'Data biodata atau kelas Anda belum lengkap.');
        }
        
        $jadwalList = Jadwal::whereHas('suratTugasMengajar.kelas', function($query) use ($biodata) {
            $query->where('id', $biodata->kelas_id);
        })
        ->with([
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.dosen',
            'suratTugasMengajar.kelas',
            'ruangan'
        ])
        ->orderBy('hari', 'asc')
        ->orderBy('jam_mulai', 'asc')
        ->get();
        
        $jadwalGrouped = $jadwalList->groupBy('hari');
        $kelas = \App\Models\Kelas::find($biodata->kelas_id);
        $mahasiswa = $user;
        
        $pdf = Pdf::loadView('mahasiswa.jadwal-pdf', compact('jadwalGrouped', 'kelas', 'mahasiswa'));
        
        return $pdf->download('jadwal-kuliah-' . $kelas->nama . '.pdf');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\SuratTugasMengajar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SuratTugasMengajarPDFController extends Controller
{
    public function generate(SuratTugasMengajar $suratTugas)
    {
        // Load surat tugas dengan relasi
        $suratTugas->load([
            'dosen.biodata',
            'mataKuliah.prodi',
            'kelas',
            'semester'
        ]);

        // Ambil semua surat tugas untuk dosen dan semester yang sama
        $allSuratTugas = SuratTugasMengajar::where('dosen_id', $suratTugas->dosen_id)
            ->where('semester_id', $suratTugas->semester_id)
            ->where('status_id', $suratTugas->status_id)
            ->with(['mataKuliah.prodi', 'kelas'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('surat-tugas.pdf', [
            'suratTugas' => $suratTugas,
            'mataKuliahList' => $allSuratTugas
        ]);

        $pdf->setPaper('a4');
        
        $fileName = 'ST-' . str_replace(' ', '-', $suratTugas->dosen->nama) . '-' . $suratTugas->semester->kode_semester . '.pdf';
        
        return $pdf->stream($fileName);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\SuratTugasMengajar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SuratTugasMengajarPDFController extends Controller
{
    public function generate(SuratTugasMengajar $suratTugas)
    {
        $pdf = PDF::loadView('surat-tugas.pdf', [
            'suratTugas' => $suratTugas->load([
                'dosen.biodata',
                'mataKuliah',
                'kelas',
                'semester'
            ])
        ]);

        $pdf->setPaper('a4');
        
        return $pdf->stream('surat-tugas-mengajar.pdf');
    }
}
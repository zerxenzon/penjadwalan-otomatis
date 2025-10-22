<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Biodata;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $biodata = Biodata::where('user_id', $user->id)->first();
        
        // Get jadwal for student's class
        $jadwalList = Jadwal::whereHas('suratTugasMengajar.kelas', function($query) use ($biodata) {
            $query->where('id', $biodata->kelas_id);
        })
        ->with([
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.dosen.biodata',
            'ruangan'
        ])
        ->orderBy('hari', 'asc')
        ->orderBy('jam_mulai', 'asc')
        ->get();

        return view('dashboard.mahasiswa', compact('jadwalList'));
    }
}
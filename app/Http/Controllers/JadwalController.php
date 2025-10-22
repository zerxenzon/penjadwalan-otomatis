<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwalList = Jadwal::whereHas('suratTugasMengajar', function($query) {
                $query->where('dosen_id', Auth::id());
            })
            ->with(['suratTugasMengajar.mataKuliah', 'suratTugasMengajar.kelas', 'ruangan', 'shift'])
            ->get();
                           
        return view('jadwal.index', compact('jadwalList'));
    }
}

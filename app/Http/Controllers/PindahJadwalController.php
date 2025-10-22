<?php

namespace App\Http\Controllers;

use App\Models\PindahJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PindahJadwalController extends Controller
{
    public function index()
    {
        $pindahJadwalList = PindahJadwal::where('kosma_id', Auth::id())
            ->with([
                'jadwalLama.suratTugasMengajar.mataKuliah',
                'jadwalLama.suratTugasMengajar.kelas',
                'jadwalLama.ruangan',
                'jadwalBaru.suratTugasMengajar.mataKuliah',
                'jadwalBaru.suratTugasMengajar.kelas',
                'jadwalBaru.ruangan',
                'status'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pindah-jadwal.index', compact('pindahJadwalList'));
    }

    public function updateStatus(Request $request, PindahJadwal $pindahJadwal)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id'
        ]);

        $pindahJadwal->update([
            'status_id' => $request->status_id
        ]);

        return redirect()->route('pindah-jadwal.index')
            ->with('success', 'Status permintaan pindah jadwal berhasil diperbarui');
    }
}
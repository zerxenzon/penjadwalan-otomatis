<?php

namespace App\Http\Controllers;

use App\Models\BarterJadwal;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarterJadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $barterList = BarterJadwal::where('dosen_pengaju_id', $user->id)
            ->orWhere('dosen_tujuan_id', $user->id)
            ->with(['dosenPengaju.biodata', 'dosenTujuan.biodata', 
                   'jadwalPengaju.mataKuliah', 'jadwalPengaju.kelas', 'jadwalPengaju.shift',
                   'jadwalTujuan.mataKuliah', 'jadwalTujuan.kelas', 'jadwalTujuan.shift'])
            ->orderBy('created_at', 'desc')
            ->get();

        $jadwalSaya = Jadwal::whereHas('suratTugasMengajar', function($query) use ($user) {
                $query->where('dosen_id', $user->id);
            })
            ->with(['suratTugasMengajar.mataKuliah', 'suratTugasMengajar.kelas', 'shift'])
            ->get();

        $dosenList = User::whereHas('role', function($query) {
            $query->where('nama', 'dosen');
        })->where('id', '!=', Auth::id())
          ->with('biodata')
          ->get();

        return view('barter-jadwal.index', compact('barterList', 'jadwalSaya', 'dosenList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'dosen_tujuan_id' => 'required|exists:user,id',
            'jadwal_tujuan_id' => 'required|exists:jadwal,id',
            'alasan' => 'required|string'
        ]);

        BarterJadwal::create([
            'dosen_pengaju_id' => Auth::id(),
            'dosen_tujuan_id' => $request->dosen_tujuan_id,
            'jadwal_pengaju_id' => $request->jadwal_id,
            'jadwal_tujuan_id' => $request->jadwal_tujuan_id,
            'alasan' => $request->alasan,
            'status_id' => 1 // 1 = pending
        ]);

        return redirect()->route('barter-jadwal.index')
            ->with('success', 'Pengajuan barter jadwal berhasil dibuat');
    }

    public function updateStatus(Request $request, BarterJadwal $barterJadwal)
    {
        $request->validate([
            'status_id' => 'required|in:2,3', // 2 = disetujui, 3 = ditolak
        ]);

        if ($barterJadwal->dosen_tujuan_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengubah status barter jadwal ini.');
        }

        $barterJadwal->update([
            'status_id' => $request->status_id
        ]);

        $status = $request->status_id == 2 ? 'disetujui' : 'ditolak';
        return redirect()->route('barter-jadwal.index')
            ->with('success', "Pengajuan barter jadwal telah $status");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BarterJadwal;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BarterJadwalController extends Controller
{
    /**
     * Validate ownership of jadwal before barter
     */
    protected function validateJadwalOwnership($jadwalId, $userId)
    {
        $jadwal = Jadwal::whereHas('suratTugasMengajar', function($q) use ($userId) {
            $q->where('dosen_id', $userId);
        })->find($jadwalId);

        if (!$jadwal) {
            throw new Exception('Jadwal yang dipilih bukan milik Anda atau tidak ditemukan.');
        }

        return $jadwal;
    }

    /**
     * Validate barter request ownership
     */
    protected function validateBarterOwnership(BarterJadwal $barterJadwal)
    {
        $userId = Auth::id();
        
        if ($barterJadwal->dosen_pengaju_id !== $userId && $barterJadwal->dosen_tujuan_id !== $userId) {
            abort(403, 'Anda tidak memiliki akses ke permintaan barter ini.');
        }
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get jadwal for current user
        $jadwalSaya = Jadwal::with([
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.kelas',
            'shift',
            'ruangan'
        ])
        ->whereHas('suratTugasMengajar', function($q) use ($user) {
            $q->where('dosen_id', $user->id);
        })->get();

        // Get other dosen list except current user
        $dosenList = User::whereHas('role', function($q) {
            $q->where('nama', 'dosen');
        })
        ->where('id', '!=', $user->id)
        ->with('biodata')
        ->get();

        // Get barter requests - PERBAIKAN: Gunakan field yang benar
        $barterList = BarterJadwal::with([
            'jadwalA.suratTugasMengajar.mataKuliah',
            'jadwalA.suratTugasMengajar.kelas',
            'jadwalA.ruangan',
            'jadwalB.suratTugasMengajar.mataKuliah',
            'jadwalB.suratTugasMengajar.kelas', 
            'jadwalB.ruangan',
            'dosenPengaju.biodata',
            'dosenTujuan.biodata',
            'status'
        ])
        ->where(function($q) use ($user) {
            $q->where('dosen_pengaju_id', $user->id)
              ->orWhere('dosen_tujuan_id', $user->id);
        })
        ->latest()
        ->get();

        return view('barter-jadwal.index', compact('barterList', 'jadwalSaya', 'dosenList'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Get jadwal for current user
        $jadwalSaya = Jadwal::with([
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.kelas',
            'shift',
            'ruangan'
        ])
        ->whereHas('suratTugasMengajar', function($q) use ($user) {
            $q->where('dosen_id', $user->id);
        })->get();

        // Get other dosen list except current user
        $dosenList = User::whereHas('role', function($q) {
            $q->where('nama', 'dosen');
        })
        ->where('id', '!=', $user->id)
        ->with('biodata')
        ->get();

        return view('barter-jadwal.form', compact('jadwalSaya', 'dosenList'));
    }

    public function getJadwalDosen($id)
    {
        $jadwalList = Jadwal::with([
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.kelas',
            'ruangan'
        ])
        ->whereHas('suratTugasMengajar', function($q) use ($id) {
            $q->where('dosen_id', $id);
        })
        ->get()
        ->map(function($jadwal) {
            return [
                'id' => $jadwal->id,
                'mata_kuliah' => $jadwal->suratTugasMengajar->mataKuliah->nama,
                'kelas' => $jadwal->suratTugasMengajar->kelas->nama,
                'hari' => ucfirst($jadwal->hari),
                'jam_mulai' => \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i'),
                'jam_selesai' => \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i'),
                'ruangan' => $jadwal->ruangan->nama ?? '-'
            ];
        });

        return response()->json($jadwalList);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'dosen_tujuan_id' => 'required|exists:user,id',
            'jadwal_tujuan_id' => 'required|exists:jadwal,id',
            'alasan' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            // VALIDASI KEPEMILIKAN: Cek apakah jadwal milik user saat ini
            $jadwalSaya = $this->validateJadwalOwnership($validated['jadwal_id'], Auth::id());

            // VALIDASI KEPEMILIKAN: Cek apakah jadwal tujuan milik dosen tujuan
            $jadwalTujuan = Jadwal::whereHas('suratTugasMengajar', function($q) use ($validated) {
                $q->where('dosen_id', $validated['dosen_tujuan_id']);
            })->find($validated['jadwal_tujuan_id']);

            if (!$jadwalTujuan) {
                throw new Exception('Jadwal tujuan tidak valid atau bukan milik dosen yang dituju.');
            }

            // Get pending status
            $statusPending = \App\Models\Status::where('nama', 'pending')->first();

            BarterJadwal::create([
                'jadwal_dosen_a_id' => $validated['jadwal_id'],
                'jadwal_dosen_b_id' => $validated['jadwal_tujuan_id'],
                'dosen_pengaju_id' => Auth::id(),
                'dosen_tujuan_id' => $validated['dosen_tujuan_id'],
                'status_id' => $statusPending->id,
                'alasan' => $validated['alasan']
            ]);

            DB::commit();

            return redirect()->route('barter-jadwal.index')
                ->with('success', 'Pengajuan barter jadwal berhasil dibuat');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat pengajuan barter: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateStatus(Request $request, BarterJadwal $barterJadwal)
    {
        $validated = $request->validate([
            'status_id' => 'required|exists:status,id'
        ]);

        // VALIDASI KEPEMILIKAN: Hanya dosen tujuan yang bisa mengubah status
        $currentUserId = Auth::id();
        $dosenTujuanId = $barterJadwal->dosen_tujuan_id;
        
        Log::info('Barter Update Status Attempt', [
            'barter_id' => $barterJadwal->id,
            'current_user_id' => $currentUserId,
            'dosen_tujuan_id' => $dosenTujuanId,
            'dosen_pengaju_id' => $barterJadwal->dosen_pengaju_id,
            'is_authorized' => $dosenTujuanId === $currentUserId
        ]);
        
        if ($dosenTujuanId !== $currentUserId) {
            return redirect()->back()
                ->with('error', "Anda tidak berhak mengubah status barter ini. Anda login sebagai User ID: {$currentUserId}, sedangkan yang berhak approve adalah dosen tujuan dengan User ID: {$dosenTujuanId}");
        }

        // Validasi status masih pending
        if ($barterJadwal->status_id !== 3) { // 3 = pending
            return redirect()->back()
                ->with('error', 'Permintaan barter ini sudah diproses sebelumnya.');
        }

        try {
            DB::beginTransaction();

            $barterJadwal->update([
                'status_id' => $validated['status_id']
            ]);

            // Jika disetujui, tukar jadwal
            $statusApproved = \App\Models\Status::where('nama', 'approved')->first();
            if ($validated['status_id'] == $statusApproved->id) {
                // VALIDASI KEPEMILIKAN: Pastikan kedua jadwal masih milik dosen yang benar
                $jadwalA = $barterJadwal->jadwalA;
                $jadwalB = $barterJadwal->jadwalB;

                if (!$jadwalA || !$jadwalB) {
                    throw new Exception('Jadwal tidak ditemukan.');
                }

                if ($jadwalA->suratTugasMengajar->dosen_id !== $barterJadwal->dosen_pengaju_id) {
                    throw new Exception('Jadwal A bukan milik dosen pengaju.');
                }

                if ($jadwalB->suratTugasMengajar->dosen_id !== $barterJadwal->dosen_tujuan_id) {
                    throw new Exception('Jadwal B bukan milik dosen tujuan.');
                }

                // Tukar surat_tugas_mengajar_id di jadwal
                // Gunakan temporary null untuk menghindari unique constraint violation
                $stmA = $jadwalA->surat_tugas_mengajar_id;
                $stmB = $jadwalB->surat_tugas_mengajar_id;

                // Set jadwal A ke null terlebih dahulu
                $jadwalA->update(['surat_tugas_mengajar_id' => null]);
                
                // Update jadwal B dengan surat tugas A
                $jadwalB->update(['surat_tugas_mengajar_id' => $stmA]);
                
                // Update jadwal A dengan surat tugas B
                $jadwalA->update(['surat_tugas_mengajar_id' => $stmB]);
            }

            DB::commit();

            $status = $validated['status_id'] == $statusApproved->id ? 'disetujui' : 'ditolak';
            return redirect()->route('barter-jadwal.index')
                ->with('success', "Pengajuan barter jadwal telah $status");

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}

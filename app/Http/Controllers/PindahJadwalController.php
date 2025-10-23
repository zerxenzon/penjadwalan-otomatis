<?php

namespace App\Http\Controllers;

use App\Models\PindahJadwal;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PindahJadwalController extends Controller
{
    /**
     * Validate KOSMA ownership of pindah jadwal request
     */
    protected function validateKosmaOwnership(PindahJadwal $pindahJadwal)
    {
        // VALIDASI KEPEMILIKAN: Hanya KOSMA yang ditunjuk yang bisa proses
        if ($pindahJadwal->kosma_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk memproses permintaan ini. Permintaan ini ditujukan untuk KOSMA lain.');
        }
    }

    /**
     * Display listing of pindah jadwal requests for KOSMA
     */
    public function index(Request $request)
    {
        $userRole = Auth::user()->role->nama ?? null;
        
        // Jika KOSMA: tampilkan permintaan yang ditujukan ke mereka
        if ($userRole === 'kosma') {
            // VALIDASI KEPEMILIKAN: Query hanya permintaan yang ditujukan ke KOSMA ini
            $query = PindahJadwal::with([
                'jadwalLama.suratTugasMengajar.mataKuliah',
                'jadwalLama.suratTugasMengajar.kelas',
                'jadwalLama.ruangan',
                'jadwalBaru.suratTugasMengajar.mataKuliah',
                'jadwalBaru.suratTugasMengajar.kelas',
                'jadwalBaru.ruangan',
                'dosen.biodata',
                'kosma',
                'status'
            ])
            ->where('kosma_id', Auth::id()) // VALIDASI KEPEMILIKAN
            ->orderBy('created_at', 'desc');

            // Filter by status
            if ($request->filled('status_filter')) {
                $query->where('status_id', $request->status_filter);
            }

            $pindahJadwalList = $query->get();
            
            return view('pindah-jadwal.index', compact('pindahJadwalList'));
        }
        
        // Jika DOSEN: tampilkan history permintaan mereka sendiri
        if ($userRole === 'dosen') {
            $myRequests = PindahJadwal::with([
                'jadwalLama.suratTugasMengajar.mataKuliah',
                'jadwalLama.suratTugasMengajar.kelas',
                'jadwalLama.ruangan',
                'jadwalBaru.suratTugasMengajar.mataKuliah',
                'jadwalBaru.suratTugasMengajar.kelas',
                'jadwalBaru.ruangan',
                'kosma',
                'status'
            ])
            ->where('dosen_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
            return view('pindah-jadwal.dosen-index', compact('myRequests'));
        }
        
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    /**
     * Display listing of pindah jadwal requests for DOSEN (separate route)
     */
    public function dosenIndex(Request $request)
    {
        $myRequests = PindahJadwal::with([
            'jadwalLama.suratTugasMengajar.mataKuliah',
            'jadwalLama.suratTugasMengajar.kelas',
            'jadwalLama.ruangan',
            'jadwalBaru.suratTugasMengajar.mataKuliah',
            'jadwalBaru.suratTugasMengajar.kelas',
            'jadwalBaru.ruangan',
            'kosma',
            'status'
        ])
        ->where('dosen_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('pindah-jadwal.dosen-index', compact('myRequests'));
    }

    /**
     * Show form untuk dosen mengajukan pindah jadwal
     */
    public function create()
    {
        $dosenId = Auth::id();
        
        // Ambil jadwal milik dosen ini
        $myJadwal = Jadwal::whereHas('suratTugasMengajar', function($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })
        ->with([
            'suratTugasMengajar.mataKuliah',
            'suratTugasMengajar.kelas',
            'ruangan',
            'shift'
        ])
        ->get();
        
        // Ambil slot kosong (yang bisa dipilih sebagai jadwal baru)
        $availableSlots = Jadwal::whereNull('surat_tugas_mengajar_id')
            ->where('status_id', 1) // aktif
            ->with(['ruangan', 'shift'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
        
        // Ambil daftar KOSMA (untuk dipilih sebagai approver)
        $kosmaList = User::whereHas('role', function($query) {
            $query->where('nama', 'kosma');
        })
        ->where('status_id', 1) // aktif
        ->get();
        
        return view('pindah-jadwal.create', compact('myJadwal', 'availableSlots', 'kosmaList'));
    }

    /**
     * Store permintaan pindah jadwal dari dosen
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_lama_id' => 'required|exists:jadwal,id',
            'jadwal_baru_id' => 'required|exists:jadwal,id',
            'kosma_id' => 'required|exists:user,id',
            'alasan' => 'required|string|max:500'
        ], [
            'jadwal_lama_id.required' => 'Jadwal lama harus dipilih',
            'jadwal_baru_id.required' => 'Jadwal baru harus dipilih',
            'kosma_id.required' => 'KOSMA harus dipilih',
            'alasan.required' => 'Alasan harus diisi'
        ]);

        try {
            DB::beginTransaction();
            
            $dosenId = Auth::id();
            
            // Validasi jadwal lama milik dosen ini
            $jadwalLama = Jadwal::with('suratTugasMengajar')->findOrFail($validated['jadwal_lama_id']);
            if (!$jadwalLama->suratTugasMengajar || $jadwalLama->suratTugasMengajar->dosen_id !== $dosenId) {
                throw new Exception('Jadwal lama bukan milik Anda.');
            }
            
            // Validasi jadwal baru masih kosong
            $jadwalBaru = Jadwal::findOrFail($validated['jadwal_baru_id']);
            if ($jadwalBaru->surat_tugas_mengajar_id !== null) {
                throw new Exception('Jadwal baru sudah terisi. Silakan pilih slot lain.');
            }
            
            // Cek apakah tidak ada bentrok dengan jadwal lain milik dosen
            $bentrok = Jadwal::whereHas('suratTugasMengajar', function($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            })
            ->where('hari', $jadwalBaru->hari)
            ->where(function($query) use ($jadwalBaru) {
                $query->whereBetween('jam_mulai', [$jadwalBaru->jam_mulai, $jadwalBaru->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$jadwalBaru->jam_mulai, $jadwalBaru->jam_selesai])
                    ->orWhere(function($q) use ($jadwalBaru) {
                        $q->where('jam_mulai', '<=', $jadwalBaru->jam_mulai)
                          ->where('jam_selesai', '>=', $jadwalBaru->jam_selesai);
                    });
            })
            ->exists();
            
            if ($bentrok) {
                throw new Exception('Jadwal baru bentrok dengan jadwal lain yang Anda miliki.');
            }
            
            // Buat permintaan pindah jadwal
            PindahJadwal::create([
                'dosen_id' => $dosenId,
                'jadwal_lama_id' => $validated['jadwal_lama_id'],
                'jadwal_baru_id' => $validated['jadwal_baru_id'],
                'kosma_id' => $validated['kosma_id'],
                'alasan' => $validated['alasan'],
                'status_id' => 3, // pending
            ]);
            
            DB::commit();
            
            Log::info('Pindah jadwal created', [
                'dosen_id' => $dosenId,
                'jadwal_lama_id' => $validated['jadwal_lama_id'],
                'jadwal_baru_id' => $validated['jadwal_baru_id']
            ]);
            
            return redirect()->route('pindah-jadwal.index')
                ->with('success', 'Permintaan pindah jadwal berhasil diajukan. Menunggu approval dari KOSMA.');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Pindah jadwal failed', [
                'error' => $e->getMessage(),
                'dosen_id' => Auth::id()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal mengajukan pindah jadwal: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update status of pindah jadwal request
     */
    public function updateStatus(Request $request, PindahJadwal $pindahJadwal)
    {
        // VALIDASI KEPEMILIKAN: Validate that current user is KOSMA for this request
        $this->validateKosmaOwnership($pindahJadwal);

        // Validate that status is still pending
        if ($pindahJadwal->status_id !== 3) { // 3 = pending
            return redirect()->back()
                ->with('error', 'Permintaan ini sudah diproses sebelumnya dan tidak dapat diubah lagi.');
        }

        $validated = $request->validate([
            'status_id' => 'required|in:4,5', // 4 = approved, 5 = rejected
            'alasan_reject' => 'required_if:status_id,5|nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Update status
            $pindahJadwal->update([
                'status_id' => $validated['status_id'],
                'catatan_kosma' => $validated['alasan_reject'] ?? null
            ]);

            // If approved, swap the jadwal
            if ($validated['status_id'] == 4) {
                $jadwalLama = $pindahJadwal->jadwalLama;
                $jadwalBaru = $pindahJadwal->jadwalBaru;

                if (!$jadwalLama || !$jadwalBaru) {
                    throw new Exception('Jadwal tidak ditemukan.');
                }

                // VALIDASI KEPEMILIKAN: Pastikan jadwal lama milik dosen yang mengajukan
                if ($jadwalLama->suratTugasMengajar->dosen_id !== $pindahJadwal->dosen_id) {
                    throw new Exception('Jadwal lama bukan milik dosen yang mengajukan.');
                }

                // Swap surat_tugas_mengajar_id
                $stmLama = $jadwalLama->surat_tugas_mengajar_id;
                $stmBaru = $jadwalBaru->surat_tugas_mengajar_id;

                $jadwalLama->update(['surat_tugas_mengajar_id' => $stmBaru]);
                $jadwalBaru->update(['surat_tugas_mengajar_id' => $stmLama]);
                
                // TODO: Send notifications to dosen and mahasiswa
                // Kirim notifikasi WhatsApp/Email ke:
                // 1. Dosen yang mengajukan (pindahJadwal->dosen)
                // 2. Mahasiswa di kelas tersebut (jadwalLama->suratTugasMengajar->kelas->mahasiswa)
                
                Log::info('Pindah Jadwal Approved - Notifications should be sent', [
                    'pindah_jadwal_id' => $pindahJadwal->id,
                    'dosen_id' => $pindahJadwal->dosen_id,
                    'dosen_phone' => $pindahJadwal->dosen->biodata->nomor_telepon ?? 'N/A',
                    'kelas_id' => $jadwalLama->suratTugasMengajar->kelas_id ?? 'N/A',
                    'message_to_dosen' => 'Permintaan pindah jadwal Anda telah DISETUJUI oleh KOSMA.',
                    'message_to_mahasiswa' => 'Jadwal kuliah telah berubah. Silakan cek jadwal terbaru.'
                ]);
            } else {
                // If rejected, notify dosen only
                Log::info('Pindah Jadwal Rejected - Notification should be sent to dosen', [
                    'pindah_jadwal_id' => $pindahJadwal->id,
                    'dosen_id' => $pindahJadwal->dosen_id,
                    'dosen_phone' => $pindahJadwal->dosen->biodata->nomor_telepon ?? 'N/A',
                    'alasan_reject' => $validated['alasan_reject'] ?? 'Tidak ada alasan',
                    'message' => 'Permintaan pindah jadwal Anda telah DITOLAK oleh KOSMA.'
                ]);
            }

            DB::commit();

            $message = $validated['status_id'] == 4 
                ? 'Permintaan pindah jadwal berhasil disetujui. Notifikasi akan dikirim ke dosen dan mahasiswa.' 
                : 'Permintaan pindah jadwal berhasil ditolak. Notifikasi akan dikirim ke dosen.';

            return redirect()->route('pindah-jadwal.index')
                ->with('success', $message);

        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal memproses permintaan: ' . $e->getMessage());
        }
    }
}
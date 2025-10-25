<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\SuratTugasMengajar;
use App\Models\Status;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CharterJadwalController extends Controller
{
    /**
     * Validate charter ownership before canceling
     */
    protected function validateCharterOwnership(Jadwal $jadwal, $userId)
    {
        // VALIDASI KEPEMILIKAN: Cek apakah jadwal punya STM
        if (!$jadwal->suratTugasMengajar) {
            throw new Exception('Jadwal ini tidak memiliki surat tugas mengajar.');
        }

        // VALIDASI KEPEMILIKAN: Cek apakah STM milik user ini
        if ($jadwal->suratTugasMengajar->dosen_id !== $userId) {
            throw new Exception('Anda tidak memiliki akses untuk membatalkan charter ini. Charter ini milik dosen lain.');
        }
    }

    public function index()
    {
        $userId = Auth::id();
        
        try {
            // Enable query logging
            DB::enableQueryLog();
            
            $statusAktif = Status::where('nama', 'aktif')->firstOrFail();
            
            // IMPROVED: Use direct SQL query for reliable results
            $myCharters = DB::table('jadwal')
                ->join('surat_tugas_mengajar', 'jadwal.surat_tugas_mengajar_id', '=', 'surat_tugas_mengajar.id')
                ->join('mata_kuliah', 'surat_tugas_mengajar.mata_kuliah_id', '=', 'mata_kuliah.id')
                ->join('kelas', 'surat_tugas_mengajar.kelas_id', '=', 'kelas.id')
                ->join('ruangan', 'jadwal.ruangan_id', '=', 'ruangan.id')
                ->select(
                    'jadwal.id',
                    'jadwal.hari', 
                    'jadwal.jam_mulai', 
                    'jadwal.jam_selesai',
                    'jadwal.surat_tugas_mengajar_id',
                    'mata_kuliah.nama as mata_kuliah_nama', 
                    'kelas.nama as kelas_nama',
                    'ruangan.nama as ruangan_nama'
                )
                ->where('surat_tugas_mengajar.dosen_id', '=', $userId)
                ->get();

            Log::info('Charter jadwal query result:', [
                'count' => $myCharters->count(),
                'query' => DB::getQueryLog()
            ]);
            
            // Create a collection of Jadwal objects from the query results
            $formattedCharters = collect($myCharters)->map(function($item) {
                $jadwal = new Jadwal();
                $jadwal->id = $item->id;
                $jadwal->hari = $item->hari;
                $jadwal->jam_mulai = $item->jam_mulai;
                $jadwal->jam_selesai = $item->jam_selesai;
                $jadwal->surat_tugas_mengajar_id = $item->surat_tugas_mengajar_id;
                
                // Create nested objects
                $stm = new SuratTugasMengajar();
                
                $mk = new MataKuliah();
                $mk->nama = $item->mata_kuliah_nama;
                
                $kelas = new Kelas();
                $kelas->nama = $item->kelas_nama;
                
                $ruangan = new \App\Models\Ruangan();
                $ruangan->nama = $item->ruangan_nama;
                
                // Set relationships
                $stm->setRelation('mataKuliah', $mk);
                $stm->setRelation('kelas', $kelas);
                $jadwal->setRelation('suratTugasMengajar', $stm);
                $jadwal->setRelation('ruangan', $ruangan);
                
                return $jadwal;
            });
            
            // Get slots
            $slots = Jadwal::whereNull('surat_tugas_mengajar_id')
                ->where('status_id', $statusAktif->id)
                ->with(['ruangan', 'shift'])
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();

            Log::info('Slot tersedia', [
                'total' => $slots->count()
            ]);

            // Data referensi
            $mataKuliah = MataKuliah::where('status_id', $statusAktif->id)->get();
            $kelas = Kelas::where('status_id', $statusAktif->id)->get();
            $semester = Semester::where('status_id', $statusAktif->id)->first();

            if (!$semester) {
                return redirect()->back()->with('error', 'Tidak ada semester aktif.');
            }

            return view('charter-jadwal.index', [
                'slots' => $slots ?? [],
                'myCharters' => $formattedCharters, // Use our formatted charters
                'mataKuliah' => $mataKuliah ?? [],
                'kelas' => $kelas ?? [],
                'semester' => $semester,
                'debugInfo' => [
                    'queryCount' => count(DB::getQueryLog()),
                    'charterCount' => $formattedCharters->count(),
                    'userId' => $userId
                ]
            ]);
        } 
        catch (Exception $e) {
            Log::error('Error di CharterJadwalController@index', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        DB::enableQueryLog();
        
        Log::info('Charter attempt', [
            'user' => $userId,
            'data' => $request->all(),
            'headers' => $request->headers->all()
        ]);
        
        // Check for null jadwal_id immediately
        if (empty($request->jadwal_id)) {
            Log::error('Charter failed: jadwal_id is null or empty', [
                'request_data' => $request->all()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Slot jadwal tidak dipilih dengan benar. Silakan coba lagi.')
                ->withInput();
        }
        
        // Validasi input
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester_id' => 'required|exists:semester,id',
        ], [
            'jadwal_id.required' => 'Slot jadwal harus dipilih',
            'jadwal_id.exists' => 'Slot jadwal tidak ditemukan',
            'mata_kuliah_id.required' => 'Mata kuliah harus dipilih',
            'kelas_id.required' => 'Kelas harus dipilih',
            'semester_id.required' => 'Semester harus dipilih',
        ]);

        try {
            DB::beginTransaction();
            
            $statusAktif = Status::where('nama', 'aktif')->firstOrFail();
            
            // First check if the jadwal is still available
            $jadwal = DB::table('jadwal')
                ->where('id', $validated['jadwal_id'])
                ->whereNull('surat_tugas_mengajar_id')
                ->first();
                
            if (!$jadwal) {
                throw new Exception('Jadwal tidak tersedia atau sudah diambil oleh dosen lain');
            }
            
            // Check if this dosen already has an STM for this combination
            $existingStm = DB::table('surat_tugas_mengajar')
                ->where('dosen_id', $userId)
                ->where('mata_kuliah_id', $validated['mata_kuliah_id'])
                ->where('kelas_id', $validated['kelas_id'])
                ->where('semester_id', $validated['semester_id'])
                ->first();
            
            if ($existingStm) {
                throw new Exception('Anda sudah memiliki surat tugas mengajar untuk mata kuliah dan kelas ini di semester yang sama. Silakan pilih mata kuliah atau kelas yang berbeda.');
            }
            
            // Create new STM with simplified approach
            $stmId = DB::table('surat_tugas_mengajar')->insertGetId([
                'dosen_id' => $userId,
                'mata_kuliah_id' => $validated['mata_kuliah_id'],
                'kelas_id' => $validated['kelas_id'],
                'semester_id' => $validated['semester_id'],
                'nomor_surat' => sprintf("STM/%s/%04d", date('Y'), rand(1000, 9999)),
                'status_id' => $statusAktif->id,
                'catatan' => 'Charter otomatis oleh dosen',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            Log::info('STM created', ['stm_id' => $stmId]);
            
            // Update jadwal directly
            $affected = DB::table('jadwal')
                ->where('id', $validated['jadwal_id'])
                ->whereNull('surat_tugas_mengajar_id')
                ->update([
                    'surat_tugas_mengajar_id' => $stmId,
                    'updated_at' => now()
                ]);
                
            if ($affected !== 1) {
                throw new Exception('Slot jadwal tidak tersedia atau sudah diambil dosen lain.');
            }
            
            // Verify the update
            $verifyJadwal = DB::table('jadwal')
                ->where('id', $validated['jadwal_id'])
                ->first();
                
            if (!$verifyJadwal || $verifyJadwal->surat_tugas_mengajar_id != $stmId) {
                throw new Exception('Verifikasi gagal: jadwal tidak terupdate dengan benar');
            }
            
            DB::commit();
            
            Log::info('Charter success', [
                'jadwal_id' => $validated['jadwal_id'],
                'stm_id' => $stmId,
                'queries' => DB::getQueryLog()
            ]);
            
            // Force reload data after success (prevent caching)
            return redirect()
                ->route('charter-jadwal.index', ['t' => time()])
                ->with('success', 'Berhasil charter jadwal! Silakan lihat pada tabel Jadwal Yang Sudah Di-charter.');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Charter failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'queries' => DB::getQueryLog(),
                'request_data' => $request->all()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Gagal melakukan charter: ' . $e->getMessage())
                ->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Charter validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            throw $e; // Re-throw validation exception
        }
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        
        try {
            DB::beginTransaction();

            $jadwal = Jadwal::with('suratTugasMengajar')->findOrFail($id);

            // VALIDASI KEPEMILIKAN: Pastikan jadwal ini milik user yang sedang login
            $this->validateCharterOwnership($jadwal, $userId);

            $stmId = $jadwal->surat_tugas_mengajar_id;

            // Kosongkan relasi jadwal
            $jadwal->update(['surat_tugas_mengajar_id' => null]);

            // Hapus STM
            SuratTugasMengajar::destroy($stmId);

            Log::info('Charter dibatalkan', [
                'jadwal_id' => $jadwal->id,
                'stm_id' => $stmId,
                'dosen_id' => $userId
            ]);

            DB::commit();

            return redirect()
                ->route('charter-jadwal.index')
                ->with('success', 'Charter jadwal berhasil dibatalkan. Slot kembali tersedia.');

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Gagal membatalkan charter', [
                'jadwal_id' => $id,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Monitoring untuk Kaprodi/Dekan - Tampilkan semua charter jadwal dari semua dosen
     */
    public function monitoring()
    {
        try {
            // Ambil semua charter jadwal dengan informasi lengkap
            $allCharters = DB::table('jadwal')
                ->join('surat_tugas_mengajar', 'jadwal.surat_tugas_mengajar_id', '=', 'surat_tugas_mengajar.id')
                ->join('biodata', 'surat_tugas_mengajar.dosen_id', '=', 'biodata.user_id')
                ->join('mata_kuliah', 'surat_tugas_mengajar.mata_kuliah_id', '=', 'mata_kuliah.id')
                ->join('kelas', 'surat_tugas_mengajar.kelas_id', '=', 'kelas.id')
                ->join('ruangan', 'jadwal.ruangan_id', '=', 'ruangan.id')
                ->join('semester', 'surat_tugas_mengajar.semester_id', '=', 'semester.id')
                ->join('status', 'surat_tugas_mengajar.status_id', '=', 'status.id')
                ->select(
                    'jadwal.id as jadwal_id',
                    'jadwal.hari', 
                    'jadwal.jam_mulai', 
                    'jadwal.jam_selesai',
                    'jadwal.created_at as charter_date',
                    'surat_tugas_mengajar.id as stm_id',
                    'surat_tugas_mengajar.nomor_surat',
                    'biodata.nama_lengkap as dosen_nama',
                    'mata_kuliah.nama as mata_kuliah_nama',
                    'mata_kuliah.kode as mata_kuliah_kode',
                    'mata_kuliah.sks',
                    'kelas.nama as kelas_nama',
                    'ruangan.nama as ruangan_nama',
                    'ruangan.kapasitas',
                    'semester.nama as semester_nama',
                    'status.nama as status_nama'
                )
                ->whereNotNull('jadwal.surat_tugas_mengajar_id')
                ->orderBy('jadwal.hari')
                ->orderBy('jadwal.jam_mulai')
                ->orderBy('dosen_nama')
                ->get();

            Log::info('Monitoring charter jadwal', [
                'total_charters' => $allCharters->count(),
                'user' => Auth::user()->biodata->nama_lengkap ?? 'Unknown'
            ]);

            return view('charter-jadwal.monitoring', [
                'charters' => $allCharters,
                'totalCharters' => $allCharters->count()
            ]);
            
        } catch (Exception $e) {
            Log::error('Error di CharterJadwalController@monitoring', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

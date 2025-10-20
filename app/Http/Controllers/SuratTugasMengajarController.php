<?php

namespace App\Http\Controllers;

use App\Models\SuratTugasMengajar;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratTugasMengajarController extends Controller
{
    /**
     * Tampilkan daftar surat tugas mengajar
     */
    public function index(Request $request)
    {
        $query = SuratTugasMengajar::with([
            'dosen',
            'mataKuliah',
            'kelas',
            'semester',
            'status'
        ]);

        // Filter berdasarkan status
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // Filter berdasarkan dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Search
        if ($request->filled('cari')) {
            $query->whereHas('dosen', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%');
            })->orWhereHas('mataKuliah', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Pagination
        $suratTugas = $query->paginate(10);
        $dosen = User::where('role_id', 4)->get();
        $status = Status::all();

        return view('surat_tugas_mengajar.index', compact('suratTugas', 'dosen', 'status'));
    }

    /**
     * Tampilkan form tambah surat tugas
     */
    public function tambah()
    {
        $dosen = User::where('role_id', 4)->get();
        $mataKuliah = MataKuliah::where('status_id', 1)->get();
        $kelas = Kelas::where('status_id', 1)->get();
        $semester = Semester::where('status_id', 1)->get();
        $status = Status::all();

        return view('surat_tugas_mengajar.form', compact('dosen', 'mataKuliah', 'kelas', 'semester', 'status'));
    }

    /**
     * Simpan surat tugas baru
     */
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:user,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester_id' => 'required|exists:semester,id',
            'catatan' => 'nullable|string',
            'status_id' => 'required|exists:status,id',
        ], [
            'dosen_id.required' => 'Dosen harus dipilih.',
            'mata_kuliah_id.required' => 'Mata kuliah harus dipilih.',
            'kelas_id.required' => 'Kelas harus dipilih.',
            'semester_id.required' => 'Semester harus dipilih.',
        ]);

        // Cek duplikat (1 dosen tidak bisa mengajar MK yang sama di kelas yang sama dalam 1 semester)
        $exists = SuratTugasMengajar::where([
            ['dosen_id', '=', $validated['dosen_id']],
            ['mata_kuliah_id', '=', $validated['mata_kuliah_id']],
            ['kelas_id', '=', $validated['kelas_id']],
            ['semester_id', '=', $validated['semester_id']]
        ])->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Surat tugas untuk dosen, MK, kelas, dan semester ini sudah ada.');
        }

        SuratTugasMengajar::create($validated);

        return redirect()->route('surat-tugas.index')
            ->with('sukses', 'Surat tugas berhasil dibuat.');
    }

    /**
     * Tampilkan form edit surat tugas
     */
    public function ubah($id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);
        
        // Hanya bisa edit jika status draft
        if ($suratTugas->status_id != 6) { // 6 = draft
            return redirect()->route('surat-tugas.index')
                ->with('error', 'Hanya surat tugas dengan status draft yang bisa diedit.');
        }

        $dosen = User::where('role_id', 4)->get();
        $mataKuliah = MataKuliah::where('status_id', 1)->get();
        $kelas = Kelas::where('status_id', 1)->get();
        $semester = Semester::where('status_id', 1)->get();
        $status = Status::all();

        return view('surat_tugas_mengajar.form', compact('suratTugas', 'dosen', 'mataKuliah', 'kelas', 'semester', 'status'));
    }

    /**
     * Update surat tugas
     */
    public function perbarui(Request $request, $id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);

        // Cek status
        if ($suratTugas->status_id != 6) { // draft
            return redirect()->route('surat-tugas.index')
                ->with('error', 'Hanya surat tugas draft yang bisa diupdate.');
        }

        $validated = $request->validate([
            'dosen_id' => 'required|exists:user,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester_id' => 'required|exists:semester,id',
            'catatan' => 'nullable|string',
            'status_id' => 'required|exists:status,id',
        ]);

        $suratTugas->update($validated);

        return redirect()->route('surat-tugas.index')
            ->with('sukses', 'Surat tugas berhasil diperbarui.');
    }

    /**
     * Hapus surat tugas
     */
    public function hapus($id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);

        // Hanya bisa hapus jika status draft
        if ($suratTugas->status_id != 6) {
            return redirect()->route('surat-tugas.index')
                ->with('error', 'Hanya surat tugas draft yang bisa dihapus.');
        }

        // Cek apakah sudah ada jadwal
        if ($suratTugas->jadwal()->count() > 0) {
            return redirect()->route('surat-tugas.index')
                ->with('error', 'Tidak bisa menghapus surat tugas yang sudah memiliki jadwal.');
        }

        $suratTugas->delete();

        return redirect()->route('surat_tugas.index')
            ->with('sukses', 'Surat tugas berhasil dihapus.');
    }

    /**
     * Lihat detail surat tugas
     */
    public function lihat($id)
    {
        $suratTugas = SuratTugasMengajar::with([
            'dosen',
            'mataKuliah',
            'kelas',
            'semester',
            'status',
            'jadwal'
        ])->findOrFail($id);

        return view('surat_tugas_mengajar.detail', compact('suratTugas'));
    }

    /**
     * Approve surat tugas (Dekan only)
     */
    public function approve($id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);

        // Hanya dekan yang bisa approve
    if (Auth::user()->role->nama != 'dekan') {
            abort(403, 'Hanya Dekan yang bisa approve surat tugas.');
        }

        // Status harus pending terlebih dahulu
        if ($suratTugas->status_id != 3) { // 3 = pending
            return redirect()->back()
                ->with('error', 'Hanya surat tugas pending yang bisa di-approve.');
        }

        $suratTugas->update([
            'status_id' => 4 // approved
        ]);

        return redirect()->route('surat_tugas.index')
            ->with('sukses', 'Surat tugas berhasil di-approve.');
    }

    /**
     * Reject surat tugas (Dekan only)
     */
    public function reject(Request $request, $id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);

        // Hanya dekan
    if (Auth::user()->role->nama != 'dekan') {
            abort(403, 'Hanya Dekan yang bisa reject surat tugas.');
        }

        // Status harus pending
        if ($suratTugas->status_id != 3) { // pending
            return redirect()->back()
                ->with('error', 'Hanya surat tugas pending yang bisa di-reject.');
        }

        $suratTugas->update([
            'status_id' => 5, // rejected
            'catatan' => $request->input('alasan_reject', '')
        ]);

        return redirect()->route('surat_tugas.index')
            ->with('sukses', 'Surat tugas berhasil di-reject.');
    }

    /**
     * Submit untuk approval (Kaprodi)
     */
    public function submitApproval($id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);

        // Status harus draft
        if ($suratTugas->status_id != 6) { // draft
            return redirect()->back()
                ->with('error', 'Hanya surat tugas draft yang bisa di-submit.');
        }

        $suratTugas->update([
            'status_id' => 3 // pending (menunggu approval dekan)
        ]);

        return redirect()->route('surat_tugas.index')
            ->with('sukses', 'Surat tugas berhasil di-submit untuk approval.');
    }

    /**
     * Publish surat tugas (Dekan) - Status menjadi approved & accessible by dosen
     */
    public function publish($id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);

        // Hanya dekan
    if (Auth::user()->role->nama != 'dekan') {
            abort(403, 'Hanya Dekan yang bisa publish.');
        }

        // Status harus approved
        if ($suratTugas->status_id != 4) { // approved
            return redirect()->back()
                ->with('error', 'Hanya surat tugas approved yang bisa di-publish.');
        }

        $suratTugas->update([
            'status_id' => 4 // tetap approved, but marked as published
        ]);

        // TODO: Send notification ke dosen via WhatsApp/Email

        return redirect()->route('surat_tugas.index')
            ->with('sukses', 'Surat tugas berhasil di-publish dan dosen sudah diberitahu.');
    }

        /**
     * Generate PDF for Surat Tugas Mengajar
     */
    public function generatePDF($id)
    {
        $suratTugas = SuratTugasMengajar::with([
            'dosen',
            'mataKuliah',
            'kelas',
            'semester',
            'status'
        ])->findOrFail($id);
        
        // Get Dekan (user with role_id = 1)
        $dekan = User::whereHas('role', function($query) {
            $query->where('nama', 'dekan');
        })->first();

        $data = [
            'suratTugas' => $suratTugas,
            'dekan' => $dekan,
            'kota' => 'Jakarta'
        ];

        $pdf = PDF::loadView('surat_tugas_mengajar.pdf', $data);
        return $pdf->stream("surat_tugas_{$id}.pdf");
    }
    public function exportPdf($id)
    {
        $suratTugas = SuratTugasMengajar::with([
            'dosen.biodata',
            'mataKuliah',
            'kelas',
            'semester',
            'status'
        ])->findOrFail($id);

        // Generate PDF
        $pdf = Pdf::loadView('surat_tugas_mengajar.pdf', compact('suratTugas'));

        return $pdf->download('Surat_Tugas_' . $suratTugas->dosen->nama . '.pdf');
    }
}
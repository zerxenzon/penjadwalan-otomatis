<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Angkatan;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Status;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Tampilkan daftar kelas
     */
    public function index(Request $request)
    {
        $query = Kelas::with(['angkatan', 'prodi', 'semester', 'shift', 'status']);

        // Search
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        // Filter prodi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Filter angkatan
        if ($request->filled('angkatan_id')) {
            $query->where('angkatan_id', $request->angkatan_id);
        }

        // Sort
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Pagination
        $kelas = $query->paginate(10);
        $prodi = Prodi::where('status_id', 1)->get();
        $angkatan = Angkatan::where('status_id', 1)->get();

        return view('kelas.index', compact('kelas', 'prodi', 'angkatan'));
    }

    /**
     * Tampilkan form tambah kelas
     */
    public function tambah()
    {
        $angkatan = Angkatan::where('status_id', 1)->get();
        $prodi = Prodi::where('status_id', 1)->get();
        $semester = Semester::where('status_id', 1)->get();
        $shift = Shift::where('status_id', 1)->get();
        $status = Status::all();

        return view('kelas.form', compact('angkatan', 'prodi', 'semester', 'shift', 'status'));
    }

    /**
     * Simpan kelas baru
     */
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:kelas,nama',
            'angkatan_id' => 'required|exists:angkatan,id',
            'prodi_id' => 'required|exists:prodi,id',
            'semester_id' => 'required|exists:semester,id',
            'shift_id' => 'required|exists:shift,id',
            'status_id' => 'required|exists:status,id',
        ], [
            'nama.required' => 'Nama kelas harus diisi.',
            'nama.unique' => 'Nama kelas sudah terdaftar.',
            'angkatan_id.required' => 'Angkatan harus dipilih.',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')
            ->with('sukses', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kelas
     */
    public function ubah($id)
    {
        $kelas = Kelas::findOrFail($id);
        $angkatan = Angkatan::where('status_id', 1)->get();
        $prodi = Prodi::where('status_id', 1)->get();
        $semester = Semester::where('status_id', 1)->get();
        $shift = Shift::where('status_id', 1)->get();
        $status = Status::all();

        return view('kelas.form', compact('kelas', 'angkatan', 'prodi', 'semester', 'shift', 'status'));
    }

    /**
     * Update kelas
     */
    public function perbarui(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:kelas,nama,' . $id,
            'angkatan_id' => 'required|exists:angkatan,id',
            'prodi_id' => 'required|exists:prodi,id',
            'semester_id' => 'required|exists:semester,id',
            'shift_id' => 'required|exists:shift,id',
            'status_id' => 'required|exists:status,id',
        ]);

        $kelas->update($validated);

        return redirect()->route('kelas.index')
            ->with('sukses', 'Kelas berhasil diperbarui.');
    }

    /**
     * Hapus kelas
     */
    public function hapus($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        if ($kelas->suratTugasMengajar()->count() > 0) {
            return redirect()->route('kelas.index')
                ->with('error', 'Tidak bisa menghapus kelas yang sudah memiliki surat tugas.');
        }

        $kelas->delete();

        return redirect()->route('kelas.index')
            ->with('sukses', 'Kelas berhasil dihapus.');
    }
}

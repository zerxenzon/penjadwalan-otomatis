<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Status;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Tampilkan daftar mata kuliah
     */
    public function index(Request $request)
    {
        $query = MataKuliah::with(['prodi', 'status']);

        // Search
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('kode', 'like', '%' . $request->cari . '%');
        }

        // Filter prodi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Sort
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Pagination
        $mataKuliah = $query->paginate(10);
        $prodi = Prodi::where('status_id', 1)->get();

        return view('mata_kuliah.index', compact('mataKuliah', 'prodi'));
    }

    /**
     * Tampilkan form tambah mata kuliah
     */
    public function tambah()
    {
        $prodi = Prodi::where('status_id', 1)->get();
        $status = Status::all();

        return view('mata_kuliah.form', compact('prodi', 'status'));
    }

    /**
     * Simpan mata kuliah baru
     */
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150|unique:mata_kuliah,nama',
            'kode' => 'required|string|max:20|unique:mata_kuliah,kode',
            'sks' => 'required|integer|min:1|max:6',
            'prodi_id' => 'required|exists:prodi,id',
            'status_id' => 'required|exists:status,id',
        ], [
            'nama.required' => 'Nama mata kuliah harus diisi.',
            'nama.unique' => 'Nama mata kuliah sudah terdaftar.',
            'kode.required' => 'Kode mata kuliah harus diisi.',
            'kode.unique' => 'Kode mata kuliah sudah terdaftar.',
            'sks.required' => 'SKS harus diisi.',
            'prodi_id.required' => 'Program studi harus dipilih.',
        ]);

        MataKuliah::create($validated);

        return redirect()->route('mata_kuliah.index')
            ->with('sukses', 'Mata kuliah berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit mata kuliah
     */
    public function ubah($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $prodi = Prodi::where('status_id', 1)->get();
        $status = Status::all();

        return view('mata_kuliah.form', compact('mataKuliah', 'prodi', 'status'));
    }

    /**
     * Update mata kuliah
     */
    public function perbarui(Request $request, $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:150|unique:mata_kuliah,nama,' . $id,
            'kode' => 'required|string|max:20|unique:mata_kuliah,kode,' . $id,
            'sks' => 'required|integer|min:1|max:6',
            'prodi_id' => 'required|exists:prodi,id',
            'status_id' => 'required|exists:status,id',
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('mata_kuliah.index')
            ->with('sukses', 'Mata kuliah berhasil diperbarui.');
    }

    /**
     * Hapus mata kuliah
     */
    public function hapus($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        
        // Cek apakah sudah digunakan di surat tugas
        if ($mataKuliah->suratTugasMengajar()->count() > 0) {
            return redirect()->route('mata_kuliah.index')
                ->with('error', 'Tidak bisa menghapus mata kuliah yang sudah digunakan.');
        }

        $mataKuliah->delete();

        return redirect()->route('mata_kuliah.index')
            ->with('sukses', 'Mata kuliah berhasil dihapus.');
    }

    /**
     * Lihat detail mata kuliah
     */
    public function lihat($id)
    {
        $mataKuliah = MataKuliah::with(['prodi', 'status', 'suratTugasMengajar'])->findOrFail($id);

        return view('mata_kuliah.detail', compact('mataKuliah'));
    }
}

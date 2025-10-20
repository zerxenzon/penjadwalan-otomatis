<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Status;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Tampilkan daftar ruangan
     */
    public function index(Request $request)
    {
        $query = Ruangan::with('status');

        // Search
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        // Filter status
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // Sort
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Pagination
        $ruangan = $query->paginate(10);
        $status = Status::all();

        return view('ruangan.index', compact('ruangan', 'status'));
    }

    /**
     * Tampilkan form tambah ruangan
     */
    public function tambah()
    {
        $status = Status::all();

        return view('ruangan.form', compact('status'));
    }

    /**
     * Simpan ruangan baru
     */
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:ruangan,nama',
            'kapasitas' => 'required|integer|min:5|max:500',
            'keterangan' => 'nullable|string',
            'status_id' => 'required|exists:status,id',
        ], [
            'nama.required' => 'Nama ruangan harus diisi.',
            'nama.unique' => 'Nama ruangan sudah terdaftar.',
            'kapasitas.required' => 'Kapasitas harus diisi.',
        ]);

        Ruangan::create($validated);

        return redirect()->route('ruangan.index')
            ->with('sukses', 'Ruangan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit ruangan
     */
    public function ubah($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $status = Status::all();

        return view('ruangan.form', compact('ruangan', 'status'));
    }

    /**
     * Update ruangan
     */
    public function perbarui(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:ruangan,nama,' . $id,
            'kapasitas' => 'required|integer|min:5|max:500',
            'keterangan' => 'nullable|string',
            'status_id' => 'required|exists:status,id',
        ]);

        $ruangan->update($validated);

        return redirect()->route('ruangan.index')
            ->with('sukses', 'Ruangan berhasil diperbarui.');
    }

    /**
     * Hapus ruangan
     */
    public function hapus($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        
        if ($ruangan->jadwal()->count() > 0) {
            return redirect()->route('ruangan.index')
                ->with('error', 'Tidak bisa menghapus ruangan yang sudah digunakan.');
        }

        $ruangan->delete();

        return redirect()->route('ruangan.index')
            ->with('sukses', 'Ruangan berhasil dihapus.');
    }
}

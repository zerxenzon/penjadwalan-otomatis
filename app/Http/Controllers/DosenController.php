<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Tampilkan daftar dosen
     */
    public function index(Request $request)
    {
        $query = User::where('role_id', 4) // Role Dosen
            ->with(['role', 'status', 'biodata']);

        // Search
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('username', 'like', '%' . $request->cari . '%')
                  ->orWhereHas('biodata', function($q) use ($request) {
                      $q->where('nip', 'like', '%' . $request->cari . '%');
                  });
        }

        // Sort
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Pagination
        $dosen = $query->paginate(10);

        return view('dosen.index', compact('dosen'));
    }

    /**
     * Tampilkan detail dosen
     */
    public function lihat($id)
    {
        $dosen = User::where('role_id', 4)
            ->with(['role', 'status', 'biodata', 'suratTugasMengajar'])
            ->findOrFail($id);

        return view('dosen.detail', compact('dosen'));
    }

    /**
     * Export daftar dosen ke PDF (bonus)
     */
    public function exportPdf()
    {
        $dosen = User::where('role_id', 4)
            ->with(['biodata'])
            ->orderBy('nama')
            ->get();

        return view('dosen.export_pdf', compact('dosen'));
    }
}
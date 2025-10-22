<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Traits\DataMasterCrudTrait;

class DosenController extends Controller
{
    use DataMasterCrudTrait;

    protected $model = User::class;
    protected $viewPath = 'dosen';
    protected $routePrefix = 'dosen';
    protected $validationRules = [
        'nama' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:user,username',
        'email' => 'required|email|max:255|unique:user,email',
        'password' => 'required|string|min:6',
        'role_id' => 'required|exists:role,id',
        'status_id' => 'required|exists:status,id'
    ];
    /**
     * Tampilkan daftar dosen
     */
    public function index(Request $request)
    {
        // Check if user is Kaprodi or Dekan
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $query = User::whereHas('role', function($q) {
            $q->where('nama', 'dosen');
        })->with(['role', 'status', 'biodata']);

        // Search
        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('username', 'like', '%' . $request->cari . '%')
                  ->orWhereHas('biodata', function($q) use ($request) {
                      $q->where('nip', 'like', '%' . $request->cari . '%');
                  });
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
     * Show form untuk tambah dosen baru
     */
    public function create()
    {
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::all();
        $statuses = Status::all();
        
        return view('dosen.create', compact('roles', 'statuses'));
    }

    /**
     * Simpan dosen baru
     */
    public function store(Request $request)
    {
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'email' => 'required|email|max:255|unique:user,email',
            'password' => 'required|string|min:6',
            'nip' => 'required|string|unique:biodata,nip',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'status_id' => 'required|exists:status,id'
        ]);

        DB::beginTransaction();
        try {
            // Get role_id untuk dosen
            $roleId = Role::where('nama', 'dosen')->first()->id;

            // Create user
            $user = User::create([
                'nama' => $validated['nama'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $roleId,
                'status_id' => $validated['status_id']
            ]);

            // Create biodata
            Biodata::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'alamat' => $validated['alamat'] ?? null,
                'no_telp' => $validated['no_telp'] ?? null
            ]);

            DB::commit();
            return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan form edit dosen
     */
    public function edit($id)
    {
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = User::with('biodata')->findOrFail($id);
        $statuses = Status::all();
        
        return view('dosen.edit', compact('dosen', 'statuses'));
    }

    /**
     * Update data dosen
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username,' . $id,
            'email' => 'required|email|max:255|unique:user,email,' . $id,
            'password' => 'nullable|string|min:6',
            'nip' => 'required|string|unique:biodata,nip,' . $dosen->biodata->id,
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'status_id' => 'required|exists:status,id'
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $updateData = [
                'nama' => $validated['nama'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'status_id' => $validated['status_id']
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $dosen->update($updateData);

            // Update biodata
            $dosen->biodata->update([
                'nip' => $validated['nip'],
                'alamat' => $validated['alamat'] ?? null,
                'no_telp' => $validated['no_telp'] ?? null
            ]);

            DB::commit();
            return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus data dosen
     */
    public function destroy($id)
    {
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = User::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete related biodata
            if ($dosen->biodata) {
                $dosen->biodata->delete();
            }
            
            // Delete user
            $dosen->delete();

            DB::commit();
            return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail dosen
     */
    public function show($id)
    {
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = User::where('id', $id)
            ->whereHas('role', function($q) {
                $q->where('nama', 'dosen');
            })
            ->with(['role', 'status', 'biodata', 'suratTugasMengajar'])
            ->firstOrFail();

        return view('dosen.show', compact('dosen'));
    }

    /**
     * Export daftar dosen ke PDF
     */
    public function exportPdf()
    {
        if (!Auth::user()->role || !in_array(Auth::user()->role->nama, ['kaprodi', 'dekan'])) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = User::whereHas('role', function($q) {
            $q->where('nama', 'dosen');
        })
        ->with(['biodata'])
        ->orderBy('nama')
        ->get();

        return view('dosen.export_pdf', compact('dosen'));
    }
}
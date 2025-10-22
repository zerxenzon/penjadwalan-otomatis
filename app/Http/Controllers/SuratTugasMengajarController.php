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
     * Check if user has permission as dekan
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function checkDekanPermission()
    {
        if (Auth::user()->role->nama !== "dekan") {
            throw new \Illuminate\Auth\Access\AuthorizationException("Hanya Dekan yang dapat melakukan aksi ini.");
        }
    }

    /**
     * Display a listing of surat tugas.
     */
    public function index(Request $request)
    {
        $query = SuratTugasMengajar::with([
            "dosen.biodata",
            "mataKuliah",
            "kelas",
            "semester",
            "status"
        ]);

        // Filter by status
        if ($request->filled("status_id")) {
            $query->where("status_id", $request->status_id);
        }

        // Filter by dosen
        if ($request->filled("dosen_id")) {
            $query->where("dosen_id", $request->dosen_id);
        }

        // Search
        if ($request->filled("cari")) {
            $query->whereHas("dosen", function($q) use ($request) {
                $q->where("nama", "like", "%" . $request->cari . "%");
            })->orWhereHas("mataKuliah", function($q) use ($request) {
                $q->where("nama", "like", "%" . $request->cari . "%");
            });
        }

        // Sort
        $sort = $request->get("sort", "created_at");
        $direction = $request->get("direction", "desc");
        $query->orderBy($sort, $direction);

        // Data
        $suratTugas = $query->paginate(10);
        $dosen = User::where("role_id", 4)->with("biodata")->get();
        $status = Status::all();

        return view("surat-tugas.index", compact("suratTugas", "dosen", "status"));
    }

    /**
     * Show the form for creating a new surat tugas.
     */
    public function create()
    {
        $dosen = User::whereHas('role', function($query) {
                $query->where('nama', 'dosen');
            })
            ->with("biodata")
            ->get();
        $mataKuliah = MataKuliah::where("status_id", 1)->get();
        $kelas = Kelas::where("status_id", 1)->get();
        $semester = Semester::where("status_id", 1)->get();

        return view("surat-tugas.form", compact(
            "dosen",
            "mataKuliah",
            "kelas",
            "semester"
        ));
    }

    /**
     * Alias for create() to maintain backward compatibility
     */
    public function tambah()
    {
        return $this->create();
    }

    /**
     * Store a newly created surat tugas.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "dosen_id" => "required|exists:user,id",
            "mata_kuliah_id" => "required|exists:mata_kuliah,id",
            "kelas_id" => "required|exists:kelas,id",
            "semester_id" => "required|exists:semester,id",
            "catatan" => "nullable|string",
        ]);

        // Check for duplicates
        $exists = SuratTugasMengajar::where([
            "dosen_id" => $validated["dosen_id"],
            "mata_kuliah_id" => $validated["mata_kuliah_id"],
            "kelas_id" => $validated["kelas_id"],
            "semester_id" => $validated["semester_id"]
        ])->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with("error", "Surat tugas untuk kombinasi ini sudah ada.");
        }

        try {
            // Generate nomor surat
            $tahun = date("Y");
            $count = SuratTugasMengajar::whereYear("created_at", $tahun)->count() + 1;
            $validated["nomor_surat"] = sprintf("%03d/STM-FT.UNPAM/%d", $count, $tahun);
            
            // Set initial status
            $validated["status_id"] = 3; // pending approval

            SuratTugasMengajar::create($validated);

            return redirect()
                ->route("surat-tugas.index")
                ->with("success", "Surat tugas berhasil dibuat.");

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with("error", "Gagal membuat surat tugas: " . $e->getMessage());
        }
    }

    /**
     * Alias for store() to maintain backward compatibility
     */
    public function simpan(Request $request)
    {
        return $this->store($request);
    }

    /**
     * Submit surat tugas for approval.
     */
    public function submitApproval($id)
    {
        $suratTugas = SuratTugasMengajar::findOrFail($id);

        if ($suratTugas->status_id !== 6) { // must be draft
            return redirect()->back()
                ->with("error", "Hanya surat tugas draft yang bisa di-submit.");
        }

        $suratTugas->update(["status_id" => 3]); // set to pending

        return redirect()
            ->route("surat-tugas.index")
            ->with("success", "Surat tugas berhasil di-submit untuk approval.");
    }

    /**
     * Approve surat tugas (Dekan only)
     */
    public function approve($id)
    {
        try {
            $this->checkDekanPermission();
            
            $suratTugas = SuratTugasMengajar::findOrFail($id);

            if ($suratTugas->status_id !== 3) { // must be pending
                return redirect()->back()
                    ->with("error", "Hanya surat tugas pending yang bisa di-approve.");
            }

            $suratTugas->update(["status_id" => 4]); // set to approved

            return redirect()
                ->route("surat-tugas.index")
                ->with("success", "Surat tugas berhasil di-approve.");

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Update surat tugas status
     */
    public function updateStatus(Request $request, SuratTugasMengajar $suratTugas)
    {
        try {
            $this->checkDekanPermission();

            if (!in_array($request->status_id, [4, 5])) {
                return back()->with("error", "Status tidak valid");
            }

            if ($suratTugas->status_id !== 3) {
                return back()->with("error", "Hanya surat tugas dengan status Menunggu Persetujuan yang dapat diubah");
            }

            $suratTugas->update(["status_id" => $request->status_id]);
            $message = $request->status_id == 4 ? "disetujui" : "ditolak";
            
            return back()->with("success", "Surat tugas berhasil " . $message);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return back()->with("error", $e->getMessage());
        } catch (\Exception $e) {
            return back()->with("error", "Gagal mengubah status: " . $e->getMessage());
        }
    }

    /**
     * Reject surat tugas (Dekan only)
     */
    public function reject(Request $request, $id)
    {
        try {
            $this->checkDekanPermission();
            
            $suratTugas = SuratTugasMengajar::findOrFail($id);

            if ($suratTugas->status_id !== 3) { // must be pending
                return redirect()->back()
                    ->with("error", "Hanya surat tugas pending yang bisa di-reject.");
            }

            $suratTugas->update([
                "status_id" => 5, // set to rejected
                "catatan" => $request->input("alasan_reject", "")
            ]);

            return redirect()
                ->route("surat-tugas.index")
                ->with("success", "Surat tugas berhasil di-reject.");

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Generate PDF surat tugas
     * 
     * @param int $id ID surat tugas
     * @param string $action "stream" untuk preview, "download" untuk unduh
     * @return \Illuminate\Http\Response
     */
    protected function generatePdf($id, $action = "stream")
    {
        $suratTugas = SuratTugasMengajar::with([
            "dosen.biodata",
            "dosen.role",
            "mataKuliah.prodi",
            "kelas",
            "semester"
        ])->findOrFail($id);

        $pdf = Pdf::loadView("surat-tugas.pdf", compact("suratTugas"));
        
        return $action === "download"
            ? $pdf->download("surat-tugas-" . $suratTugas->nomor_surat . ".pdf")
            : $pdf->stream("surat-tugas-" . $suratTugas->nomor_surat . ".pdf");
    }

    /**
     * Show PDF preview in browser
     */
    public function showPdf($id)
    {
        return $this->generatePdf($id, "stream");
    }

    /**
     * Download PDF
     */
    public function downloadPdf($id)
    {
        return $this->generatePdf($id, "download");
    }
}

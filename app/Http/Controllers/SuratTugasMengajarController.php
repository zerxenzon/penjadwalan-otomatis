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
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratTugasMengajarController extends Controller
{
    /**
     * Check if user is Dekan
     */
    protected function checkDekanPermission()
    {
        if (!Auth::check() || !Auth::user()->role || Auth::user()->role->nama !== 'dekan') {
            abort(403, 'Hanya Dekan yang dapat mengakses fitur ini.');
        }
    }

    /**
     * Validate ownership of Surat Tugas (for dosen viewing their own)
     */
    protected function validateOwnership(SuratTugasMengajar $suratTugas)
    {
        $user = Auth::user();
        
        // Dekan dan Kaprodi bisa akses semua
        if (in_array($user->role->nama, ['dekan', 'kaprodi'])) {
            return true;
        }
        
        // Dosen hanya bisa akses milik sendiri
        if ($user->role->nama === 'dosen' && $suratTugas->dosen_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke surat tugas ini.');
        }
        
        return true;
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
        $this->checkDekanPermission();

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
        $this->checkDekanPermission();

        $validated = $request->validate([
            "dosen_id" => "required|exists:user,id",
            "semester_id" => "required|exists:semester,id",
            "mata_kuliah" => "required|array|min:1",
            "mata_kuliah.*.mata_kuliah_id" => "required|exists:mata_kuliah,id",
            "mata_kuliah.*.kelas_id" => "required|exists:kelas,id",
            "mata_kuliah.*.sks" => "required|integer|min:1",
            "mata_kuliah.*.jumlah_kelas" => "required|integer|min:1",
            "mata_kuliah.*.total_sks" => "required|integer|min:1",
            "catatan" => "nullable|string",
            "status_id" => "required|exists:status,id",
        ]);

        try {
            $createdCount = 0;
            $errors = [];
            
            foreach ($validated["mata_kuliah"] as $mk) {
                // Check for duplicates
                $exists = SuratTugasMengajar::where([
                    "dosen_id" => $validated["dosen_id"],
                    "mata_kuliah_id" => $mk["mata_kuliah_id"],
                    "kelas_id" => $mk["kelas_id"],
                    "semester_id" => $validated["semester_id"]
                ])->exists();

                if ($exists) {
                    $mataKuliah = MataKuliah::find($mk["mata_kuliah_id"]);
                    $kelas = Kelas::find($mk["kelas_id"]);
                    $errors[] = "Surat tugas untuk {$mataKuliah->nama} - {$kelas->nama} sudah ada.";
                    continue;
                }

                // Generate nomor surat
                $tahun = date("Y");
                $count = SuratTugasMengajar::whereYear("created_at", $tahun)->count() + 1;
                $nomorSurat = sprintf("%03d/STM-FT.UNPAM/%d", $count, $tahun);
                
                // Create surat tugas
                SuratTugasMengajar::create([
                    "nomor_surat" => $nomorSurat,
                    "dosen_id" => $validated["dosen_id"],
                    "mata_kuliah_id" => $mk["mata_kuliah_id"],
                    "kelas_id" => $mk["kelas_id"],
                    "semester_id" => $validated["semester_id"],
                    "catatan" => $validated["catatan"] ?? null,
                    "status_id" => $validated["status_id"],
                ]);
                
                $createdCount++;
            }

            if ($createdCount > 0) {
                $message = "Berhasil membuat {$createdCount} surat tugas.";
                if (!empty($errors)) {
                    $message .= " " . implode(" ", $errors);
                }
                return redirect()
                    ->route("surat-tugas.index")
                    ->with("success", $message);
            } else {
                return back()
                    ->withInput()
                    ->with("error", implode(" ", $errors));
            }

        } catch (\Exception $e) {
            Log::error("Error creating surat tugas: " . $e->getMessage());
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

            if ($suratTugas->status_id !== 3) {
                return redirect()->back()
                    ->with("error", "Hanya surat tugas pending yang bisa di-approve.");
            }

            $suratTugas->update(["status_id" => 4]); // set to approved

            // TODO: Send WhatsApp notification to dosen
            // Implementasi notifikasi WhatsApp bisa menggunakan:
            // - Twilio API
            // - WhatsApp Business API
            // - Fonnte (Indonesia)
            // - Wablas (Indonesia)
            //
            // Contoh implementasi:
            // $dosen = $suratTugas->dosen;
            // $phone = $dosen->biodata->nomor_telepon;
            // $message = "Surat Tugas Mengajar Anda telah disetujui oleh Dekan.\n\n"
            //          . "Mata Kuliah: {$suratTugas->mataKuliah->nama}\n"
            //          . "Kelas: {$suratTugas->kelas->nama}\n"
            //          . "Silakan login ke sistem untuk melihat detail.";
            // WhatsAppService::send($phone, $message);
            
            Log::info("STM Approved", [
                'stm_id' => $suratTugas->id,
                'dosen_id' => $suratTugas->dosen_id,
                'dosen_phone' => $suratTugas->dosen->biodata->nomor_telepon ?? 'N/A',
                'message' => 'WhatsApp notification should be sent here'
            ]);

            return redirect()
                ->route("surat-tugas.index")
                ->with("success", "Surat tugas berhasil di-approve. Notifikasi akan dikirim ke dosen.");

        } catch (\Exception $e) {
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

        } catch (\Exception $e) {
            return back()->with("error", $e->getMessage());
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
            "dosen.biodata", // Pastikan biodata dimuat
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

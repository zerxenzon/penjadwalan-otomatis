<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\BarterJadwalController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\SuratTugasMengajarController;
use App\Http\Controllers\SuratTugasMengajarPDFController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\PindahJadwalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== PUBLIC ROUTES (untuk guest/belum login) =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'tampilkanFormLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'proses_login'])->name('login.proses');
});

// Home redirect
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role?->nama;
        if ($role && Route::has("dashboard.$role")) {
            return redirect()->route("dashboard.$role");
        }
    }
    return redirect()->route('login');
});

// ===== AUTHENTICATED ROUTES (untuk user yang sudah login) =====
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Barter Jadwal routes
    Route::resource('barter-jadwal', BarterJadwalController::class);
    Route::get('barter-jadwal/get-jadwal/{userId}', [BarterJadwalController::class, 'getJadwalDosen'])->name('barter-jadwal.get-jadwal');
    Route::put('barter-jadwal/{id}/status', [BarterJadwalController::class, 'updateStatus'])->name('barter-jadwal.update-status');

    // Jadwal routes
    Route::resource('jadwal', JadwalController::class);
    
    // PDF routes
    Route::get('surat-tugas/{suratTugas}/pdf', [SuratTugasMengajarPDFController::class, 'generate'])
        ->name('surat-tugas.pdf');

    // Pindah Jadwal routes
    Route::resource('pindah-jadwal', PindahJadwalController::class);
    Route::post('pindah-jadwal/{pindahJadwal}/update-status', [PindahJadwalController::class, 'updateStatus'])
        ->name('pindah-jadwal.update-status');
    
    // API routes
    Route::get('/api/dosen/{dosen}/jadwal', function($dosen) {
        return App\Models\Jadwal::where('dosen_id', $dosen)
                               ->with(['mataKuliah', 'kelas', 'shift'])
                               ->get();
    })->name('api.dosen.jadwal');

    // ===== DEKAN DASHBOARD =====
    Route::middleware('role:dekan')->group(function () {
        Route::get('/dekan', [DashboardController::class, 'dekan'])->name('dashboard.dekan');
    });

    // ===== KAPRODI DASHBOARD & DATA MASTER =====
    Route::middleware('role:kaprodi,dekan')->group(function () {
        // Dashboard
        Route::get('/kaprodi', [DashboardController::class, 'kaprodi'])->name('dashboard.kaprodi');
        
        // Mata Kuliah Routes
        Route::controller(MataKuliahController::class)->group(function () {
            Route::get('/mata-kuliah', 'index')->name('mata-kuliah.index');
            Route::get('/mata-kuliah/create', 'create')->name('mata-kuliah.create');
            Route::post('/mata-kuliah', 'store')->name('mata-kuliah.store');
            Route::get('/mata-kuliah/{id}/edit', 'edit')->name('mata-kuliah.edit');
            Route::put('/mata-kuliah/{id}', 'update')->name('mata-kuliah.update');
            Route::delete('/mata-kuliah/{id}', 'destroy')->name('mata-kuliah.destroy');
        });
        
        // Kelas Routes
        Route::controller(KelasController::class)->group(function () {
            Route::get('/kelas', 'index')->name('kelas.index');
            Route::get('/kelas/create', 'create')->name('kelas.create');
            Route::post('/kelas', 'store')->name('kelas.store');
            Route::get('/kelas/{id}/edit', 'edit')->name('kelas.edit');
            Route::put('/kelas/{id}', 'update')->name('kelas.update');
            Route::delete('/kelas/{id}', 'destroy')->name('kelas.destroy');
        });
        
        // Surat Tugas Routes
        Route::controller(SuratTugasMengajarController::class)->group(function () {
            Route::get('/surat-tugas', 'index')->name('surat-tugas.index');
            Route::get('/surat-tugas/tambah', 'tambah')->name('surat-tugas.tambah');
            Route::post('/surat-tugas', 'simpan')->name('surat-tugas.simpan');
            Route::post('/surat-tugas/{suratTugas}/update-status', 'updateStatus')->name('surat-tugas.update-status');
        });
        Route::controller(SuratTugasMengajarController::class)->group(function () {
            Route::get('/surat-tugas', 'index')->name('surat-tugas.index');
            Route::get('/surat-tugas/create', 'create')->name('surat-tugas.create');
            Route::post('/surat-tugas', 'store')->name('surat-tugas.store');
            Route::get('/surat-tugas/{id}/edit', 'edit')->name('surat-tugas.edit');
            Route::put('/surat-tugas/{id}', 'update')->name('surat-tugas.update');
            Route::delete('/surat-tugas/{id}', 'destroy')->name('surat-tugas.destroy');
        });
    });

    // ===== DOSEN ROUTES =====
    Route::middleware('role:dosen,kaprodi,dekan')->group(function () {
        // Dashboard
        Route::get('/dosen', [DashboardController::class, 'dosen'])->name('dashboard.dosen');
        
        // Surat Tugas Mengajar Routes
        Route::prefix('surat-tugas')->name('surat-tugas.')->group(function () {
            Route::get('/', [SuratTugasMengajarController::class, 'index'])->name('index');
            Route::get('/tambah', [SuratTugasMengajarController::class, 'tambah'])->name('tambah');
            Route::post('/simpan', [SuratTugasMengajarController::class, 'simpan'])->name('simpan');
            Route::get('/{id}/ubah', [SuratTugasMengajarController::class, 'ubah'])->name('ubah');
            Route::put('/{id}/perbarui', [SuratTugasMengajarController::class, 'perbarui'])->name('perbarui');
            Route::delete('/{id}/hapus', [SuratTugasMengajarController::class, 'hapus'])->name('hapus');
            Route::get('/{id}/lihat', [SuratTugasMengajarController::class, 'lihat'])->name('lihat');
            Route::get('/{id}/pdf', [SuratTugasMengajarController::class, 'generatePDF'])->name('pdf');
            Route::post('/{id}/reject', [SuratTugasMengajarController::class, 'reject'])->name('reject');
        });
        
        // Dosen Management Routes
        Route::get('/dosen-list', [DosenController::class, 'index'])->name('dosen.index');
        Route::get('/dosen/{id}', [DosenController::class, 'lihat'])->name('dosen.lihat');
        Route::get('/dosen/export/pdf', [DosenController::class, 'exportPdf'])->name('dosen.export_pdf');
    });

    // ===== KOSMA DASHBOARD =====
    Route::middleware('role:kosma')->group(function () {
        Route::get('/kosma', [DashboardController::class, 'kosma'])->name('dashboard.kosma');
    });

    // ===== MAHASISWA DASHBOARD =====
    Route::middleware('role:mahasiswa')->group(function () {
        Route::get('/mahasiswa', [DashboardController::class, 'mahasiswa'])->name('dashboard.mahasiswa');
    });

    // ===== SEKPRODI DASHBOARD =====
    Route::middleware('role:sekprodi')->group(function () {
        Route::get('/sekprodi', [DashboardController::class, 'sekprodi'])->name('dashboard.sekprodi');
    });

    // ============================================
    // ============================================
    // MASTER DATA ROUTES
    // ============================================
    Route::middleware('role:dosen,kaprodi,dekan')->group(function () {
        
        // ===== MATA KULIAH CRUD =====
        Route::prefix('mata-kuliah')->name('mata_kuliah.')->group(function () {
            Route::get('/', [MataKuliahController::class, 'index'])->name('index');
            Route::get('/tambah', [MataKuliahController::class, 'tambah'])->name('tambah');
            Route::post('/simpan', [MataKuliahController::class, 'simpan'])->name('simpan');
            Route::get('/{id}/ubah', [MataKuliahController::class, 'ubah'])->name('ubah');
            Route::put('/{id}/perbarui', [MataKuliahController::class, 'perbarui'])->name('perbarui');
            Route::delete('/{id}/hapus', [MataKuliahController::class, 'hapus'])->name('hapus');
            Route::get('/{id}/lihat', [MataKuliahController::class, 'lihat'])->name('lihat');
        });

        // ===== RUANGAN CRUD =====
        Route::prefix('ruangan')->name('ruangan.')->group(function () {
            Route::get('/', [RuanganController::class, 'index'])->name('index');
            Route::get('/tambah', [RuanganController::class, 'tambah'])->name('tambah');
            Route::post('/simpan', [RuanganController::class, 'simpan'])->name('simpan');
            Route::get('/{id}/ubah', [RuanganController::class, 'ubah'])->name('ubah');
            Route::put('/{id}/perbarui', [RuanganController::class, 'perbarui'])->name('perbarui');
            Route::delete('/{id}/hapus', [RuanganController::class, 'hapus'])->name('hapus');
        });

        // ===== KELAS CRUD =====
        Route::prefix('kelas')->name('kelas.')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('index');
            Route::get('/tambah', [KelasController::class, 'tambah'])->name('tambah');
            Route::post('/simpan', [KelasController::class, 'simpan'])->name('simpan');
            Route::get('/{id}/ubah', [KelasController::class, 'ubah'])->name('ubah');
            Route::put('/{id}/perbarui', [KelasController::class, 'perbarui'])->name('perbarui');
            Route::delete('/{id}/hapus', [KelasController::class, 'hapus'])->name('hapus');
        });

        // Dosen routes moved to main dosen section
    });
});

// ===== SURAT TUGAS CRUD & APPROVAL =====
Route::middleware('role:kaprodi,dekan')->group(function () {
    Route::prefix('surat-tugas')->name('surat-tugas.')->group(function () {
        Route::get('/', [SuratTugasMengajarController::class, 'index'])->name('index');
        Route::get('/tambah', [SuratTugasMengajarController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [SuratTugasMengajarController::class, 'simpan'])->name('simpan');
        Route::get('/{id}/ubah', [SuratTugasMengajarController::class, 'ubah'])->name('ubah');
        Route::put('/{id}/perbarui', [SuratTugasMengajarController::class, 'perbarui'])->name('perbarui');
        Route::delete('/{id}/hapus', [SuratTugasMengajarController::class, 'hapus'])->name('hapus');
        Route::get('/{id}/lihat', [SuratTugasMengajarController::class, 'lihat'])->name('lihat');
        
        // Approval workflow (Dekan only)
        Route::post('/{id}/approve', [SuratTugasMengajarController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [SuratTugasMengajarController::class, 'reject'])->name('reject');
        Route::post('/{id}/submit-approval', [SuratTugasMengajarController::class, 'submitApproval'])->name('submit_approval');
        Route::post('/{id}/publish', [SuratTugasMengajarController::class, 'publish'])->name('publish');
        
            Route::get('/mata-kuliah/create', [MataKuliahController::class, 'create'])->name('mata-kuliah.create');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::get('/surat-tugas/create', [SuratTugasMengajarController::class, 'create'])->name('surat-tugas.create');

        // Export PDF
        Route::get('/{id}/export-pdf', [SuratTugasMengajarController::class, 'exportPdf'])->name('export_pdf');
    });
});
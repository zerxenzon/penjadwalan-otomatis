@extends('layouts.dashboard')

@section('title', 'Dashboard Dekan')

@section('dashboard-content')

<!-- Header dengan Date -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard Dekan</h1>
    <span class="text-muted">{{ now()->format('d F Y H:i') }}</span>
</div>

<!-- ===== ROW 1: MAIN STATISTICS ===== -->
<div class="row mb-4">
    <!-- Total Dosen -->
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">TOTAL DOSEN</p>
                        <h3 class="fw-bold text-primary">{{ $total_dosen }}</h3>
                        <small class="text-success">✓ Aktif</small>
                    </div>
                    <div class="fs-1 text-primary opacity-50">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Mahasiswa -->
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">TOTAL MAHASISWA</p>
                        <h3 class="fw-bold text-success">{{ $total_mahasiswa }}</h3>
                        <small class="text-muted">Terdaftar</small>
                    </div>
                    <div class="fs-1 text-success opacity-50">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Mata Kuliah -->
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">TOTAL MATA KULIAH</p>
                        <h3 class="fw-bold text-warning">{{ $total_mata_kuliah }}</h3>
                        <small class="text-muted">Tersedia</small>
                    </div>
                    <div class="fs-1 text-warning opacity-50">
                        <i class="bi bi-book"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Jadwal -->
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">TOTAL JADWAL</p>
                        <h3 class="fw-bold text-info">{{ $total_jadwal ?? 0 }}</h3>
                        <small class="text-muted">Terjadwal</small>
                    </div>
                    <div class="fs-1 text-info opacity-50">
                        <i class="bi bi-calendar2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ROW 2: PENDING REQUESTS ===== -->
<div class="row mb-4">
    <!-- Surat Tugas Pending -->
    <div class="col-md-4 mb-3">
        <div class="card border-left-danger shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">SURAT TUGAS PENDING</p>
                        <h3 class="fw-bold text-danger">{{ $surat_tugas_pending }}</h3>
                        <a href="#" class="text-decoration-none small">Lihat detail →</a>
                    </div>
                    <div class="fs-1 text-danger opacity-50">
                        <i class="bi bi-file-text"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barter Pending -->
    <div class="col-md-4 mb-3">
        <div class="card border-left-info shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">BARTER PENDING</p>
                        <h3 class="fw-bold text-info">{{ $barter_pending }}</h3>
                        <a href="#" class="text-decoration-none small">Lihat detail →</a>
                    </div>
                    <div class="fs-1 text-info opacity-50">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pindah Jadwal Pending -->
    <div class="col-md-4 mb-3">
        <div class="card border-left-secondary shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">PINDAH JADWAL PENDING</p>
                        <h3 class="fw-bold text-secondary">{{ $pindah_pending }}</h3>
                        <a href="#" class="text-decoration-none small">Lihat detail →</a>
                    </div>
                    <div class="fs-1 text-secondary opacity-50">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ROW 3: QUICK ACTIONS ===== -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0">⚡ Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-3">
                        <a href="#" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Buat Surat Tugas
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-warning w-100">
                            <i class="bi bi-file-pdf"></i> Export Report
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-success w-100">
                            <i class="bi bi-calendar-check"></i> Lihat Jadwal
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-info w-100">
                            <i class="bi bi-graph-up"></i> Statistik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ROW 4: PENDING SURAT TUGAS TABLE ===== -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📋 Surat Tugas Menunggu Approval</h5>
                <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Dosen</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th width="12%">Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><strong>Dr. Budi Santoso</strong></td>
                            <td>Pemrograman Web 2</td>
                            <td>SI-R-SM3</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info me-1" title="Approve">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" title="Reject">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><strong>Prof. Siti Nurhaliza</strong></td>
                            <td>Basis Data Lanjut</td>
                            <td>SI-NR-SM3</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info me-1" title="Approve">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" title="Reject">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><strong>Ir. Ahmad Gunawan</strong></td>
                            <td>Sistem Operasi</td>
                            <td>TI-R-SM3</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info me-1" title="Approve">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" title="Reject">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light text-muted">
                <small>Menampilkan 3 dari {{ $surat_tugas_pending }} data pending</small>
            </div>
        </div>
    </div>
</div>

<!-- ===== ROW 5: BARTER & PINDAH JADWAL (SIDE BY SIDE) ===== -->
<div class="row mb-4">
    <!-- Barter Jadwal Pending -->
    <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">🔄 Barter Jadwal Pending</h5>
                <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Pengaju</th>
                            <th>Tujuan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><small><strong>Dr. Budi</strong></small></td>
                            <td><small>Prof. Siti</small></td>
                            <td>
                                <a href="#" class="btn btn-xs btn-info p-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><small><strong>Ir. Ahmad</strong></small></td>
                            <td><small>Dr. Budi</small></td>
                            <td>
                                <a href="#" class="btn btn-xs btn-info p-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light text-muted">
                <small>Total {{ $barter_pending }} data pending</small>
            </div>
        </div>
    </div>

    <!-- Pindah Jadwal Pending -->
    <div class="col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">↑ Pindah Jadwal Pending</h5>
                <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Dosen</th>
                            <th>Alasan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><small><strong>Dr. Budi</strong></small></td>
                            <td><small>Ada pelatihan</small></td>
                            <td>
                                <a href="#" class="btn btn-xs btn-info p-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><small><strong>Prof. Siti</strong></small></td>
                            <td><small>Kesehatan</small></td>
                            <td>
                                <a href="#" class="btn btn-xs btn-info p-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light text-muted">
                <small>Total {{ $pindah_pending }} data pending</small>
            </div>
        </div>
    </div>
</div>

<!-- ===== ROW 6: INFO SUMMARY ===== -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-info-circle"></i> Info Penting:</strong>
            <ul class="mb-0 mt-2 ms-3">
                <li><strong>{{ $surat_tugas_pending }}</strong> Surat Tugas pending - Butuh approval</li>
                <li><strong>{{ $barter_pending }}</strong> Permintaan Barter - Butuh review</li>
                <li><strong>{{ $pindah_pending }}</strong> Permintaan Pindah Jadwal - Butuh review</li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>

<!-- ===== ROW 7: FOOTER STATS ===== -->
<div class="row">
    <div class="col-md-12">
        <div class="card bg-light shadow">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h5 class="text-muted">Ruangan Tersedia</h5>
                        <h3 class="fw-bold text-info">{{ $total_ruangan ?? 0 }}</h3>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-muted">Total Kelas</h5>
                        <h3 class="fw-bold text-primary">{{ $total_kelas ?? 0 }}</h3>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-muted">Jadwal Aktif</h5>
                        <h3 class="fw-bold text-success">{{ $jadwal_aktif ?? 0 }}</h3>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-muted">Tingkat Penghunian</h5>
                        <h3 class="fw-bold text-warning">{{ $tingkat_penghunian ?? '0' }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.dashboard')

@section('title', 'Dashboard Dekan')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard Dekan</h1>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- Total Dosen -->
    <div class="col-md-4 mb-3">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">TOTAL DOSEN</p>
                        <h3 class="fw-bold text-primary">{{ $total_dosen }}</h3>
                    </div>
                    <div class="fs-1 text-primary opacity-50">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Mahasiswa -->
    <div class="col-md-4 mb-3">
        <div class="card border-left-success shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">TOTAL MAHASISWA</p>
                        <h3 class="fw-bold text-success">{{ $total_mahasiswa }}</h3>
                    </div>
                    <div class="fs-1 text-success opacity-50">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Mata Kuliah -->
    <div class="col-md-4 mb-3">
        <div class="card border-left-warning shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">TOTAL MATA KULIAH</p>
                        <h3 class="fw-bold text-warning">{{ $total_mata_kuliah }}</h3>
                    </div>
                    <div class="fs-1 text-warning opacity-50">
                        <i class="bi bi-book"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests -->
<div class="row">
    <!-- Surat Tugas Pending -->
    <div class="col-md-4 mb-3">
        <div class="card border-left-danger shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-bold mb-0">SURAT TUGAS PENDING</p>
                        <h3 class="fw-bold text-danger">{{ $surat_tugas_pending }}</h3>
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
                    </div>
                    <div class="fs-1 text-secondary opacity-50">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


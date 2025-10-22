@extends('layouts.dashboard')

@section('title', 'Dashboard KOSMA')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard KOSMA (Ketua Organisasi Mahasiswa)</h1>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-warning shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">PERMINTAAN PENDING</p>
                <h3 class="fw-bold text-warning">{{ $pindah_pending }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-success shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">DISETUJUI</p>
                <h3 class="fw-bold text-success">{{ $pindah_approved }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-danger shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">DITOLAK</p>
                <h3 class="fw-bold text-danger">{{ $pindah_rejected }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Aksi Utama</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('pindah-jadwal.index') }}" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Lihat Permintaan Pindah Jadwal
        </a>
    </div>
</div>
@endsection

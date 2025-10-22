@extends('layouts.dashboard')

@section('title', 'Dashboard Kaprodi')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard Kaprodi</h1>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">TOTAL DOSEN</p>
                <h3 class="fw-bold text-primary">{{ $total_dosen }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-success shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">TOTAL MAHASISWA</p>
                <h3 class="fw-bold text-success">{{ $total_mahasiswa }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-warning shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">TOTAL MATA KULIAH</p>
                <h3 class="fw-bold text-warning">{{ $total_mata_kuliah }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-danger shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">SURAT TUGAS DRAFT</p>
                <h3 class="fw-bold text-danger">{{ $surat_tugas_draft }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Aksi Cepat</h5>
    </div>
    <div class="card-body">
        <a href="/mata-kuliah" class="btn btn-primary me-2">
            <i class="bi bi-book"></i> Kelola Mata Kuliah
        </a>
        <a href="/kelas" class="btn btn-success me-2">
            <i class="bi bi-people"></i> Kelola Kelas
        </a>
        <a href="/surat-tugas" class="btn btn-info">
            <i class="bi bi-file-text"></i> Kelola Surat Tugas
        </a>
    </div>
</div>
@endsection

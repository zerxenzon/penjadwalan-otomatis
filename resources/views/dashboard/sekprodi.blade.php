@extends('layouts.dashboard')

@section('title', 'Dashboard Sekprodi')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard Sekretaris Prodi</h1>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">TOTAL DOSEN</p>
                <h3 class="fw-bold text-primary">{{ $total_dosen }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-success shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">TOTAL MATA KULIAH</p>
                <h3 class="fw-bold text-success">{{ $total_mata_kuliah }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-warning shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">TOTAL RUANGAN</p>
                <h3 class="fw-bold text-warning">{{ $total_ruangan }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection

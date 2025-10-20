@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard Mahasiswa</h1>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<!-- Jadwal Kelas -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Jadwal Kelas Anda</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">Lihat jadwal kuliah untuk kelas Anda.</p>
        <!-- Table akan ditambahkan di sini -->
    </div>
</div>
@endsection

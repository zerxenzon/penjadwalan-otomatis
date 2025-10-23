@extends('layouts.dashboard')

@section('title', 'Dashboard KOSMA')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard KOSMA (Ketua Organisasi Mahasiswa)</h1>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<!-- Notifikasi Permintaan Pindah Jadwal Baru -->
@if(isset($recent_requests) && $recent_requests->count() > 0)
<div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Ada Permintaan Pindah Jadwal Baru!</h5>
    <p class="mb-2">Dosen telah mengajukan permintaan pindah jadwal:</p>
    <ul class="mb-0">
        @foreach($recent_requests as $request)
        <li>
            <strong>{{ $request->dosen->nama ?? 'N/A' }}</strong> 
            - {{ $request->jadwalLama->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}
            ({{ $request->jadwalLama->suratTugasMengajar->kelas->nama ?? 'N/A' }})
            <small class="text-muted">({{ $request->created_at->diffForHumans() }})</small>
        </li>
        @endforeach
    </ul>
    <hr>
    <p class="mb-0">
        <a href="{{ route('pindah-jadwal.index') }}" class="btn btn-sm btn-warning">
            <i class="bi bi-check-circle"></i> Review Permintaan Sekarang
        </a>
    </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

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
        <a href="{{ route('pindah-jadwal.index') }}" class="btn btn-primary me-2">
            <i class="bi bi-check-circle"></i> Lihat Permintaan Pindah Jadwal
        </a>
        <a href="{{ route('kosma.jadwal-kelas') }}" class="btn btn-success">
            <i class="bi bi-calendar3"></i> Lihat Jadwal Kelas
        </a>
    </div>
</div>
@endsection

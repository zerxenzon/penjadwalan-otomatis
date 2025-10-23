@extends('layouts.dashboard')

@section('title', 'Dashboard Dosen')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard Dosen</h1>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<!-- Notifikasi STM Approved -->
@if(isset($recent_approved_stm) && $recent_approved_stm->count() > 0)
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <h5 class="alert-heading"><i class="bi bi-check-circle-fill"></i> Surat Tugas Mengajar Disetujui!</h5>
    <p class="mb-2">Selamat! Surat Tugas Mengajar Anda telah disetujui:</p>
    <ul class="mb-0">
        @foreach($recent_approved_stm as $stm)
        <li>
            <strong>{{ $stm->mataKuliah->nama ?? 'N/A' }}</strong> 
            - Kelas {{ $stm->kelas->nama ?? 'N/A' }} 
            - {{ $stm->semester->nama ?? 'N/A' }}
            <small class="text-muted">({{ $stm->updated_at->diffForHumans() }})</small>
        </li>
        @endforeach
    </ul>
    <hr>
    <p class="mb-0">
        <a href="{{ route('charter-jadwal.index') }}" class="btn btn-sm btn-success">
            <i class="bi bi-calendar-plus"></i> Charter Jadwal Sekarang
        </a>
    </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">SURAT TUGAS</p>
                <h3 class="fw-bold text-primary">{{ $total_surat_tugas }}</h3>
                <small class="text-muted">
                    <i class="bi bi-check-circle text-success"></i> {{ $surat_tugas_approved ?? 0 }} Approved | 
                    <i class="bi bi-hourglass-split text-warning"></i> {{ $surat_tugas_pending ?? 0 }} Pending
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-success shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">TOTAL JADWAL</p>
                <h3 class="fw-bold text-success">{{ $total_jadwal }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-warning shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">BARTER MASUK</p>
                <h3 class="fw-bold text-warning">{{ $barter_masuk }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-danger shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">BARTER KELUAR</p>
                <h3 class="fw-bold text-danger">{{ $barter_keluar }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal Minggu Ini -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Jadwal Minggu Ini</h5>
    </div>
    <div class="card-body">
        @if ($jadwal_minggu_ini->isEmpty())
            <p class="text-muted">Tidak ada jadwal minggu ini.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal_minggu_ini as $j)
                            <tr>
                                <td>{{ ucfirst($j->hari) }}</td>
                                <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                <td>{{ $j->suratTugasMengajar->mataKuliah->nama }}</td>
                                <td>{{ $j->suratTugasMengajar->kelas->nama }}</td>
                                <td>{{ $j->ruangan->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection

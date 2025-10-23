@extends('layouts.dashboard')

@section('title', 'Jadwal Kelas - KOSMA')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3"><i class="bi bi-calendar3"></i> Jadwal Kelas {{ $kelas->nama ?? 'N/A' }}</h1>
        <p class="text-muted mb-0">Monitor jadwal kuliah kelas Anda secara realtime</p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </div>
</div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($jadwalGrouped->isEmpty())
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle fs-3"></i>
        <p class="mb-0 mt-2">Belum ada jadwal untuk kelas ini.</p>
    </div>
    @else
    <!-- Info Summary -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <h3 class="text-primary">{{ $jadwalGrouped->flatten()->count() }}</h3>
                    <small class="text-muted">Total Sesi</small>
                </div>
                <div class="col-md-3">
                    <h3 class="text-success">{{ $jadwalGrouped->flatten()->unique('suratTugasMengajar.dosen_id')->count() }}</h3>
                    <small class="text-muted">Dosen Pengampu</small>
                </div>
                <div class="col-md-3">
                    <h3 class="text-info">{{ $jadwalGrouped->flatten()->unique('suratTugasMengajar.mata_kuliah_id')->count() }}</h3>
                    <small class="text-muted">Mata Kuliah</small>
                </div>
                <div class="col-md-3">
                    <h3 class="text-warning">{{ $jadwalGrouped->count() }}</h3>
                    <small class="text-muted">Hari Kuliah</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal per Hari -->
    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari)
        @if($jadwalGrouped->has($hari))
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-day"></i> {{ ucfirst($hari) }}
                    <span class="badge bg-light text-dark float-end">{{ $jadwalGrouped[$hari]->count() }} Sesi</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen</th>
                                <th>Ruangan</th>
                                <th>SKS</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalGrouped[$hari]->sortBy('jam_mulai') as $jadwal)
                            <tr>
                                <td>
                                    <i class="bi bi-clock"></i>
                                    <strong>{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</strong>
                                    -
                                    <strong>{{ date('H:i', strtotime($jadwal->jam_selesai)) }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $jadwal->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $jadwal->suratTugasMengajar->mataKuliah->kode ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $jadwal->suratTugasMengajar->dosen->nama ?? 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $jadwal->ruangan->nama ?? 'N/A' }}</span>
                                    <br>
                                    <small class="text-muted">Kapasitas: {{ $jadwal->ruangan->kapasitas ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $jadwal->suratTugasMengajar->mataKuliah->sks ?? 'N/A' }} SKS</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Aktif
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    @endif

<div class="mt-3">
    <a href="{{ route('dashboard.kosma') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

<style>
    @media print {
        .btn, .alert, .text-muted {
            display: none !important;
        }
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }
    }
</style>
@endsection
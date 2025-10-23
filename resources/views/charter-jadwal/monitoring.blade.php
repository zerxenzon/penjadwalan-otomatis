@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="bi bi-clipboard-data"></i> Monitoring Charter Jadwal</h2>
                    <p class="text-muted mb-0">Pantau semua aktivitas charter jadwal dari seluruh dosen</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary fs-5">Total: {{ $totalCharters }} Charter</span>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Daftar Charter Jadwal</h5>
        </div>
        <div class="card-body">
            @if($charters->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-3"></i>
                <p class="mb-0 mt-2">Belum ada charter jadwal yang tercatat.</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Ruangan</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Tanggal Charter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($charters as $index => $charter)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $charter->dosen_nama }}</strong>
                                <br>
                                <small class="text-muted">STM: {{ $charter->nomor_surat }}</small>
                            </td>
                            <td>
                                <strong>{{ $charter->mata_kuliah_nama }}</strong>
                                <br>
                                <small class="text-muted">{{ $charter->mata_kuliah_kode }} ({{ $charter->sks }} SKS)</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $charter->kelas_nama }}</span>
                            </td>
                            <td>
                                <strong>{{ $charter->ruangan_nama }}</strong>
                                <br>
                                <small class="text-muted">Kapasitas: {{ $charter->kapasitas }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($charter->hari) }}</span>
                            </td>
                            <td>
                                <i class="bi bi-clock"></i> 
                                {{ date('H:i', strtotime($charter->jam_mulai)) }} - {{ date('H:i', strtotime($charter->jam_selesai)) }}
                            </td>
                            <td>{{ $charter->semester_nama }}</td>
                            <td>
                                @if(strtolower($charter->status_nama) == 'aktif')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Aktif
                                    </span>
                                @elseif(strtolower($charter->status_nama) == 'pending')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                @elseif(strtolower($charter->status_nama) == 'draft')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-pencil"></i> Draft
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($charter->status_nama) }}</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ date('d M Y H:i', strtotime($charter->charter_date)) }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary Statistics -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title"><i class="bi bi-bar-chart"></i> Statistik Charter</h6>
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="border rounded p-3 bg-white">
                                        <h3 class="text-primary mb-0">{{ $charters->count() }}</h3>
                                        <small class="text-muted">Total Charter</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded p-3 bg-white">
                                        <h3 class="text-success mb-0">{{ $charters->where('status_nama', 'aktif')->count() }}</h3>
                                        <small class="text-muted">Aktif</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded p-3 bg-white">
                                        <h3 class="text-warning mb-0">{{ $charters->where('status_nama', 'pending')->count() }}</h3>
                                        <small class="text-muted">Pending</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded p-3 bg-white">
                                        <h3 class="text-info mb-0">{{ $charters->unique('dosen_nama')->count() }}</h3>
                                        <small class="text-muted">Dosen Terlibat</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('dashboard.' . auth()->user()->role->nama) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<style>
    .table-responsive {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .badge {
        padding: 0.5em 0.8em;
    }
</style>
@endsection

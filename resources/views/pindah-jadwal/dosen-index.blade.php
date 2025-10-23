@extends('layouts.dashboard')

@section('title', 'Pindah Jadwal - Dosen')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3"><i class="bi bi-clock-history"></i> Pindah Jadwal</h1>
        <p class="text-muted mb-0">History permintaan pindah jadwal Anda</p>
    </div>
    <div>
        <a href="{{ route('pindah-jadwal.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajukan Pindah Jadwal
        </a>
    </div>
</div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> History Permintaan Pindah Jadwal</h5>
        </div>
        <div class="card-body">
            @if($myRequests->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-3"></i>
                <p class="mb-0 mt-2">Anda belum pernah mengajukan pindah jadwal.</p>
                <a href="{{ route('pindah-jadwal.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Ajukan Sekarang
                </a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Ajuan</th>
                            <th>Jadwal Lama</th>
                            <th>Jadwal Baru</th>
                            <th>KOSMA</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Catatan KOSMA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myRequests as $index => $request)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <small>{{ $request->created_at->format('d M Y H:i') }}</small>
                            </td>
                            <td>
                                <strong>{{ ucfirst($request->jadwalLama->hari ?? 'N/A') }}</strong><br>
                                <small>
                                    {{ date('H:i', strtotime($request->jadwalLama->jam_mulai ?? '00:00')) }} - 
                                    {{ date('H:i', strtotime($request->jadwalLama->jam_selesai ?? '00:00')) }}
                                </small><br>
                                <span class="badge bg-secondary">{{ $request->jadwalLama->ruangan->nama ?? 'N/A' }}</span><br>
                                <small class="text-muted">
                                    {{ $request->jadwalLama->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}
                                </small>
                            </td>
                            <td>
                                <strong>{{ ucfirst($request->jadwalBaru->hari ?? 'N/A') }}</strong><br>
                                <small>
                                    {{ date('H:i', strtotime($request->jadwalBaru->jam_mulai ?? '00:00')) }} - 
                                    {{ date('H:i', strtotime($request->jadwalBaru->jam_selesai ?? '00:00')) }}
                                </small><br>
                                <span class="badge bg-info">{{ $request->jadwalBaru->ruangan->nama ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <strong>{{ $request->kosma->nama ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <small>{{ \Str::limit($request->alasan, 50) }}</small>
                            </td>
                            <td>
                                @if($request->status_id == 3)
                                    <span class="badge bg-warning">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                @elseif($request->status_id == 4)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Approved
                                    </span>
                                @elseif($request->status_id == 5)
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $request->status->nama ?? 'Unknown' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($request->catatan_kosma)
                                    <small class="text-muted">{{ $request->catatan_kosma }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

<div class="mt-3">
    <a href="{{ route('dashboard.' . auth()->user()->role->nama) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
@endsection

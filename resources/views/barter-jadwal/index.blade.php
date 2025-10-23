@extends('layouts.dashboard')

@section('title', 'Barter Jadwal')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Barter Jadwal</h1>
    <a href="{{ route('barter-jadwal.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Ajukan Barter
    </a>
</div>

<!-- Status Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Barter Masuk -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-arrow-down-circle text-primary me-2"></i>
            Permintaan Barter Masuk
        </h5>
        <p class="text-muted small mb-0">Permintaan barter dari dosen lain yang ditujukan untuk Anda</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Dosen Pengaju</th>
                    <th>Jadwal yang Ditawarkan</th>
                    <th>Jadwal yang Diminta</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $barterMasuk = $barterList->where('dosen_tujuan_id', Auth::id())->where('status_id', 3);
                @endphp
                
                @forelse ($barterMasuk as $barter)
                <tr>
                    <td>{{ $barter->dosenPengaju->biodata->nama ?? $barter->dosenPengaju->username }}</td>
                    <td>
                        <strong>{{ $barter->jadwalA->suratTugasMengajar->mataKuliah->nama }}</strong><br>
                        {{ $barter->jadwalA->suratTugasMengajar->kelas->nama }}<br>
                        {{ ucfirst($barter->jadwalA->hari) }}, 
                        {{ \Carbon\Carbon::parse($barter->jadwalA->jam_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($barter->jadwalA->jam_selesai)->format('H:i') }}<br>
                        {{ $barter->jadwalA->ruangan->nama }}
                    </td>
                    <td>
                        <strong>{{ $barter->jadwalB->suratTugasMengajar->mataKuliah->nama }}</strong><br>
                        {{ $barter->jadwalB->suratTugasMengajar->kelas->nama }}<br>
                        {{ ucfirst($barter->jadwalB->hari) }}, 
                        {{ \Carbon\Carbon::parse($barter->jadwalB->jam_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($barter->jadwalB->jam_selesai)->format('H:i') }}<br>
                        {{ $barter->jadwalB->ruangan->nama }}
                    </td>
                    <td>{{ $barter->alasan }}</td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-clock"></i> {{ $barter->status->nama }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('barter-jadwal.update-status', $barter->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status_id" value="4"> <!-- Approved -->
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin menyetujui barter jadwal ini?')">
                                <i class="bi bi-check-circle"></i> Setuju
                            </button>
                        </form>
                        <form action="{{ route('barter-jadwal.update-status', $barter->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status_id" value="5"> <!-- Rejected -->
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menolak barter jadwal ini?')">
                                <i class="bi bi-x-circle"></i> Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">
                        <i class="bi bi-info-circle me-1"></i> Tidak ada permintaan barter masuk saat ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Riwayat Barter -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-clock-history text-secondary me-2"></i>
            Riwayat Barter
        </h5>
        <p class="text-muted small mb-0">Semua permintaan barter yang pernah Anda ajukan atau terima</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Dosen</th>
                    <th>Jadwal Anda</th>
                    <th>Jadwal Ditukar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                $riwayatBarter = $barterList->where('status_id', '!=', 3);
                @endphp
                
                @forelse ($riwayatBarter as $barter)
                <tr>
                    <td>{{ $barter->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($barter->dosen_pengaju_id == Auth::id())
                            <span class="badge bg-info text-dark">Ke: {{ $barter->dosenTujuan->biodata->nama ?? $barter->dosenTujuan->username }}</span>
                        @else
                            <span class="badge bg-info text-dark">Dari: {{ $barter->dosenPengaju->biodata->nama ?? $barter->dosenPengaju->username }}</span>
                        @endif
                    </td>
                    <td>
                        @if($barter->dosen_pengaju_id == Auth::id())
                            {{ $barter->jadwalA->suratTugasMengajar->mataKuliah->nama }}<br>
                            {{ $barter->jadwalA->suratTugasMengajar->kelas->nama }}
                        @else
                            {{ $barter->jadwalB->suratTugasMengajar->mataKuliah->nama }}<br>
                            {{ $barter->jadwalB->suratTugasMengajar->kelas->nama }}
                        @endif
                    </td>
                    <td>
                        @if($barter->dosen_pengaju_id == Auth::id())
                            {{ $barter->jadwalB->suratTugasMengajar->mataKuliah->nama }}<br>
                            {{ $barter->jadwalB->suratTugasMengajar->kelas->nama }}
                        @else
                            {{ $barter->jadwalA->suratTugasMengajar->mataKuliah->nama }}<br>
                            {{ $barter->jadwalA->suratTugasMengajar->kelas->nama }}
                        @endif
                    </td>
                    <td>
                        @if($barter->status_id == 4)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Disetujui
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle"></i> Ditolak
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                        <i class="bi bi-info-circle me-1"></i> Belum ada riwayat barter
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
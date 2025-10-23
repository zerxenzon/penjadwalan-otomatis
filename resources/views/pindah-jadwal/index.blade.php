@extends('layouts.dashboard')

@section('title', 'Permintaan Pindah Jadwal')

@section('dashboard-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Permintaan Pindah Jadwal</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Filter Status -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="status_filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="3" {{ request('status_filter') == 3 ? 'selected' : '' }}>Pending</option>
                    <option value="4" {{ request('status_filter') == 4 ? 'selected' : '' }}>Disetujui</option>
                    <option value="5" {{ request('status_filter') == 5 ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('pindah-jadwal.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Dosen</th>
                        <th>Jadwal Lama</th>
                        <th>Jadwal Baru (Usulan)</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pindahJadwalList as $index => $pindah)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pindah->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            {{ $pindah->dosen->nama }}<br>
                            <small class="text-muted">{{ $pindah->dosen->biodata->nip ?? '-' }}</small>
                        </td>
                        <td>
                            @if($pindah->jadwalLama)
                                <strong>{{ $pindah->jadwalLama->suratTugasMengajar->mataKuliah->nama }}</strong><br>
                                <small class="text-muted">
                                    {{ $pindah->jadwalLama->suratTugasMengajar->kelas->nama }}<br>
                                    {{ ucfirst($pindah->jadwalLama->hari) }}, 
                                    {{ \Carbon\Carbon::parse($pindah->jadwalLama->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($pindah->jadwalLama->jam_selesai)->format('H:i') }}<br>
                                    {{ $pindah->jadwalLama->ruangan->nama ?? '-' }}
                                </small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($pindah->jadwalBaru)
                                @if($pindah->jadwalBaru->suratTugasMengajar)
                                    <strong>{{ $pindah->jadwalBaru->suratTugasMengajar->mataKuliah->nama }}</strong><br>
                                    <small class="text-muted">
                                        {{ $pindah->jadwalBaru->suratTugasMengajar->kelas->nama }}<br>
                                        {{ ucfirst($pindah->jadwalBaru->hari) }}, 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_selesai)->format('H:i') }}<br>
                                        {{ $pindah->jadwalBaru->ruangan->nama ?? '-' }}
                                    </small>
                                @else
                                    <strong>Slot Kosong</strong><br>
                                    <small class="text-muted">
                                        {{ ucfirst($pindah->jadwalBaru->hari) }}, 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_selesai)->format('H:i') }}<br>
                                        {{ $pindah->jadwalBaru->ruangan->nama ?? '-' }}
                                    </small>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $pindah->alasan }}</small>
                        </td>
                        <td>
                            @if($pindah->status->nama == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($pindah->status->nama == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($pindah->status->nama == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($pindah->status->nama) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($pindah->status->nama == 'pending')
                                <div class="btn-group" role="group">
                                    <form action="{{ route('pindah-jadwal.update-status', $pindah->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menyetujui permintaan ini?')">
                                        @csrf
                                        <input type="hidden" name="status_id" value="4">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Setuju
                                        </button>
                                    </form>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm ms-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{ $pindah->id }}">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </div>

                                <!-- Modal Reject -->
                                <div class="modal fade" id="rejectModal{{ $pindah->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('pindah-jadwal.update-status', $pindah->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status_id" value="5">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tolak Permintaan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan Penolakan</label>
                                                        <textarea name="alasan_reject" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <small class="text-muted">Sudah diproses</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Tidak ada permintaan pindah jadwal</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
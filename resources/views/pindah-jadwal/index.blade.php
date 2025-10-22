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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Jadwal Lama</th>
                        <th>Jadwal Baru</th>
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
                            {{ $pindah->jadwalLama->suratTugasMengajar->mataKuliah->nama }} -
                            {{ $pindah->jadwalLama->suratTugasMengajar->kelas->nama }}
                            <br>
                            <small class="text-muted">
                                {{ $pindah->jadwalLama->ruangan->nama }},
                                {{ $pindah->jadwalLama->hari }},
                                {{ $pindah->jadwalLama->jam_mulai }} - {{ $pindah->jadwalLama->jam_selesai }}
                            </small>
                        </td>
                        <td>
                            {{ $pindah->jadwalBaru->suratTugasMengajar->mataKuliah->nama }} -
                            {{ $pindah->jadwalBaru->suratTugasMengajar->kelas->nama }}
                            <br>
                            <small class="text-muted">
                                {{ $pindah->jadwalBaru->ruangan->nama }},
                                {{ $pindah->jadwalBaru->hari }},
                                {{ $pindah->jadwalBaru->jam_mulai }} - {{ $pindah->jadwalBaru->jam_selesai }}
                            </small>
                        </td>
                        <td>{{ $pindah->alasan }}</td>
                        <td>
                            <span class="badge bg-{{ $pindah->status_id == 3 ? 'warning' : ($pindah->status_id == 4 ? 'success' : 'danger') }}">
                                {{ $pindah->status->nama }}
                            </span>
                        </td>
                        <td>
                            @if($pindah->status_id == 3)
                            <div class="btn-group">
                                <form action="{{ route('pindah-jadwal.update-status', $pindah->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status_id" value="4">
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui permintaan pindah jadwal ini?')">
                                        <i class="bi bi-check-lg"></i> Setuju
                                    </button>
                                </form>
                                <form action="{{ route('pindah-jadwal.update-status', $pindah->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <input type="hidden" name="status_id" value="5">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak permintaan pindah jadwal ini?')">
                                        <i class="bi bi-x-lg"></i> Tolak
                                    </button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada permintaan pindah jadwal</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
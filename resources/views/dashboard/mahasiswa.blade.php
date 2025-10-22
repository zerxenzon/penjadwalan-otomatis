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
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Ruangan</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalList as $index => $jadwal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $jadwal->suratTugasMengajar->mataKuliah->nama }}
                            <br>
                            <small class="text-muted">{{ $jadwal->suratTugasMengajar->mataKuliah->kode }}</small>
                        </td>
                        <td>{{ $jadwal->suratTugasMengajar->dosen->biodata->nama }}</td>
                        <td>{{ $jadwal->ruangan->nama }}</td>
                        <td>{{ ucfirst($jadwal->hari) }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada jadwal kuliah</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

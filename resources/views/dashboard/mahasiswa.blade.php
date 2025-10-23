@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard Mahasiswa</h1>
    <div>
        <span class="text-muted me-3">{{ now()->format('d F Y') }}</span>
        @if(isset($kelas))
        <span class="badge bg-primary">Kelas: {{ $kelas->nama }}</span>
        @endif
    </div>
</div>

<!-- Error Alert -->
@if(isset($error))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Perhatian!</strong> {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Notifikasi Perubahan Jadwal -->
@if(isset($recentChanges) && $recentChanges->count() > 0)
<div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
    <h5 class="alert-heading"><i class="bi bi-bell-fill"></i> Perubahan Jadwal Terbaru!</h5>
    <p class="mb-2">Ada perubahan jadwal kuliah kelas Anda:</p>
    <ul class="mb-0">
        @foreach($recentChanges as $change)
        <li>
            <strong>{{ $change->jadwalLama->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}</strong> 
            dipindah ke 
            <strong>{{ ucfirst($change->jadwalBaru->hari ?? 'N/A') }}</strong>
            {{ date('H:i', strtotime($change->jadwalBaru->jam_mulai ?? '00:00')) }}
            - {{ $change->jadwalBaru->ruangan->nama ?? 'N/A' }}
            <small class="text-muted">({{ $change->updated_at->diffForHumans() }})</small>
        </li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Action Buttons -->
<div class="mb-4">
    <button class="btn btn-primary me-2" onclick="showTableView()">
        <i class="bi bi-table"></i> Tampilan Tabel
    </button>
    <button class="btn btn-success me-2" onclick="showCalendarView()">
        <i class="bi bi-calendar3"></i> Tampilan Kalender
    </button>
    <a href="{{ route('mahasiswa.jadwal.export-pdf') }}" class="btn btn-danger" target="_blank">
        <i class="bi bi-file-pdf"></i> Export PDF
    </a>
    <button class="btn btn-secondary" onclick="window.print()">
        <i class="bi bi-printer"></i> Cetak
    </button>
</div>

<!-- Tampilan Tabel (Default) -->
<div id="tableView" class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-table"></i> Jadwal Kelas (Tampilan Tabel)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Ruangan</th>
                        <th>SKS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalList as $index => $jadwal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ ucfirst($jadwal->hari) }}</strong></td>
                        <td>
                            <i class="bi bi-clock"></i>
                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} 
                            - 
                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                        </td>
                        <td>
                            <strong>{{ $jadwal->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}</strong>
                            <br>
                            <small class="text-muted">{{ $jadwal->suratTugasMengajar->mataKuliah->kode ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $jadwal->suratTugasMengajar->dosen->nama ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $jadwal->ruangan->nama ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $jadwal->suratTugasMengajar->mataKuliah->sks ?? 'N/A' }} SKS</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada jadwal kuliah</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tampilan Kalender (Hidden by default) -->
<div id="calendarView" class="d-none">
    @if(isset($jadwalGrouped) && $jadwalGrouped->count() > 0)
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
                                <th style="width: 15%">Waktu</th>
                                <th style="width: 30%">Mata Kuliah</th>
                                <th style="width: 25%">Dosen</th>
                                <th style="width: 20%">Ruangan</th>
                                <th style="width: 10%">SKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalGrouped[$hari]->sortBy('jam_mulai') as $jadwal)
                            <tr>
                                <td>
                                    <i class="bi bi-clock text-primary"></i>
                                    <strong>{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</strong>
                                    -
                                    <strong>{{ date('H:i', strtotime($jadwal->jam_selesai)) }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $jadwal->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $jadwal->suratTugasMengajar->mataKuliah->kode ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $jadwal->suratTugasMengajar->dosen->nama ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $jadwal->ruangan->nama ?? 'N/A' }}</span>
                                    <br>
                                    <small class="text-muted">Kapasitas: {{ $jadwal->ruangan->kapasitas ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $jadwal->suratTugasMengajar->mataKuliah->sks ?? 'N/A' }}</span>
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
    @else
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle fs-3"></i>
        <p class="mb-0 mt-2">Belum ada jadwal untuk kelas ini.</p>
    </div>
    @endif
</div>

<script>
function showTableView() {
    document.getElementById('tableView').classList.remove('d-none');
    document.getElementById('calendarView').classList.add('d-none');
}

function showCalendarView() {
    document.getElementById('tableView').classList.add('d-none');
    document.getElementById('calendarView').classList.remove('d-none');
}
</script>

<style>
    @media print {
        .btn, .alert-dismissible .btn-close, .badge.float-end {
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

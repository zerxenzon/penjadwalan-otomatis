@extends('layouts.dashboard')

@section('title', 'Jadwal Mengajar')

@section('dashboard-content')
<div class="mb-4">
    <h1 class="h3">Jadwal Mengajar</h1>
    <p class="text-muted">Berikut adalah daftar jadwal mengajar Anda di semester ini.</p>
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

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0"><i class="bi bi-calendar2-week text-primary me-2"></i>Jadwal Mengajar</h5>
        <a href="{{ route('charter-jadwal.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle me-1"></i> Charter Jadwal
        </a>
    </div>
    
    @php
    // Group jadwal by day
    $jadwalByDay = $jadwalList->groupBy('hari');
    $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
    @endphp
    
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th width="15%">Hari</th>
                    <th width="15%">Jam</th>
                    <th width="25%">Mata Kuliah</th>
                    <th width="15%">Kelas</th>
                    <th width="15%">Ruangan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($days as $day)
                    @if(isset($jadwalByDay[$day]))
                        @foreach($jadwalByDay[$day]->sortBy('jam_mulai') as $jadwal)
                            <tr>
                                <td>{{ ucfirst($jadwal->hari) }}</td>
                                <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                <td>
                                    <span class="fw-bold">{{ $jadwal->suratTugasMengajar->mataKuliah->nama }}</span>
                                    <br>
                                    <small class="text-muted">{{ $jadwal->suratTugasMengajar->mataKuliah->kode }} ({{ $jadwal->suratTugasMengajar->mataKuliah->sks }} SKS)</small>
                                </td>
                                <td>{{ $jadwal->suratTugasMengajar->kelas->nama }}</td>
                                <td>{{ $jadwal->ruangan->nama }}</td>
                                <td>
                                    <a href="{{ route('barter-jadwal.create') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-arrow-left-right"></i> Barter
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-info-circle me-1"></i> Anda belum memiliki jadwal mengajar.
                            <br><br>
                            <a href="{{ route('charter-jadwal.index') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Charter Jadwal Sekarang
                            </a>
                        </td>
                    </tr>
                @endforelse
                
                @if($jadwalList->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-info-circle me-1"></i> Anda belum memiliki jadwal mengajar.
                            <br><br>
                            <a href="{{ route('charter-jadwal.index') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Charter Jadwal Sekarang
                            </a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
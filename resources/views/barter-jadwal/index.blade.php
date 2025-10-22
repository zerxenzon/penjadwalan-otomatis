@extends('layouts.dashboard')

@section('title', 'Barter Jadwal')

@section('dashboard-content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Barter Jadwal</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBarterJadwal">
            Ajukan Barter Jadwal
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Daftar Pengajuan Barter Jadwal</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Dosen Pengaju</th>
                            <th>Jadwal Yang Ditukar</th>
                            <th>Dosen Tujuan</th>
                            <th>Jadwal Yang Diminta</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barterList as $index => $barter)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $barter->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $barter->dosenPengaju->biodata->nama }}</td>
                            <td>
                                {{ $barter->jadwalPengaju->suratTugasMengajar->mataKuliah->nama }} -
                                {{ $barter->jadwalPengaju->suratTugasMengajar->kelas->nama }}
                                <br>
                                <small class="text-muted">
                                    {{ $barter->jadwalPengaju->hari }},
                                    {{ $barter->jadwalPengaju->jam_mulai }} - {{ $barter->jadwalPengaju->jam_selesai }}
                                </small>
                            </td>
                            <td>{{ $barter->dosenTujuan->biodata->nama }}</td>
                            <td>
                                {{ $barter->jadwalTujuan->mataKuliah->nama }} -
                                {{ $barter->jadwalTujuan->kelas->nama }}
                                <br>
                                <small class="text-muted">
                                    {{ $barter->jadwalTujuan->shift->hari }},
                                    {{ $barter->jadwalTujuan->shift->jam_mulai }} - {{ $barter->jadwalTujuan->shift->jam_selesai }}
                                </small>
                            </td>
                            <td>
                                @if($barter->status_id == 1)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($barter->status_id == 2)
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($barter->dosen_tujuan_id == auth()->id() && $barter->status_id == 1)
                                <div class="btn-group" role="group">
                                    <form action="{{ route('barter-jadwal.update-status', $barter->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status_id" value="2">
                                        <button type="submit" class="btn btn-sm btn-success me-1">Setuju</button>
                                    </form>
                                    <form action="{{ route('barter-jadwal.update-status', $barter->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status_id" value="3">
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada pengajuan barter jadwal</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Barter Jadwal -->
<div class="modal fade" id="modalBarterJadwal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('barter-jadwal.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajukan Barter Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Jadwal Anda</label>
                        <select name="jadwal_pengaju_id" class="form-select" required>
                            <option value="">Pilih Jadwal</option>
                            @foreach($jadwalSaya as $jadwal)
                            <option value="{{ $jadwal->id }}">
                                {{ $jadwal->mataKuliah->nama }} - {{ $jadwal->kelas->nama }}
                                ({{ $jadwal->shift->hari }}, {{ $jadwal->shift->jam_mulai }} - {{ $jadwal->shift->jam_selesai }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Dosen Tujuan</label>
                        <select name="dosen_tujuan_id" class="form-select" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosenList as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->biodata->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Jadwal Yang Diinginkan</label>
                        <select name="jadwal_tujuan_id" class="form-select" required>
                            <option value="">Pilih Jadwal</option>
                            <!-- Will be populated via AJAX -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alasan Barter</label>
                        <textarea name="alasan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan Barter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('select[name="dosen_tujuan_id"]').addEventListener('change', function() {
    const dosenId = this.value;
    const jadwalTujuanSelect = document.querySelector('select[name="jadwal_tujuan_id"]');
    
    if (dosenId) {
        // Clear current options
        jadwalTujuanSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
        
        // Fetch jadwal for selected dosen via AJAX
        fetch(`/api/dosen/${dosenId}/jadwal`)
            .then(response => response.json())
            .then(jadwalList => {
                jadwalList.forEach(jadwal => {
                    const option = document.createElement('option');
                    option.value = jadwal.id;
                    option.textContent = `${jadwal.mata_kuliah.nama} - ${jadwal.kelas.nama} (${jadwal.shift.hari}, ${jadwal.shift.jam_mulai} - ${jadwal.shift.jam_selesai})`;
                    jadwalTujuanSelect.appendChild(option);
                });
            });
    }
});
</script>
@endpush
@endsection
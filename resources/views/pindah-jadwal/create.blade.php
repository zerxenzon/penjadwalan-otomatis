@extends('layouts.dashboard')

@section('title', 'Ajukan Pindah Jadwal')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3"><i class="bi bi-clock-history"></i> Ajukan Pindah Jadwal</h1>
        <p class="text-muted mb-0">Ajukan permintaan pindah jadwal kepada KOSMA</p>
    </div>
</div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Error!</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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
            <h5 class="mb-0"><i class="bi bi-file-earmark-plus"></i> Form Permintaan Pindah Jadwal</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pindah-jadwal.store') }}" method="POST">
                @csrf

                <!-- Jadwal Lama -->
                <div class="mb-4">
                    <label for="jadwal_lama_id" class="form-label fw-bold">
                        Jadwal Lama (yang akan dipindah) <span class="text-danger">*</span>
                    </label>
                    <select name="jadwal_lama_id" id="jadwal_lama_id" class="form-select" required>
                        <option value="">-- Pilih Jadwal yang Ingin Dipindah --</option>
                        @forelse($myJadwal as $jadwal)
                        <option value="{{ $jadwal->id }}" 
                                data-hari="{{ $jadwal->hari }}"
                                data-jam="{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}"
                                data-ruangan="{{ $jadwal->ruangan->nama ?? 'N/A' }}"
                                data-matkul="{{ $jadwal->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}"
                                data-kelas="{{ $jadwal->suratTugasMengajar->kelas->nama ?? 'N/A' }}">
                            {{ ucfirst($jadwal->hari) }} | 
                            {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }} | 
                            {{ $jadwal->ruangan->nama ?? 'N/A' }} | 
                            {{ $jadwal->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }} 
                            ({{ $jadwal->suratTugasMengajar->kelas->nama ?? 'N/A' }})
                        </option>
                        @empty
                        <option disabled>Tidak ada jadwal tersedia</option>
                        @endforelse
                    </select>
                    <small class="text-muted">Pilih jadwal Anda yang ingin dipindahkan</small>
                </div>

                <!-- Preview Jadwal Lama -->
                <div id="preview-lama" class="mb-4 p-3 bg-light rounded d-none">
                    <h6 class="fw-bold">📅 Preview Jadwal Lama:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Hari:</strong> <span id="prev-lama-hari">-</span></p>
                            <p class="mb-1"><strong>Waktu:</strong> <span id="prev-lama-jam">-</span></p>
                            <p class="mb-0"><strong>Ruangan:</strong> <span id="prev-lama-ruangan">-</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Mata Kuliah:</strong> <span id="prev-lama-matkul">-</span></p>
                            <p class="mb-0"><strong>Kelas:</strong> <span id="prev-lama-kelas">-</span></p>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Baru -->
                <div class="mb-4">
                    <label for="jadwal_baru_id" class="form-label fw-bold">
                        Jadwal Baru (slot tujuan) <span class="text-danger">*</span>
                    </label>
                    <select name="jadwal_baru_id" id="jadwal_baru_id" class="form-select" required>
                        <option value="">-- Pilih Slot Jadwal Baru --</option>
                        @forelse($availableSlots as $slot)
                        <option value="{{ $slot->id }}"
                                data-hari="{{ $slot->hari }}"
                                data-jam="{{ date('H:i', strtotime($slot->jam_mulai)) }} - {{ date('H:i', strtotime($slot->jam_selesai)) }}"
                                data-ruangan="{{ $slot->ruangan->nama ?? 'N/A' }}">
                            {{ ucfirst($slot->hari) }} | 
                            {{ date('H:i', strtotime($slot->jam_mulai)) }} - {{ date('H:i', strtotime($slot->jam_selesai)) }} | 
                            {{ $slot->ruangan->nama ?? 'N/A' }}
                        </option>
                        @empty
                        <option disabled>Tidak ada slot tersedia</option>
                        @endforelse
                    </select>
                    <small class="text-muted">Pilih slot jadwal kosong yang ingin Anda gunakan</small>
                </div>

                <!-- Preview Jadwal Baru -->
                <div id="preview-baru" class="mb-4 p-3 bg-light rounded d-none">
                    <h6 class="fw-bold">📅 Preview Jadwal Baru:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Hari:</strong> <span id="prev-baru-hari">-</span></p>
                            <p class="mb-1"><strong>Waktu:</strong> <span id="prev-baru-jam">-</span></p>
                            <p class="mb-0"><strong>Ruangan:</strong> <span id="prev-baru-ruangan">-</span></p>
                        </div>
                    </div>
                </div>

                <!-- KOSMA -->
                <div class="mb-4">
                    <label for="kosma_id" class="form-label fw-bold">
                        KOSMA yang Akan Approve <span class="text-danger">*</span>
                    </label>
                    <select name="kosma_id" id="kosma_id" class="form-select" required>
                        <option value="">-- Pilih KOSMA --</option>
                        @foreach($kosmaList as $kosma)
                        <option value="{{ $kosma->id }}">
                            {{ $kosma->nama }} ({{ $kosma->role->nama ?? 'N/A' }})
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih KOSMA yang akan menyetujui permintaan ini</small>
                </div>

                <!-- Alasan -->
                <div class="mb-4">
                    <label for="alasan" class="form-label fw-bold">
                        Alasan Pindah Jadwal <span class="text-danger">*</span>
                    </label>
                    <textarea name="alasan" id="alasan" class="form-control" rows="5" required placeholder="Jelaskan alasan Anda ingin memindahkan jadwal...">{{ old('alasan') }}</textarea>
                    <small class="text-muted">Jelaskan alasan yang jelas dan valid</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pindah-jadwal.dosen-index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Ajukan Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview Jadwal Lama
    document.getElementById('jadwal_lama_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const preview = document.getElementById('preview-lama');
        
        if (this.value) {
            document.getElementById('prev-lama-hari').textContent = option.dataset.hari;
            document.getElementById('prev-lama-jam').textContent = option.dataset.jam;
            document.getElementById('prev-lama-ruangan').textContent = option.dataset.ruangan;
            document.getElementById('prev-lama-matkul').textContent = option.dataset.matkul;
            document.getElementById('prev-lama-kelas').textContent = option.dataset.kelas;
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });
    
    // Preview Jadwal Baru
    document.getElementById('jadwal_baru_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const preview = document.getElementById('preview-baru');
        
        if (this.value) {
            document.getElementById('prev-baru-hari').textContent = option.dataset.hari;
            document.getElementById('prev-baru-jam').textContent = option.dataset.jam;
            document.getElementById('prev-baru-ruangan').textContent = option.dataset.ruangan;
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });
});
</script>
@endsection

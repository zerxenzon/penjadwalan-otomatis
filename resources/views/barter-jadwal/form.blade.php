@extends('layouts.dashboard')

@section('title', 'Ajukan Barter Jadwal')

@section('dashboard-content')
<div class="mb-4">
    <h1 class="h3">Ajukan Barter Jadwal</h1>
    <p class="text-muted">Ajukan permintaan barter jadwal dengan dosen lain.</p>
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
    <div class="card-header bg-white">
        <h5 class="card-title mb-0"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Form Barter Jadwal</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('barter-jadwal.store') }}" method="POST">
            @csrf
            
            <!-- Jadwal Anda -->
            <div class="mb-4">
                <h6 class="fw-bold">1. Pilih Jadwal Anda</h6>
                <div class="form-group">
                    <label for="jadwal_id" class="form-label">Jadwal Yang Ingin Ditukar <span class="text-danger">*</span></label>
                    <select class="form-select @error('jadwal_id') is-invalid @enderror" id="jadwal_id" name="jadwal_id" required>
                        <option value="">-- Pilih Jadwal Anda --</option>
                        @forelse ($jadwalSaya as $jadwal)
                            <option value="{{ $jadwal->id }}" {{ old('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                                {{ $jadwal->suratTugasMengajar->mataKuliah->nama }} - 
                                {{ $jadwal->suratTugasMengajar->kelas->nama }} - 
                                {{ ucfirst($jadwal->hari) }}, 
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}, 
                                Ruang {{ $jadwal->ruangan->nama }}
                            </option>
                        @empty
                            <option value="" disabled>Anda belum memiliki jadwal yang di-charter</option>
                        @endforelse
                    </select>
                    @if($jadwalSaya->isEmpty())
                        <div class="form-text text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Anda belum memiliki jadwal. Silakan charter jadwal terlebih dahulu di menu Charter Jadwal.
                        </div>
                    @endif
                    @error('jadwal_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Dosen Tujuan -->
            <div class="mb-4">
                <h6 class="fw-bold">2. Pilih Dosen</h6>
                <div class="form-group">
                    <label for="dosen_tujuan_id" class="form-label">Dosen Tujuan <span class="text-danger">*</span></label>
                    <select class="form-select @error('dosen_tujuan_id') is-invalid @enderror" id="dosen_tujuan_id" name="dosen_tujuan_id" required>
                        <option value="">-- Pilih Dosen Tujuan --</option>
                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('dosen_tujuan_id') == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama }} {{ $dosen->biodata && $dosen->biodata->nip ? '('.$dosen->biodata->nip.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_tujuan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Jadwal Yang Diminta -->
            <div class="mb-4">
                <h6 class="fw-bold">3. Pilih Jadwal Yang Diminta</h6>
                <div class="form-group">
                    <label for="jadwal_tujuan_id" class="form-label">Jadwal Dosen Tujuan <span class="text-danger">*</span></label>
                    <select class="form-select @error('jadwal_tujuan_id') is-invalid @enderror" id="jadwal_tujuan_id" name="jadwal_tujuan_id" required disabled>
                        <option value="">-- Pilih dosen terlebih dahulu --</option>
                    </select>
                    @error('jadwal_tujuan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Alasan Barter -->
            <div class="mb-4">
                <h6 class="fw-bold">4. Alasan Barter</h6>
                <div class="form-group">
                    <label for="alasan" class="form-label">Alasan Mengajukan Barter <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alasan') is-invalid @enderror" id="alasan" name="alasan" rows="3" required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('barter-jadwal.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i> Ajukan Barter
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Barter jadwal form loaded');
    
    const dosenSelect = document.getElementById('dosen_tujuan_id');
    const jadwalSelect = document.getElementById('jadwal_tujuan_id');

    if (!dosenSelect || !jadwalSelect) {
        console.error('Select elements not found!');
        return;
    }

    console.log('Select elements found');

    dosenSelect.addEventListener('change', function() {
        const dosenId = this.value;
        console.log('Dosen selected:', dosenId);
        
        if (!dosenId) {
            jadwalSelect.innerHTML = '<option value="">-- Pilih dosen terlebih dahulu --</option>';
            jadwalSelect.disabled = true;
            return;
        }

        jadwalSelect.disabled = true;
        jadwalSelect.innerHTML = '<option value="">Memuat jadwal...</option>';

        const url = `/barter-jadwal/get-jadwal/${dosenId}`;
        console.log('Fetching jadwal from:', url);

        fetch(url)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(jadwalList => {
                console.log('Jadwal list received:', jadwalList);
                
                if (jadwalList.length === 0) {
                    jadwalSelect.innerHTML = '<option value="">Dosen ini belum memiliki jadwal</option>';
                    jadwalSelect.disabled = true;
                    return;
                }
                
                let options = '<option value="">-- Pilih Jadwal --</option>';
                jadwalList.forEach(jadwal => {
                    options += `<option value="${jadwal.id}">
                        ${jadwal.mata_kuliah} - ${jadwal.kelas} - 
                        ${jadwal.hari}, ${jadwal.jam_mulai} - ${jadwal.jam_selesai}, 
                        Ruang ${jadwal.ruangan}
                    </option>`;
                });
                
                jadwalSelect.innerHTML = options;
                jadwalSelect.disabled = false;
                console.log('Jadwal options loaded successfully');
            })
            .catch(error => {
                console.error('Error fetching jadwal:', error);
                jadwalSelect.innerHTML = '<option value="">Error memuat jadwal. Silakan coba lagi.</option>';
                jadwalSelect.disabled = true;
            });
    });

    // Trigger change event if dosen is already selected (for old input)
    if (dosenSelect.value) {
        console.log('Triggering change for pre-selected dosen');
        dosenSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush

@endsection
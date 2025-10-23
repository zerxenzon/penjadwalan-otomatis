@extends('layouts.dashboard')

@section('title', 'Charter Jadwal')

@section('dashboard-content')
<div class="mb-4">
    <h1 class="h3">Charter Jadwal</h1>
    <p class="text-muted">Charter jadwal adalah proses pengambilan slot jadwal yang masih kosong. Anda dapat memilih jadwal sesuai ketersediaan.</p>
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

<!-- Jadwal Yang Sudah Di-Charter -->
<div class="card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="bi bi-calendar-check text-primary me-2"></i>
            Jadwal Yang Sudah Di-charter ({{ $myCharters->count() }})
        </h5>
        <a href="{{ route('charter-jadwal.index', ['refresh' => time()]) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($myCharters as $index => $jadwal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($jadwal->suratTugasMengajar && $jadwal->suratTugasMengajar->mataKuliah)
                            {{ $jadwal->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}
                        @else
                            <span class="text-danger">Data tidak lengkap</span>
                        @endif
                    </td>
                    <td>
                        @if($jadwal->suratTugasMengajar && $jadwal->suratTugasMengajar->kelas)
                            {{ $jadwal->suratTugasMengajar->kelas->nama ?? 'N/A' }}
                        @else
                            <span class="text-danger">Data tidak lengkap</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($jadwal->hari) }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                    <td>{{ $jadwal->ruangan->nama ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('charter-jadwal.destroy', $jadwal->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan charter jadwal ini? Slot akan kembali tersedia untuk dosen lain.')">
                                <i class="bi bi-x-circle"></i> Batalkan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Anda belum melakukan charter jadwal.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Slot Jadwal Tersedia -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-calendar-plus text-success me-2"></i>
            Slot Jadwal Tersedia
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($slots as $index => $slot)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucfirst($slot->hari) }}</td>
                    <td>{{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}</td>
                    <td>{{ $slot->ruangan->nama }}</td>
                    <td>
                        <button type="button" 
                                class="btn btn-sm btn-success charter-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#charterModal"
                                data-jadwal-id="{{ $slot->id }}"
                                data-hari="{{ ucfirst($slot->hari) }}"
                                data-jam="{{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}"
                                data-ruangan="{{ $slot->ruangan->nama }}"
                                onclick="window.currentJadwalData = {id: '{{ $slot->id }}', hari: '{{ ucfirst($slot->hari) }}', jam: '{{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}', ruangan: '{{ $slot->ruangan->nama }}'}; console.log('Onclick set data:', window.currentJadwalData);">
                            <i class="bi bi-plus-circle"></i> Charter
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Tidak ada slot jadwal tersedia saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Charter Jadwal -->
<div class="modal fade" id="charterModal" tabindex="-1" aria-labelledby="charterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="charterModalLabel">Charter Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('charter-jadwal.store') }}" method="POST" id="charterForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="jadwal_id" id="jadwalId" value="">
                    <input type="hidden" name="semester_id" value="{{ $semester->id ?? '' }}">
                    
                    <!-- Debug display -->
                    <div class="alert alert-info alert-sm mb-3" id="debugInfo" style="display: none;">
                        <small>
                            <strong>Debug:</strong><br>
                            Jadwal ID: <span id="debugJadwalId">-</span>
                        </small>
                    </div>
                    
                    <!-- Show validation errors in modal -->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="mb-3 p-3 bg-light rounded">
                        <p class="mb-1"><strong>Hari:</strong> <span id="modalHari" class="text-primary">-</span></p>
                        <p class="mb-1"><strong>Jam:</strong> <span id="modalJam" class="text-primary">-</span></p>
                        <p class="mb-0"><strong>Ruangan:</strong> <span id="modalRuangan" class="text-primary">-</span></p>
                    </div>

                    <div class="mb-3">
                        <label for="mata_kuliah_id" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
                        <select class="form-select @error('mata_kuliah_id') is-invalid @enderror" id="mata_kuliah_id" name="mata_kuliah_id" required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            @foreach ($mataKuliah as $mk)
                                <option value="{{ $mk->id }}">{{ $mk->kode }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)</option>
                            @endforeach
                        </select>
                        @error('mata_kuliah_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitCharter"><i class="bi bi-check-circle me-1"></i> Charter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== Charter page loaded ===');
    
    const charterModal = document.getElementById('charterModal');
    const charterForm = document.getElementById('charterForm');
    const charterButtons = document.querySelectorAll('.charter-btn');
    const jadwalIdInput = document.getElementById('jadwalId');
    
    console.log('Found charter buttons:', charterButtons.length);
    
    // Use Bootstrap modal show event to set data
    charterModal.addEventListener('show.bs.modal', function (event) {
        console.log('=== Modal show.bs.modal event ===');
        
        // Method 1: Try global variable first (set by onclick)
        if (window.currentJadwalData) {
            console.log('✓ Using window.currentJadwalData:', window.currentJadwalData);
            
            jadwalIdInput.value = window.currentJadwalData.id;
            document.getElementById('modalHari').textContent = window.currentJadwalData.hari || '-';
            document.getElementById('modalJam').textContent = window.currentJadwalData.jam || '-';
            document.getElementById('modalRuangan').textContent = window.currentJadwalData.ruangan || '-';
            document.getElementById('debugJadwalId').textContent = window.currentJadwalData.id;
            document.getElementById('debugInfo').style.display = 'block';
            
            console.log('✓ jadwalId set to:', jadwalIdInput.value);
            return;
        }
        
        // Method 2: Try event.relatedTarget
        const button = event.relatedTarget;
        if (button) {
            console.log('✓ Using button from event.relatedTarget');
            
            const jadwalId = button.getAttribute('data-jadwal-id');
            const hari = button.getAttribute('data-hari');
            const jam = button.getAttribute('data-jam');
            const ruangan = button.getAttribute('data-ruangan');
            
            console.log('Button data:', {jadwalId, hari, jam, ruangan});
            
            jadwalIdInput.value = jadwalId;
            document.getElementById('modalHari').textContent = hari || '-';
            document.getElementById('modalJam').textContent = jam || '-';
            document.getElementById('modalRuangan').textContent = ruangan || '-';
            document.getElementById('debugJadwalId').textContent = jadwalId;
            document.getElementById('debugInfo').style.display = 'block';
            
            console.log('✓ jadwalId set to:', jadwalIdInput.value);
            return;
        }
        
        console.error('❌ Both methods failed!');
    });
    
    // Form submit validation
    charterForm.addEventListener('submit', function(e) {
        const jadwalIdValue = jadwalIdInput.value;
        const mataKuliahValue = document.getElementById('mata_kuliah_id').value;
        const kelasValue = document.getElementById('kelas_id').value;
        
        console.log('=== Form submitting ===');
        console.log('jadwal_id:', jadwalIdValue);
        console.log('mata_kuliah_id:', mataKuliahValue);
        console.log('kelas_id:', kelasValue);
        
        if (!jadwalIdValue || jadwalIdValue === '' || jadwalIdValue === 'null') {
            e.preventDefault();
            console.error('❌ Form submission prevented: jadwal_id is empty!');
            alert('Error: Slot jadwal tidak dipilih dengan benar.\n\nSilakan:\n1. Tutup modal ini\n2. Klik tombol Charter lagi\n3. Pastikan Hari, Jam, Ruangan muncul');
            return false;
        }
        
        console.log('✓ Submitting form...');
        
        const submitBtn = document.getElementById('submitCharter');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
    });
    
    // Reset form when modal is closed
    charterModal.addEventListener('hidden.bs.modal', function () {
        console.log('Modal closed, resetting');
        charterForm.reset();
        jadwalIdInput.value = '';
        document.getElementById('modalHari').textContent = '-';
        document.getElementById('modalJam').textContent = '-';
        document.getElementById('modalRuangan').textContent = '-';
        document.getElementById('debugInfo').style.display = 'none';
        window.currentJadwalData = null;
        
        const submitBtn = document.getElementById('submitCharter');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Charter';
    });
    
    // Auto-show modal if validation errors
    @if ($errors->any())
        console.log('Validation errors, showing modal');
        new bootstrap.Modal(charterModal).show();
        @if(old('jadwal_id'))
            jadwalIdInput.value = '{{ old('jadwal_id') }}';
        @endif
        @if(old('mata_kuliah_id'))
            document.getElementById('mata_kuliah_id').value = '{{ old('mata_kuliah_id') }}';
        @endif
        @if(old('kelas_id'))
            document.getElementById('kelas_id').value = '{{ old('kelas_id') }}';
        @endif
    @endif
});
</script>
@endpush
@endsection
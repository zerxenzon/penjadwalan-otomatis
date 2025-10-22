@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ajukan Barter Jadwal</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('barter-jadwal.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Jadwal Saya yang Akan Dibarter</label>
                            <div class="col-md-8">
                                <select name="jadwal_dosen_a_id" class="form-control" required>
                                    <option value="">Pilih Jadwal</option>
                                    @foreach($myJadwal as $jadwal)
                                    <option value="{{ $jadwal->id }}">
                                        {{ $jadwal->mataKuliah->nama }} - 
                                        {{ $jadwal->kelas->nama }} - 
                                        Semester {{ $jadwal->semester->nama }} - 
                                        {{ $jadwal->shift->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Pilih Dosen Tujuan</label>
                            <div class="col-md-8">
                                <select name="dosen_tujuan_id" id="dosen_tujuan_id" class="form-control" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach($dosenList as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Jadwal yang Ingin Dibarter</label>
                            <div class="col-md-8">
                                <select name="jadwal_dosen_b_id" id="jadwal_dosen_b" class="form-control" required disabled>
                                    <option value="">Pilih Jadwal</option>
                                </select>
                                <small class="text-muted">Pilih dosen terlebih dahulu</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Alasan Barter</label>
                            <div class="col-md-8">
                                <textarea name="alasan" class="form-control" rows="3" required 
                                    placeholder="Jelaskan alasan anda mengajukan barter jadwal"></textarea>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    Ajukan Barter
                                </button>
                                <a href="{{ route('barter-jadwal.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dosenSelect = document.getElementById('dosen_tujuan_id');
    const jadwalSelect = document.getElementById('jadwal_dosen_b');

    dosenSelect.addEventListener('change', function() {
        const dosenId = this.value;
        jadwalSelect.disabled = true;
        jadwalSelect.innerHTML = '<option value="">Memuat jadwal...</option>';

        if (dosenId) {
            fetch(`/barter-jadwal/get-jadwal/${dosenId}`)
                .then(response => response.json())
                .then(data => {
                    jadwalSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
                    data.forEach(jadwal => {
                        jadwalSelect.innerHTML += `
                            <option value="${jadwal.id}">
                                ${jadwal.mata_kuliah.nama} - 
                                ${jadwal.kelas.nama} - 
                                Semester ${jadwal.semester.nama} - 
                                ${jadwal.shift.nama}
                            </option>`;
                    });
                    jadwalSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    jadwalSelect.innerHTML = '<option value="">Error memuat jadwal</option>';
                });
        } else {
            jadwalSelect.innerHTML = '<option value="">Pilih dosen terlebih dahulu</option>';
        }
    });
});
</script>
@endpush
@endsection
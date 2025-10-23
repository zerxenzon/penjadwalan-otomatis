{{-- filepath: d:\laragon\www\penjadwalan\resources\views\kelas\form.blade.php --}}
@extends('layouts.dashboard')

@section('title', isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas')

@section('dashboard-content')
<div class="row">
    <div class="col-md-8">
        <h1 class="h3 mb-4">
            {{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas Baru' }}
        </h1>

        <div class="card">
            <div class="card-body">
                <form method="POST" 
                    action="{{ isset($kelas) ? route('kelas.perbarui', $kelas->id) : route('kelas.simpan') }}">
                    @csrf
                    @if (isset($kelas))
                        @method('PUT')
                    @endif

                    <!-- Nama Kelas -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">
                            Nama Kelas <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $kelas->nama ?? '') }}"
                               placeholder="Contoh: SI-R-SM3-20251"
                               required>
                        <small class="text-muted">Format: PRODI-SHIFT-SM#-ANGKATAN (contoh: SI-R-SM3-20251)</small>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Angkatan -->
                    <div class="mb-3">
                        <label for="angkatan_id" class="form-label">
                            Angkatan <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('angkatan_id') is-invalid @enderror" 
                                id="angkatan_id" 
                                name="angkatan_id" 
                                required>
                            <option value="">-- Pilih Angkatan --</option>
                            @foreach ($angkatan as $a)
                                <option value="{{ $a->id }}" 
                                    {{ old('angkatan_id', $kelas->angkatan_id ?? '') == $a->id ? 'selected' : '' }}>
                                    {{ $a->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('angkatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Program Studi -->
                    <div class="mb-3">
                        <label for="prodi_id" class="form-label">
                            Program Studi <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('prodi_id') is-invalid @enderror" 
                                id="prodi_id" 
                                name="prodi_id" 
                                required>
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->id }}" 
                                    {{ old('prodi_id', $kelas->prodi_id ?? '') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div class="mb-3">
                        <label for="semester_id" class="form-label">
                            Semester <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('semester_id') is-invalid @enderror" 
                                id="semester_id" 
                                name="semester_id" 
                                required>
                            <option value="">-- Pilih Semester --</option>
                            @foreach ($semester as $s)
                                <option value="{{ $s->id }}" 
                                    {{ old('semester_id', $kelas->semester_id ?? '') == $s->id ? 'selected' : '' }}>
                                    {{ $s->kode_semester }} ({{ ucfirst($s->tipe) }})
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Shift -->
                    <div class="mb-3">
                        <label for="shift_id" class="form-label">
                            Shift <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('shift_id') is-invalid @enderror" 
                                id="shift_id" 
                                name="shift_id" 
                                required>
                            <option value="">-- Pilih Shift --</option>
                            @foreach ($shift as $sh)
                                <option value="{{ $sh->id }}" 
                                    {{ old('shift_id', $kelas->shift_id ?? '') == $sh->id ? 'selected' : '' }}>
                                    {{ $sh->nama }} ({{ $sh->jam_mulai ? $sh->jam_mulai->format('H:i') : '' }} - {{ $sh->jam_selesai ? $sh->jam_selesai->format('H:i') : '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('shift_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status_id" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status_id') is-invalid @enderror" 
                                id="status_id" 
                                name="status_id" 
                                required>
                            <option value="">-- Pilih Status --</option>
                            @foreach ($status as $st)
                                <option value="{{ $st->id }}" 
                                    {{ old('status_id', $kelas->status_id ?? 1) == $st->id ? 'selected' : '' }}>
                                    {{ ucfirst($st->nama) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ isset($kelas) ? 'Perbarui' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Panel -->
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title fw-bold">
                    <i class="bi bi-info-circle text-primary me-2"></i>Panduan Penamaan Kelas
                </h6>
                <hr>
                <p class="small mb-2"><strong>Format:</strong> PRODI-SHIFT-SM#-ANGKATAN</p>
                <ul class="small mb-0">
                    <li><strong>PRODI:</strong> Kode prodi (SI, TI, MI)</li>
                    <li><strong>SHIFT:</strong> R (Reguler) atau NR (Non-Reguler)</li>
                    <li><strong>SM#:</strong> Semester (SM1, SM3, SM5, dll)</li>
                    <li><strong>ANGKATAN:</strong> Tahun dan semester masuk (20251 = 2025 semester 1)</li>
                </ul>
                <hr>
                <p class="small text-muted mb-0">
                    <i class="bi bi-lightbulb me-1"></i>
                    <strong>Contoh:</strong><br>
                    SI-R-SM3-20251 = Sistem Informasi, Reguler, Semester 3, Angkatan 2025/1
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
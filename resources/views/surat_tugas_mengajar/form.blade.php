@extends('layouts.dashboard')

@section('title', isset($suratTugas) ? 'Edit Surat Tugas' : 'Tambah Surat Tugas Mengajar')

@section('dashboard-content')
<div class="row">
    <div class="col-md-8">
        <h1 class="h3 mb-4">
            {{ isset($suratTugas) ? 'Edit Surat Tugas' : 'Tambah Surat Tugas Mengajar Baru' }}
        </h1>

        <div class="card">
            <div class="card-body">
                <form method="POST" 
                    action="{{ isset($suratTugas) ? route('surat-tugas.perbarui', $suratTugas->id) : route('surat-tugas.simpan') }}">
                    @csrf
                    @if (isset($suratTugas))
                        @method('PUT')
                    @endif

                    <!-- Dosen -->
                    <div class="mb-3">
                        <label for="dosen_id" class="form-label fw-semibold">Dosen *</label>
                        <select class="form-select @error('dosen_id') is-invalid @enderror" id="dosen_id" name="dosen_id" required>
                            <option value="">-- Pilih Dosen --</option>
                            @foreach ($dosen as $d)
                                <option value="{{ $d->id }}" {{ old('dosen_id', $suratTugas->dosen_id ?? '') == $d->id ? 'selected' : '' }}>
                                    {{ $d->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('dosen_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mata Kuliah -->
                    <div class="mb-3">
                        <label for="mata_kuliah_id" class="form-label fw-semibold">Mata Kuliah *</label>
                        <select class="form-select @error('mata_kuliah_id') is-invalid @enderror" id="mata_kuliah_id" name="mata_kuliah_id" required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            @foreach ($mataKuliah as $mk)
                                <option value="{{ $mk->id }}" {{ old('mata_kuliah_id', $suratTugas->mata_kuliah_id ?? '') == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->kode }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)
                                </option>
                            @endforeach
                        </select>
                        @error('mata_kuliah_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label fw-semibold">Kelas *</label>
                        <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $suratTugas->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div class="mb-3">
                        <label for="semester_id" class="form-label fw-semibold">Semester *</label>
                        <select class="form-select @error('semester_id') is-invalid @enderror" id="semester_id" name="semester_id" required>
                            <option value="">-- Pilih Semester --</option>
                            @foreach ($semester as $s)
                                <option value="{{ $s->id }}" {{ old('semester_id', $suratTugas->semester_id ?? '') == $s->id ? 'selected' : '' }}>
                                    {{ $s->kode_semester }} ({{ ucfirst($s->tipe) }})
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-semibold">Catatan / Keterangan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan', $suratTugas->catatan ?? '') }}</textarea>
                    </div>

                    <!-- Status (hanya untuk draft) -->
                    @if (!isset($suratTugas) || $suratTugas->status_id == 6)
                        <div class="mb-3">
                            <label for="status_id" class="form-label fw-semibold">Status *</label>
                            <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach ($status as $s)
                                    @if ($s->id == 6 || !isset($suratTugas))
                                        <option value="{{ $s->id }}" {{ old('status_id', $suratTugas->status_id ?? 6) == $s->id ? 'selected' : '' }}>
                                            {{ ucfirst($s->nama) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> {{ isset($suratTugas) ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">Informasi</h6>
                <div class="text-sm">
                    <p><strong>Status Workflow:</strong></p>
                    <ol class="small">
                        <li>Draft - Data masih bisa diedit</li>
                        <li>Pending - Menunggu approval Dekan</li>
                        <li>Approved - Sudah disetujui Dekan</li>
                        <li>Published - Dosen sudah diberitahu</li>
                    </ol>
                    <hr>
                    <p class="text-danger small mb-0">
                        <i class="bi bi-info-circle"></i> Hanya surat tugas dengan status <strong>Draft</strong> yang bisa diedit atau dihapus.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

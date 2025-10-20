@extends('layouts.dashboard')

@section('title', isset($mataKuliah) ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah')

@section('dashboard-content')
<div class="row">
    <div class="col-md-8">
        <h1 class="h3 mb-4">
            {{ isset($mataKuliah) ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah Baru' }}
        </h1>

        <div class="card">
            <div class="card-body">
                <form method="POST" 
                    action="{{ isset($mataKuliah) ? route('mata_kuliah.perbarui', $mataKuliah->id) : route('mata_kuliah.simpan') }}">
                    @csrf
                    @if (isset($mataKuliah))
                        @method('PUT')
                    @endif

                    <!-- Kode -->
                    <div class="mb-3">
                        <label for="kode" class="form-label fw-semibold">Kode Mata Kuliah *</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                            id="kode" name="kode" value="{{ old('kode', $mataKuliah->kode ?? '') }}" required>
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Mata Kuliah *</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                            id="nama" name="nama" value="{{ old('nama', $mataKuliah->nama ?? '') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SKS -->
                    <div class="mb-3">
                        <label for="sks" class="form-label fw-semibold">SKS (Satuan Kredit Semester) *</label>
                        <select class="form-select @error('sks') is-invalid @enderror" id="sks" name="sks" required>
                            <option value="">-- Pilih SKS --</option>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ old('sks', $mataKuliah->sks ?? '') == $i ? 'selected' : '' }}>
                                    {{ $i }} SKS
                                </option>
                            @endfor
                        </select>
                        @error('sks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prodi -->
                    <div class="mb-3">
                        <label for="prodi_id" class="form-label fw-semibold">Program Studi *</label>
                        <select class="form-select @error('prodi_id') is-invalid @enderror" id="prodi_id" name="prodi_id" required>
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->id }}" {{ old('prodi_id', $mataKuliah->prodi_id ?? '') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status_id" class="form-label fw-semibold">Status *</label>
                        <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach ($status as $s)
                                <option value="{{ $s->id }}" {{ old('status_id', $mataKuliah->status_id ?? 1) == $s->id ? 'selected' : '' }}>
                                    {{ ucfirst($s->nama) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> {{ isset($mataKuliah) ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        <a href="{{ route('mata_kuliah.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

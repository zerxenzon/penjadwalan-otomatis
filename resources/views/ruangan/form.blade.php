@extends('layouts.dashboard')

@section('title', isset($ruangan) ? 'Edit Ruangan' : 'Tambah Ruangan')

@section('dashboard-content')
<div class="row">
    <div class="col-md-8">
        <h1 class="h3 mb-4">
            {{ isset($ruangan) ? 'Edit Ruangan' : 'Tambah Ruangan Baru' }}
        </h1>

        <div class="card">
            <div class="card-body">
                <form method="POST" 
                    action="{{ isset($ruangan) ? route('ruangan.perbarui', $ruangan->id) : route('ruangan.simpan') }}">
                    @csrf
                    @if (isset($ruangan))
                        @method('PUT')
                    @endif

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Ruangan *</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                            id="nama" name="nama" value="{{ old('nama', $ruangan->nama ?? '') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kapasitas -->
                    <div class="mb-3">
                        <label for="kapasitas" class="form-label fw-semibold">Kapasitas (orang) *</label>
                        <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" 
                            id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $ruangan->kapasitas ?? '') }}" 
                            min="5" max="500" required>
                        @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $ruangan->keterangan ?? '') }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status_id" class="form-label fw-semibold">Status *</label>
                        <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach ($status as $s)
                                <option value="{{ $s->id }}" {{ old('status_id', $ruangan->status_id ?? 1) == $s->id ? 'selected' : '' }}>
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
                            <i class="bi bi-check-circle"></i> {{ isset($ruangan) ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

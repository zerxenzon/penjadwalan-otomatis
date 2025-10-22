@extends('layouts.app')

@section('title', isset($dosen) ? 'Edit Dosen' : 'Tambah Dosen')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">{{ isset($dosen) ? 'Edit Dosen' : 'Tambah Dosen Baru' }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($dosen) ? route('dosen.update', $dosen->id) : route('dosen.store') }}" 
                  method="POST" class="needs-validation" novalidate>
                @csrf
                @if(isset($dosen))
                    @method('PUT')
                @endif

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap *</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" required
                           value="{{ old('nama', $dosen->nama ?? '') }}">
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username *</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                           id="username" name="username" required
                           value="{{ old('username', $dosen->username ?? '') }}">
                    @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" required
                           value="{{ old('email', $dosen->email ?? '') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        {{ isset($dosen) ? 'Password (kosongkan jika tidak ingin mengubah)' : 'Password *' }}
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" 
                           {{ isset($dosen) ? '' : 'required' }}>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NIP -->
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP *</label>
                    <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                           id="nip" name="nip" required
                           value="{{ old('nip', $dosen->biodata->nip ?? '') }}">
                    @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              id="alamat" name="alamat" rows="3">{{ old('alamat', $dosen->biodata->alamat ?? '') }}</textarea>
                    @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- No. Telepon -->
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                           id="no_telp" name="no_telp"
                           value="{{ old('no_telp', $dosen->biodata->no_telp ?? '') }}">
                    @error('no_telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status_id" class="form-label">Status *</label>
                    <select class="form-select @error('status_id') is-invalid @enderror" 
                            id="status_id" name="status_id" required>
                        <option value="">Pilih Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" 
                                {{ old('status_id', $dosen->status_id ?? '') == $status->id ? 'selected' : '' }}>
                                {{ $status->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($dosen) ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
@endpush
@endsection
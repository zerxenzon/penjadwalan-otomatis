@extends('layouts.dashboard')

@section('title', 'Tambah Surat Tugas Mengajar')

@section('dashboard-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Surat Tugas Mengajar</h1>
    <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('surat-tugas.simpan') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Pilih Dosen</label>
                <select name="dosen_id" class="form-select @error('dosen_id') is-invalid @enderror">
                    <option value="">Pilih Dosen</option>
                    @foreach($dosen as $d)
                    <option value="{{ $d->id }}" @selected(old('dosen_id') == $d->id)>
                        {{ $d->nama }}
                    </option>
                    @endforeach
                </select>
                @error('dosen_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Mata Kuliah</label>
                <select name="mata_kuliah_id" class="form-select @error('mata_kuliah_id') is-invalid @enderror">
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach($mataKuliah as $mk)
                    <option value="{{ $mk->id }}" @selected(old('mata_kuliah_id') == $mk->id)>
                        {{ $mk->nama }}
                    </option>
                    @endforeach
                </select>
                @error('mata_kuliah_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Kelas</label>
                <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}" @selected(old('kelas_id') == $k->id)>
                        {{ $k->nama }}
                    </option>
                    @endforeach
                </select>
                @error('kelas_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Semester</label>
                <select name="semester_id" class="form-select @error('semester_id') is-invalid @enderror">
                    <option value="">Pilih Semester</option>
                    @foreach($semester as $s)
                    <option value="{{ $s->id }}" @selected(old('semester_id') == $s->id)>
                        {{ $s->kode_semester }}
                    </option>
                    @endforeach
                </select>
                @error('semester_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan') }}</textarea>
                @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="status_id" value="3">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.dashboard')

@section('title', 'Surat Tugas Mengajar')

@section('dashboard-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Surat Tugas Mengajar</h1>
    <a href="{{ route('surat-tugas.tambah') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Buat Surat Tugas
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Dosen</th>
                        <th>Mata Kuliah</th>
                        <th>Kelas</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratTugas as $index => $st)
                    <tr>
                        <td>{{ $suratTugas->firstItem() + $index }}</td>
                        <td>{{ $st->nomor_surat }}</td>
                        <td>{{ $st->dosen->biodata->nama }}</td>
                        <td>{{ $st->mataKuliah->nama }}</td>
                        <td>{{ $st->kelas->nama }}</td>
                        <td>{{ $st->semester->kode_semester }}</td>
                        <td>
                            <span class="badge bg-{{ $st->status_id == 3 ? 'warning' : 
                                ($st->status_id == 4 ? 'success' : 
                                ($st->status_id == 5 ? 'danger' : 'secondary')) }}">
                                {{ $st->status->nama }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('surat-tugas.pdf', $st->id) }}" 
                                   class="btn btn-sm btn-secondary" 
                                   target="_blank">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                                @if($st->status_id == 3)
                                <form action="{{ route('surat-tugas.update-status', $st->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status_id" value="4">
                                    <button type="submit" 
                                            class="btn btn-sm btn-success" 
                                            onclick="return confirm('Setujui surat tugas ini?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form action="{{ route('surat-tugas.update-status', $st->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status_id" value="5">
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Tolak surat tugas ini?')">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada surat tugas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
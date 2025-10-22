@extends('layouts.app')

@section('title', 'Detail Dosen')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0">Detail Dosen</h5>
                <div>
                    @if(auth()->user()->role->nama == 'kaprodi' || auth()->user()->role->nama == 'dekan')
                    <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    @endif
                    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2">Informasi Pribadi</h6>
                    <table class="table table-sm">
                        <tr>
                            <td width="150">Nama Lengkap</td>
                            <td>: {{ $dosen->nama }}</td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td>: {{ $dosen->biodata->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $dosen->biodata->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>No. Telepon</td>
                            <td>: {{ $dosen->biodata->no_telp ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2">Informasi Akun</h6>
                    <table class="table table-sm">
                        <tr>
                            <td width="150">Username</td>
                            <td>: {{ $dosen->username }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{ $dosen->email }}</td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>: {{ $dosen->role->nama }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: 
                                <span class="badge {{ $dosen->status->nama == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $dosen->status->nama }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Surat Tugas -->
            <div class="mt-4">
                <h6 class="border-bottom pb-2">Surat Tugas Mengajar</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosen->suratTugasMengajar as $index => $st)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $st->mataKuliah->nama }}</td>
                                <td>{{ $st->kelas->nama }}</td>
                                <td>{{ $st->semester->nama }}</td>
                                <td>
                                    <span class="badge 
                                        @if($st->status->nama == 'disetujui')
                                            bg-success
                                        @elseif($st->status->nama == 'ditolak')
                                            bg-danger
                                        @else
                                            bg-warning
                                        @endif">
                                        {{ $st->status->nama }}
                                    </span>
                                </td>
                                <td>{{ $st->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada surat tugas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.dashboard')

@section('title', 'Daftar Dosen')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Daftar Dosen</h1>
    <div>
        <a href="{{ route('dosen.export_pdf') }}" class="btn btn-danger me-2">
            <i class="bi bi-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="cari" class="form-control" 
                    placeholder="Cari nama atau NIP dosen..." value="{{ request('cari') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            <div class="col-md-4">
                <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Dosen</th>
                    <th>NIP</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosen as $d)
                    <tr>
                        <td>{{ ($dosen->currentPage() - 1) * 10 + $loop->iteration }}</td>
                        <td><strong>{{ $d->nama }}</strong></td>
                        <td>{{ $d->biodata?->nip ?? '-' }}</td>
                        <td>{{ $d->email }}</td>
                        <td>{{ $d->biodata?->nomor_telepon ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $d->status->nama == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($d->status->nama) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('dosen.lihat', $d->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada data dosen.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-light">
        {{ $dosen->links() }}
    </div>
</div>
@endsection
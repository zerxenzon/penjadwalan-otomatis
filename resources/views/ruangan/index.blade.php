@extends('layouts.dashboard')

@section('title', 'Daftar Ruangan')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Daftar Ruangan</h1>
    <a href="{{ route('ruangan.tambah') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Ruangan
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="cari" class="form-control" 
                    placeholder="Cari nama ruangan..." value="{{ request('cari') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            <div class="col-md-4">
                <a href="{{ route('ruangan.index') }}" class="btn btn-outline-secondary w-100">
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
                    <th>Nama Ruangan</th>
                    <th width="10%">Kapasitas</th>
                    <th>Keterangan</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ruangan as $r)
                    <tr>
                        <td>{{ ($ruangan->currentPage() - 1) * 10 + $loop->iteration }}</td>
                        <td><strong>{{ $r->nama }}</strong></td>
                        <td><span class="badge bg-info">{{ $r->kapasitas }} orang</span></td>
                        <td>{{ $r->keterangan }}</td>
                        <td>
                            <span class="badge bg-{{ $r->status->nama == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($r->status->nama) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('ruangan.ubah', $r->id) }}" class="btn btn-sm btn-warning" title="Ubah">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusRuangan({{ $r->id }})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Tidak ada data ruangan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-light">
        {{ $ruangan->links() }}
    </div>
</div>

<form id="form-hapus" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@section('scripts')
<script>
    function hapusRuangan(id) {
        if (confirm('Apakah Anda yakin ingin menghapus ruangan ini?')) {
            document.getElementById('form-hapus').action = '/ruangan/' + id + '/hapus';
            document.getElementById('form-hapus').submit();
        }
    }
</script>
@endsection
@endsection

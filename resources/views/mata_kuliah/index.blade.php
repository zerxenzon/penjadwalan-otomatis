@extends('layouts.dashboard')

@section('title', 'Daftar Mata Kuliah')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Daftar Mata Kuliah</h1>
    <a href="{{ route('mata_kuliah.tambah') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Mata Kuliah
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="cari" class="form-control" 
                    placeholder="Cari nama atau kode..." value="{{ request('cari') }}">
            </div>
            <div class="col-md-3">
                <select name="prodi_id" class="form-select">
                    <option value="">-- Semua Prodi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id }}" {{ request('prodi_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('mata_kuliah.index') }}" class="btn btn-outline-secondary w-100">
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
                    <th>
                        <a href="?sort=kode&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}">
                            Kode <i class="bi bi-arrow-down-up"></i>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=nama&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}">
                            Nama <i class="bi bi-arrow-down-up"></i>
                        </a>
                    </th>
                    <th width="10%">SKS</th>
                    <th>Prodi</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mataKuliah as $mk)
                    <tr>
                        <td>{{ ($mataKuliah->currentPage() - 1) * 10 + $loop->iteration }}</td>
                        <td><strong>{{ $mk->kode }}</strong></td>
                        <td>{{ $mk->nama }}</td>
                        <td>{{ $mk->sks }}</td>
                        <td>{{ $mk->prodi->nama }}</td>
                        <td>
                            <span class="badge bg-{{ $mk->status->nama == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($mk->status->nama) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('mata_kuliah.lihat', $mk->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('mata_kuliah.ubah', $mk->id) }}" class="btn btn-sm btn-warning" title="Ubah">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusMataKuliah({{ $mk->id }})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada data mata kuliah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer bg-light">
        {{ $mataKuliah->links() }}
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="form-hapus" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@section('scripts')
<script>
    function hapusMataKuliah(id) {
        if (confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')) {
            document.getElementById('form-hapus').action = '/mata-kuliah/' + id + '/hapus';
            document.getElementById('form-hapus').submit();
        }
    }
</script>
@endsection
@endsection

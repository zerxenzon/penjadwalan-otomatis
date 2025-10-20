@extends('layouts.dashboard')

@section('title', 'Daftar Kelas')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Daftar Kelas</h1>
    <a href="{{ route('kelas.tambah') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Kelas
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="cari" class="form-control" 
                    placeholder="Cari nama kelas..." value="{{ request('cari') }}">
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
            <div class="col-md-4">
                <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary w-100">
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
                    <th>Nama Kelas</th>
                    <th>Prodi</th>
                    <th>Angkatan</th>
                    <th>Semester</th>
                    <th>Shift</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas as $k)
                    <tr>
                        <td>{{ ($kelas->currentPage() - 1) * 10 + $loop->iteration }}</td>
                        <td><strong>{{ $k->nama }}</strong></td>
                        <td>{{ $k->prodi->nama }}</td>
                        <td>{{ $k->angkatan->tahun }}</td>
                        <td>{{ $k->semester->kode_semester }} ({{ ucfirst($k->semester->tipe) }})</td>
                        <td>{{ $k->shift->nama }}</td>
                        <td>
                            <a href="{{ route('kelas.ubah', $k->id) }}" class="btn btn-sm btn-warning" title="Ubah">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusKelas({{ $k->id }})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada data kelas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-light">
        {{ $kelas->links() }}
    </div>
</div>

<form id="form-hapus" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@section('scripts')
<script>
    function hapusKelas(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
            document.getElementById('form-hapus').action = '/kelas/' + id + '/hapus';
            document.getElementById('form-hapus').submit();
        }
    }
</script>
@endsection
@endsection

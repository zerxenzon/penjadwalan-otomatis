@extends('layouts.dashboard')

@section('title', 'Surat Tugas Mengajar')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Surat Tugas Mengajar</h1>
        <a href="{{ route('surat-tugas.tambah') }}" class="btn btn-primary">
        Tambah Surat Tugas <i class="bi bi-plus"></i>
    </a>
</div>

<!-- Filter & Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="cari" class="form-control" 
                    placeholder="Cari nama dosen atau MK..." value="{{ request('cari') }}">
            </div>
            <div class="col-md-2">
                <select name="status_id" class="form-select">
                    <option value="">-- Semua Status --</option>
                    @foreach ($status as $s)
                        <option value="{{ $s->id }}" {{ request('status_id') == $s->id ? 'selected' : '' }}>
                            {{ ucfirst($s->nama) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            <div class="col-md-5">
                <a href="{{ route('surat-tugas.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Status Summary -->
<div class="row mb-4">
    @php
        $draft = \App\Models\SuratTugasMengajar::where('status_id', 6)->count();
        $pending = \App\Models\SuratTugasMengajar::where('status_id', 3)->count();
        $approved = \App\Models\SuratTugasMengajar::where('status_id', 4)->count();
        $rejected = \App\Models\SuratTugasMengajar::where('status_id', 5)->count();
    @endphp
    
    <div class="col-md-3">
        <div class="card border-left-secondary shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">DRAFT</p>
                <h3 class="fw-bold text-secondary">{{ $draft }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">PENDING</p>
                <h3 class="fw-bold text-warning">{{ $pending }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">APPROVED</p>
                <h3 class="fw-bold text-success">{{ $approved }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-danger shadow">
            <div class="card-body">
                <p class="text-muted fw-bold mb-0">REJECTED</p>
                <h3 class="fw-bold text-danger">{{ $rejected }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th width="12%">Status</th>
                    <th width="18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratTugas as $st)
                    <tr>
                        <td>{{ ($suratTugas->currentPage() - 1) * 10 + $loop->iteration }}</td>
                        <td><strong>{{ $st->dosen->nama }}</strong></td>
                        <td>{{ $st->mataKuliah->nama }}</td>
                        <td>{{ $st->kelas->nama }}</td>
                        <td>{{ $st->semester->kode_semester }}</td>
                        <td>
                            <span class="badge bg-{{ $st->status->nama == 'draft' ? 'secondary' : ($st->status->nama == 'pending' ? 'warning' : ($st->status->nama == 'approved' ? 'success' : 'danger')) }}">
                                {{ ucfirst($st->status->nama) }}
                            </span>
                        </td>
                        <td>
                            <!-- View Detail -->
                            <a href="{{ route('surat-tugas.lihat', $st->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Edit (hanya draft) -->
                            @if ($st->status_id == 6)
                                <a href="{{ route('surat_tugas.ubah', $st->id) }}" class="btn btn-sm btn-warning" title="Ubah">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endif

                            <!-- PDF -->
                            <a href="{{ route('surat-tugas.pdf', $st->id) }}" class="btn btn-sm btn-danger" title="Export PDF">
                                <i class="bi bi-file-pdf"></i>
                            </a>

                            <!-- Approve (pending & dekan) -->
                            @if ($st->status_id == 3 && auth()->user()->role->nama == 'dekan')
                                <form method="POST" action="{{ route('surat_tugas.approve', $st->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Approve surat tugas ini?')">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Delete (hanya draft) -->
                            @if ($st->status_id == 6)
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusSuratTugas({{ $st->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada data surat tugas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-light">
        {{ $suratTugas->links() }}
    </div>
</div>

<form id="form-hapus" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@section('scripts')
<script>
    function hapusSuratTugas(id) {
        if (confirm('Apakah Anda yakin ingin menghapus surat tugas ini?')) {
            document.getElementById('form-hapus').action = '/surat-tugas/' + id + '/hapus';
            document.getElementById('form-hapus').submit();
        }
    }
</script>
@endsection
@endsection

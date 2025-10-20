@extends('layouts.dashboard')

@section('title', 'Detail Surat Tugas Mengajar')

@section('dashboard-content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Detail Surat Tugas Mengajar</h1>
            <div>
                <a href="{{ route('surat-tugas.export_pdf', $suratTugas->id) }}" class="btn btn-danger me-2">
                    <i class="bi bi-file-pdf"></i> Export PDF
                </a>
                @if ($suratTugas->status_id == 6)
                    <a href="{{ route('surat-tugas.ubah', $suratTugas->id) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                @endif
                <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="alert alert-info" role="alert">
            <strong>Status:</strong>
            <span class="badge bg-{{ $suratTugas->status->nama == 'draft' ? 'secondary' : ($suratTugas->status->nama == 'pending' ? 'warning' : ($suratTugas->status->nama == 'approved' ? 'success' : 'danger')) }}">
                {{ ucfirst($suratTugas->status->nama) }}
            </span>
        </div>

        <!-- Detail Card -->
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted fw-bold">DOSEN</h6>
                        <p class="h6">{{ $suratTugas->dosen->nama }}</p>
                        @if ($suratTugas->dosen->biodata)
                            <small class="text-muted">
                                NIP: {{ $suratTugas->dosen->biodata->nip ?? '-' }}<br>
                                Telepon: {{ $suratTugas->dosen->biodata->nomor_telepon ?? '-' }}
                            </small>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted fw-bold">MATA KULIAH</h6>
                        <p class="h6">{{ $suratTugas->mataKuliah->nama }}</p>
                        <small class="text-muted">
                            Kode: {{ $suratTugas->mataKuliah->kode }} | 
                            SKS: {{ $suratTugas->mataKuliah->sks }}
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <h6 class="text-muted fw-bold">KELAS</h6>
                        <p class="h6">{{ $suratTugas->kelas->nama }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted fw-bold">SEMESTER</h6>
                        <p class="h6">{{ $suratTugas->semester->kode_semester }}</p>
                        <small class="text-muted">{{ ucfirst($suratTugas->semester->tipe) }}</small>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted fw-bold">PROGRAM STUDI</h6>
                        <p class="h6">{{ $suratTugas->kelas->prodi->nama }}</p>
                    </div>
                </div>

                @if ($suratTugas->catatan)
                    <hr>
                    <div class="mb-3">
                        <h6 class="text-muted fw-bold">CATATAN</h6>
                        <p>{{ $suratTugas->catatan }}</p>
                    </div>
                @endif

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted fw-bold">DIBUAT PADA</h6>
                        <p>{{ $suratTugas->created_at->format('d F Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted fw-bold">TERAKHIR DIUBAH</h6>
                        <p>{{ $suratTugas->updated_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Section -->
        @if ($suratTugas->jadwal->count() > 0)
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Jadwal Mengajar</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Ruangan</th>
                                <th>Shift</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suratTugas->jadwal as $j)
                                <tr>
                                    <td><strong>{{ ucfirst($j->hari) }}</strong></td>
                                    <td>{{ $j->jam_mulai }}</td>
                                    <td>{{ $j->jam_selesai }}</td>
                                    <td>{{ $j->ruangan->nama }}</td>
                                    <td>{{ $j->shift->nama }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-warning mt-4" role="alert">
                <i class="bi bi-info-circle"></i> Belum ada jadwal yang di-charter untuk surat tugas ini.
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-4">
            @if ($suratTugas->status_id == 6 && auth()->user()->role->nama == 'kaprodi')
                <!-- Submit untuk Approval -->
                                <form method="POST" action="{{ route('surat-tugas.submit_approval', $suratTugas->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle"></i> Submit untuk Persetujuan
                    </button>
                </form>
                <form method="POST" action="{{ route('surat-tugas.approve', $suratTugas->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success ms-2">
                        <i class="bi bi-check2"></i> Setujui
                    </button>
                </form>

                <!-- Reject -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle"></i> Reject
                </button>
            @endif

            @if ($suratTugas->status_id == 4 && auth()->user()->role->nama == 'dekan')
                <!-- Publish -->
                                <form method="POST" action="{{ route('surat-tugas.publish', $suratTugas->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-info ms-2">
                        <i class="bi bi-globe"></i> Publikasikan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">Workflow Status</h6>
                <div class="small">
                    <div class="mb-2">
                        <span class="badge bg-secondary">1. Draft</span>
                        <span class="text-muted">- Editing stage</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-warning">2. Pending</span>
                        <span class="text-muted">- Waiting approval</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-success">3. Approved</span>
                        <span class="text-muted">- Ready to publish</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-info">4. Published</span>
                        <span class="text-muted">- Dosen notified</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">Informasi Penting</h6>
                <p class="text-sm text-muted mb-0">
                    <i class="bi bi-info-circle"></i>
                    Setelah surat tugas di-publish, dosen akan menerima notifikasi dan dapat melakukan charter jadwal.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('surat-tugas.reject', $suratTugas->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Surat Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="alasan_reject" class="form-label">Alasan Penolakan *</label>
                        <textarea class="form-control" id="alasan_reject" name="alasan_reject" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

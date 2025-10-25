@extends('layouts.dashboard')

@section('title', 'Permintaan Pindah Jadwal')

@section('dashboard-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Permintaan Pindah Jadwal</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Filter Status -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="status_filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="3" {{ request('status_filter') == 3 ? 'selected' : '' }}>Pending</option>
                    <option value="4" {{ request('status_filter') == 4 ? 'selected' : '' }}>Disetujui</option>
                    <option value="5" {{ request('status_filter') == 5 ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('pindah-jadwal.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Dosen</th>
                        <th>Jadwal Lama</th>
                        <th>Jadwal Baru (Usulan)</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pindahJadwalList as $index => $pindah)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pindah->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            {{ $pindah->dosen->nama }}<br>
                            <small class="text-muted">{{ $pindah->dosen->biodata->nip ?? '-' }}</small>
                        </td>
                        <td>
                            @if($pindah->jadwalLama)
                                <strong>{{ $pindah->jadwalLama->suratTugasMengajar->mataKuliah->nama }}</strong><br>
                                <small class="text-muted">
                                    {{ $pindah->jadwalLama->suratTugasMengajar->kelas->nama }}<br>
                                    {{ ucfirst($pindah->jadwalLama->hari) }}, 
                                    {{ \Carbon\Carbon::parse($pindah->jadwalLama->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($pindah->jadwalLama->jam_selesai)->format('H:i') }}<br>
                                    {{ $pindah->jadwalLama->ruangan->nama ?? '-' }}
                                </small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($pindah->jadwalBaru)
                                @if($pindah->jadwalBaru->suratTugasMengajar)
                                    <strong>{{ $pindah->jadwalBaru->suratTugasMengajar->mataKuliah->nama }}</strong><br>
                                    <small class="text-muted">
                                        {{ $pindah->jadwalBaru->suratTugasMengajar->kelas->nama }}<br>
                                        {{ ucfirst($pindah->jadwalBaru->hari) }}, 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_selesai)->format('H:i') }}<br>
                                        {{ $pindah->jadwalBaru->ruangan->nama ?? '-' }}
                                    </small>
                                @else
                                    <strong>Slot Kosong</strong><br>
                                    <small class="text-muted">
                                        {{ ucfirst($pindah->jadwalBaru->hari) }}, 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($pindah->jadwalBaru->jam_selesai)->format('H:i') }}<br>
                                        {{ $pindah->jadwalBaru->ruangan->nama ?? '-' }}
                                    </small>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $pindah->alasan }}</small>
                        </td>
                        <td>
                            @if($pindah->status->nama == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($pindah->status->nama == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($pindah->status->nama == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($pindah->status->nama) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($pindah->status->nama == 'pending')
                                <div class="btn-group" role="group">
                                    <form action="{{ route('pindah-jadwal.update-status', $pindah->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menyetujui permintaan ini?')">
                                        @csrf
                                        <input type="hidden" name="status_id" value="4">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Setuju
                                        </button>
                                    </form>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm ms-1 btn-reject-request" 
                                            data-reject-id="{{ $pindah->id }}">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </div>

                                <!-- Modal Reject -->
                                <div class="modal fade" id="rejectModal{{ $pindah->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $pindah->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('pindah-jadwal.update-status', $pindah->id) }}" method="POST" id="rejectForm{{ $pindah->id }}">
                                                @csrf
                                                <input type="hidden" name="status_id" value="5">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="rejectModalLabel{{ $pindah->id }}">
                                                        <i class="bi bi-x-circle"></i> Tolak Permintaan
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-warning mb-3">
                                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                                        <strong>Perhatian!</strong><br>
                                                        Anda akan menolak permintaan pindah jadwal dari <strong>{{ $pindah->dosen->nama }}</strong>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alasan_reject{{ $pindah->id }}" class="form-label">
                                                            Alasan Penolakan <span class="text-danger">*</span>
                                                        </label>
                                                        <textarea name="alasan_reject" 
                                                                  id="alasan_reject{{ $pindah->id }}"
                                                                  class="form-control" 
                                                                  rows="4" 
                                                                  required 
                                                                  placeholder="Jelaskan alasan penolakan secara detail..."></textarea>
                                                        <div class="form-text">
                                                            <i class="bi bi-info-circle"></i> 
                                                            Alasan ini akan dilihat oleh dosen yang mengajukan.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="bi bi-x"></i> Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="bi bi-x-circle"></i> Ya, Tolak Permintaan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <small class="text-muted">Sudah diproses</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Tidak ada permintaan pindah jadwal</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    'use strict';
    
    let isProcessing = false;
    const initializedModals = new Set();
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        // Use event delegation on document to avoid multiple listeners
        document.addEventListener('click', function(e) {
            const rejectBtn = e.target.closest('.btn-reject-request');
            if (!rejectBtn) return;
            
            handleRejectClick(e, rejectBtn);
        }, true);
        
        // Pre-initialize all modals to prevent re-render
        initializeAllModals();
    }
    
    function initializeAllModals() {
        const allModals = document.querySelectorAll('[id^="rejectModal"]');
        
        allModals.forEach(function(modalEl) {
            if (initializedModals.has(modalEl.id)) return;
            
            // Mark as initialized
            initializedModals.add(modalEl.id);
            
            // Setup form validation
            setupFormValidation(modalEl);
            
            // Setup modal events
            setupModalEvents(modalEl);
        });
    }
    
    function handleRejectClick(e, button) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        
        if (isProcessing) return false;
        
        isProcessing = true;
        
        const rejectId = button.getAttribute('data-reject-id');
        const modalId = 'rejectModal' + rejectId;
        const modalEl = document.getElementById(modalId);
        
        if (!modalEl) {
            isProcessing = false;
            return false;
        }
        
        // Reset form
        resetModalForm(modalEl);
        
        // Get or create modal instance
        let modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (!modalInstance) {
            modalInstance = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: true,
                focus: false
            });
        }
        
        // Force show modal
        try {
            modalInstance.show();
        } catch (error) {
            console.error('Error showing modal:', error);
        }
        
        setTimeout(() => {
            isProcessing = false;
        }, 300);
        
        return false;
    }
    
    function resetModalForm(modalEl) {
        const form = modalEl.querySelector('form');
        if (!form) return;
        
        form.reset();
        
        const textarea = form.querySelector('textarea[name="alasan_reject"]');
        if (textarea) {
            textarea.value = '';
            textarea.classList.remove('is-invalid');
        }
        
        const errorDiv = form.querySelector('.textarea-error');
        if (errorDiv) {
            errorDiv.remove();
        }
        
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-x-circle"></i> Ya, Tolak Permintaan';
        }
    }
    
    function setupFormValidation(modalEl) {
        const form = modalEl.querySelector('form');
        if (!form) return;
        
        // Prevent multiple event listeners
        const newForm = form.cloneNode(true);
        form.parentNode.replaceChild(newForm, form);
        
        newForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const textarea = this.querySelector('textarea[name="alasan_reject"]');
            const submitBtn = this.querySelector('button[type="submit"]');
            
            if (!textarea || !textarea.value.trim()) {
                if (textarea) {
                    textarea.classList.add('is-invalid');
                    
                    let errorDiv = this.querySelector('.textarea-error');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'text-danger small mt-1 textarea-error';
                        errorDiv.style.marginTop = '0.25rem';
                        textarea.parentNode.appendChild(errorDiv);
                    }
                    errorDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> Alasan penolakan wajib diisi!';
                    
                    setTimeout(() => textarea.focus(), 50);
                }
                return false;
            }
            
            if (!confirm('Yakin ingin menolak permintaan ini?')) {
                return false;
            }
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
            }
            
            this.submit();
            return true;
        });
        
        // Input handler
        const textarea = newForm.querySelector('textarea[name="alasan_reject"]');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const error = this.closest('.mb-3').querySelector('.textarea-error');
                if (error) error.remove();
            });
        }
    }
    
    function setupModalEvents(modalEl) {
        // Focus textarea when modal is shown
        modalEl.addEventListener('shown.bs.modal', function(e) {
            const textarea = this.querySelector('textarea[name="alasan_reject"]');
            if (textarea) {
                setTimeout(() => {
                    textarea.focus();
                    textarea.setSelectionRange(0, 0);
                }, 150);
            }
        });
        
        // Clean up when modal is hidden
        modalEl.addEventListener('hidden.bs.modal', function(e) {
            resetModalForm(this);
        });
    }
})();
</script>

<style>
/* Prevent any hover effects that might trigger modal */
.btn-reject-request {
    pointer-events: auto !important;
    cursor: pointer !important;
}

.btn-reject-request:hover {
    opacity: 0.9;
}

/* CRITICAL: Lock modal structure to prevent collapse */
.modal {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    z-index: 1055 !important;
    display: none;
    width: 100% !important;
    height: 100% !important;
    overflow-x: hidden !important;
    overflow-y: auto !important;
    outline: 0;
}

.modal.show {
    display: block !important;
}

.modal-backdrop {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    z-index: 1050 !important;
    width: 100vw !important;
    height: 100vh !important;
}

/* Lock modal dialog position */
.modal-dialog {
    position: relative !important;
    width: auto !important;
    margin: 1.75rem auto !important;
    pointer-events: none !important;
}

.modal-dialog-centered {
    display: flex !important;
    align-items: center !important;
    min-height: calc(100% - 3.5rem) !important;
}

/* CRITICAL: Prevent modal-content from collapsing */
.modal-content {
    position: relative !important;
    display: flex !important;
    flex-direction: column !important;
    width: 100% !important;
    pointer-events: auto !important;
    background-color: #fff !important;
    background-clip: padding-box !important;
    border: 1px solid rgba(0,0,0,.2) !important;
    border-radius: 0.3rem !important;
    outline: 0 !important;
}

/* CRITICAL: Lock modal-body to prevent collapse */
.modal-body {
    position: relative !important;
    flex: 1 1 auto !important;
    padding: 1rem !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    min-height: 100px !important;
}

.modal-header {
    display: flex !important;
    flex-shrink: 0 !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 1rem !important;
    border-bottom: 1px solid #dee2e6 !important;
}

.modal-footer {
    display: flex !important;
    flex-wrap: wrap !important;
    flex-shrink: 0 !important;
    align-items: center !important;
    justify-content: flex-end !important;
    padding: 0.75rem !important;
    border-top: 1px solid #dee2e6 !important;
}

/* Lock textarea size */
.modal-body textarea {
    resize: none !important;
    overflow-y: auto !important;
    min-height: 100px !important;
    max-height: 200px !important;
    width: 100% !important;
    display: block !important;
}

/* Remove transform animations that cause jump */
.modal.fade .modal-dialog {
    transition: opacity 0.15s linear !important;
    transform: none !important;
}

.modal.show .modal-dialog {
    transform: none !important;
}

/* Prevent body shift */
body.modal-open {
    overflow: hidden !important;
    padding-right: 0 !important;
}

/* Validation styles */
textarea.is-invalid {
    border-color: #dc3545 !important;
    background-image: none !important;
}

.textarea-error {
    display: block !important;
    margin-top: 0.25rem !important;
    font-size: 0.875em !important;
    color: #dc3545 !important;
}

/* Ensure alert in modal-body is visible */
.modal-body .alert {
    display: block !important;
    margin-bottom: 1rem !important;
}

.modal-body .mb-3 {
    display: block !important;
    margin-bottom: 1rem !important;
}

.modal-body .form-label {
    display: inline-block !important;
    margin-bottom: 0.5rem !important;
}

.modal-body .form-text {
    display: block !important;
    margin-top: 0.25rem !important;
    font-size: 0.875em !important;
}
</style>
@endpush

@endsection
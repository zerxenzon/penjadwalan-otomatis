@extends('layouts.dashboard')

@section('title', 'Tambah Surat Tugas Mengajar')

@push('styles')
<style>
    .mk-item {
        transition: all 0.3s ease;
        border-left: 4px solid var(--fire-primary, #ff6600);
    }
    
    .mk-item:hover {
        box-shadow: 0 6px 25px rgba(255, 100, 0, 0.35);
        transform: translateY(-2px);
    }
    
    .mk-item .card-body {
        background: linear-gradient(135deg, rgba(30, 15, 10, 0.88) 0%, rgba(20, 10, 5, 0.92) 100%);
    }
    
    .hapus-mk {
        transition: all 0.2s ease;
    }
    
    .hapus-mk:hover {
        transform: scale(1.05);
    }
    
    #grandTotalSKS {
        font-size: 2rem;
        font-weight: 700;
        color: #ff6600;
        text-shadow: 0 0 20px rgba(255, 100, 0, 0.4);
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-secondary, #ffaa66);
    }
    
    .form-label .text-danger {
        color: #ff3333 !important;
    }
    
    .border-bottom {
        border-color: rgba(255, 100, 0, 0.3) !important;
    }
    
    .card.bg-light {
        background: linear-gradient(135deg, rgba(255, 100, 0, 0.15) 0%, rgba(255, 69, 0, 0.1) 100%) !important;
        border: 2px solid rgba(255, 100, 0, 0.4) !important;
    }
</style>
@endpush

@section('dashboard-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Surat Tugas Mengajar</h1>
    <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="bi bi-exclamation-triangle-fill"></i> Terjadi kesalahan:</strong>
    <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('surat-tugas.simpan') }}" method="POST" id="formSuratTugas">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Pilih Dosen <span class="text-danger">*</span></label>
                <select name="dosen_id" id="dosen_id" class="form-select @error('dosen_id') is-invalid @enderror" required>
                    <option value="">Pilih Dosen</option>
                    @foreach($dosen as $d)
                    <option value="{{ $d->id }}" @selected(old('dosen_id') == $d->id)>
                        {{ $d->nama }} - {{ $d->biodata->nidn ?? 'NIDN: -' }}
                    </option>
                    @endforeach
                </select>
                @error('dosen_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Semester <span class="text-danger">*</span></label>
                <select name="semester_id" id="semester_id" class="form-select @error('semester_id') is-invalid @enderror" required>
                    <option value="">Pilih Semester</option>
                    @foreach($semester as $s)
                    <option value="{{ $s->id }}" @selected(old('semester_id') == $s->id)>
                        {{ $s->kode_semester }} - {{ $s->tipe }}
                    </option>
                    @endforeach
                </select>
                @error('semester_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4">

            <!-- Section Mata Kuliah (Multiple) -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar Mata Kuliah <span class="text-danger">*</span></h5>
                <button type="button" class="btn btn-success btn-sm" id="tambahMK">
                    <i class="bi bi-plus-circle"></i> Tambah Mata Kuliah
                </button>
            </div>

            <div id="container-mk">
                <!-- Item MK pertama -->
                <div class="card mb-3 mk-item" data-index="0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 text-primary">Mata Kuliah #1</h6>
                            <button type="button" class="btn btn-danger btn-sm hapus-mk" style="display: none;">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mata Kuliah</label>
                                <select name="mata_kuliah[0][mata_kuliah_id]" class="form-select mk-select" required>
                                    <option value="">Pilih Mata Kuliah</option>
                                    @foreach($mataKuliah as $mk)
                                    <option value="{{ $mk->id }}" data-sks="{{ $mk->sks }}" data-prodi="{{ $mk->prodi->kode ?? '' }}">
                                        {{ $mk->nama }} ({{ $mk->sks }} SKS)
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="mata_kuliah[0][kelas_id]" class="form-select kelas-select" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">SKS</label>
                                <input type="number" name="mata_kuliah[0][sks]" class="form-control sks-input" readonly value="0" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Kelas</label>
                                <input type="number" name="mata_kuliah[0][jumlah_kelas]" class="form-control jml-kelas-input" min="1" value="1" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Total SKS</label>
                                <input type="number" name="mata_kuliah[0][total_sks]" class="form-control total-sks-input" readonly value="0" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total SKS Keseluruhan -->
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0">Total SKS Keseluruhan:</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <h4 class="mb-0 text-primary">
                                <span id="grandTotalSKS">0</span> SKS
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan') }}</textarea>
                @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="status_id" value="3">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="bi bi-save"></i> Simpan Surat Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center;">
    <div class="text-center">
        <div class="spinner-border text-warning" role="status" style="width: 4rem; height: 4rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-3 text-white h5">Menyimpan data...</div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let mkIndex = 1;
    const containerMK = document.getElementById('container-mk');
    const btnTambahMK = document.getElementById('tambahMK');
    const grandTotalSKS = document.getElementById('grandTotalSKS');

    // Tambah Mata Kuliah Baru
    btnTambahMK.addEventListener('click', function() {
        const newItem = `
            <div class="card mb-3 mk-item" data-index="${mkIndex}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-primary">Mata Kuliah #${mkIndex + 1}</h6>
                        <button type="button" class="btn btn-danger btn-sm hapus-mk">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <select name="mata_kuliah[${mkIndex}][mata_kuliah_id]" class="form-select mk-select" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($mataKuliah as $mk)
                                <option value="{{ $mk->id }}" data-sks="{{ $mk->sks }}" data-prodi="{{ $mk->prodi->kode ?? '' }}">
                                    {{ $mk->nama }} ({{ $mk->sks }} SKS)
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="mata_kuliah[${mkIndex}][kelas_id]" class="form-select kelas-select" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">SKS</label>
                            <input type="number" name="mata_kuliah[${mkIndex}][sks]" class="form-control sks-input" readonly value="0" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah Kelas</label>
                            <input type="number" name="mata_kuliah[${mkIndex}][jumlah_kelas]" class="form-control jml-kelas-input" min="1" value="1" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total SKS</label>
                            <input type="number" name="mata_kuliah[${mkIndex}][total_sks]" class="form-control total-sks-input" readonly value="0" required>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        containerMK.insertAdjacentHTML('beforeend', newItem);
        mkIndex++;
        updateHapusButtons();
        attachEventListeners();
    });

    // Update tombol hapus (hide jika hanya 1 item)
    function updateHapusButtons() {
        const items = document.querySelectorAll('.mk-item');
        const hapusButtons = document.querySelectorAll('.hapus-mk');
        
        hapusButtons.forEach(btn => {
            btn.style.display = items.length > 1 ? 'inline-block' : 'none';
        });
    }

    // Hapus item MK
    containerMK.addEventListener('click', function(e) {
        if (e.target.classList.contains('hapus-mk') || e.target.closest('.hapus-mk')) {
            const item = e.target.closest('.mk-item');
            item.remove();
            updateHapusButtons();
            updateNomorMK();
            hitungGrandTotal();
        }
    });

    // Update nomor urut MK
    function updateNomorMK() {
        const items = document.querySelectorAll('.mk-item');
        items.forEach((item, index) => {
            item.querySelector('h6').textContent = `Mata Kuliah #${index + 1}`;
        });
    }

    // Hitung Total SKS per Item
    function hitungTotalSKS(mkItem) {
        const sksInput = mkItem.querySelector('.sks-input');
        const jmlKelasInput = mkItem.querySelector('.jml-kelas-input');
        const totalSksInput = mkItem.querySelector('.total-sks-input');
        
        const sks = parseInt(sksInput.value) || 0;
        const jmlKelas = parseInt(jmlKelasInput.value) || 1;
        const total = sks * jmlKelas;
        
        totalSksInput.value = total;
        hitungGrandTotal();
    }

    // Hitung Grand Total SKS
    function hitungGrandTotal() {
        let total = 0;
        document.querySelectorAll('.total-sks-input').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        grandTotalSKS.textContent = total;
    }

    // Attach Event Listeners ke semua item
    function attachEventListeners() {
        // Event ketika pilih mata kuliah
        document.querySelectorAll('.mk-select').forEach(select => {
            select.removeEventListener('change', handleMKChange);
            select.addEventListener('change', handleMKChange);
        });

        // Event ketika ubah jumlah kelas
        document.querySelectorAll('.jml-kelas-input').forEach(input => {
            input.removeEventListener('input', handleJmlKelasChange);
            input.addEventListener('input', handleJmlKelasChange);
        });
    }

    function handleMKChange(e) {
        const mkItem = e.target.closest('.mk-item');
        const selectedOption = e.target.options[e.target.selectedIndex];
        const sks = selectedOption.getAttribute('data-sks') || 0;
        
        const sksInput = mkItem.querySelector('.sks-input');
        sksInput.value = sks;
        
        // Hitung total SKS langsung
        hitungTotalSKS(mkItem);
    }

    function handleJmlKelasChange(e) {
        const mkItem = e.target.closest('.mk-item');
        hitungTotalSKS(mkItem);
    }

    // Initialize event listeners
    attachEventListeners();
    updateHapusButtons();

    // Initialize SKS untuk item pertama jika sudah ada nilai old()
    const firstMKSelect = document.querySelector('.mk-select');
    if (firstMKSelect && firstMKSelect.value) {
        handleMKChange({target: firstMKSelect});
    }

    // Form validation
    document.getElementById('formSuratTugas').addEventListener('submit', function(e) {
        const mkItems = document.querySelectorAll('.mk-item');
        const dosenSelect = document.getElementById('dosen_id');
        const semesterSelect = document.getElementById('semester_id');
        const btnSubmit = document.getElementById('btnSubmit');
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        // Validasi dosen dan semester
        if (!dosenSelect.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih dosen terlebih dahulu!',
                confirmButtonColor: '#ff6600'
            });
            return false;
        }

        if (!semesterSelect.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih semester terlebih dahulu!',
                confirmButtonColor: '#ff6600'
            });
            return false;
        }

        // Validasi minimal 1 mata kuliah
        if (mkItems.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Minimal harus ada 1 mata kuliah!',
                confirmButtonColor: '#ff6600'
            });
            return false;
        }

        // Validasi semua field mata kuliah terisi
        let valid = true;
        let errorMsg = '';
        
        mkItems.forEach((item, index) => {
            const mkSelect = item.querySelector('.mk-select');
            const kelasSelect = item.querySelector('.kelas-select');
            const jmlKelasInput = item.querySelector('.jml-kelas-input');
            
            if (!mkSelect.value) {
                valid = false;
                errorMsg = `Mata kuliah #${index + 1} belum dipilih!`;
            } else if (!kelasSelect.value) {
                valid = false;
                errorMsg = `Kelas untuk mata kuliah #${index + 1} belum dipilih!`;
            } else if (!jmlKelasInput.value || jmlKelasInput.value < 1) {
                valid = false;
                errorMsg = `Jumlah kelas untuk mata kuliah #${index + 1} tidak valid!`;
            }
        });

        if (!valid) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap',
                text: errorMsg,
                confirmButtonColor: '#ff6600'
            });
            return false;
        }

        // Cek duplikasi mata kuliah dan kelas
        const combinations = [];
        let hasDuplicate = false;
        let duplicateMsg = '';

        mkItems.forEach((item, index) => {
            const mkSelect = item.querySelector('.mk-select');
            const kelasSelect = item.querySelector('.kelas-select');
            const combination = `${mkSelect.value}-${kelasSelect.value}`;
            
            if (combinations.includes(combination)) {
                hasDuplicate = true;
                const mkName = mkSelect.options[mkSelect.selectedIndex].text;
                const kelasName = kelasSelect.options[kelasSelect.selectedIndex].text;
                duplicateMsg = `Duplikat ditemukan: ${mkName} - ${kelasName}`;
            } else {
                combinations.push(combination);
            }
        });

        if (hasDuplicate) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Data Duplikat',
                text: duplicateMsg,
                confirmButtonColor: '#ff6600'
            });
            return false;
        }

        // Konfirmasi submit
        e.preventDefault();
        
        const grandTotal = document.getElementById('grandTotalSKS').textContent;
        
        Swal.fire({
            title: 'Konfirmasi Penyimpanan',
            html: `
                <div class="text-start">
                    <p><strong>Jumlah Mata Kuliah:</strong> ${mkItems.length}</p>
                    <p><strong>Total SKS:</strong> ${grandTotal} SKS</p>
                    <p class="text-muted mt-3">Data yang tersimpan tidak dapat diubah. Pastikan semua data sudah benar.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ff6600',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-circle"></i> Ya, Simpan',
            cancelButtonText: '<i class="bi bi-x-circle"></i> Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable button dan tampilkan loading
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                loadingOverlay.style.display = 'flex';
                
                // Submit form
                e.target.submit();
            }
        });
        
        return false;
    });
});
</script>
@endpush

@endsection
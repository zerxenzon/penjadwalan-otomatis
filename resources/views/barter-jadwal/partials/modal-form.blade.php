<!-- Modal Barter Jadwal -->
<div class="modal fade" id="modalBarterJadwal" tabindex="-1" aria-labelledby="modalBarterJadwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBarterJadwalLabel">Ajukan Barter Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barter-jadwal.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Jadwal Yang Akan Ditukar -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Jadwal Anda</label>
                        <select name="jadwal_id" class="form-select" required>
                            <option value="">Pilih Jadwal</option>
                            @foreach($jadwalSaya as $jadwal)
                            <option value="{{ $jadwal->id }}">
                                {{ $jadwal->suratTugasMengajar->mataKuliah->nama }} - 
                                {{ $jadwal->suratTugasMengajar->kelas->nama }} 
                                ({{ $jadwal->hari }}, {{ $jadwal->shift->jam_mulai }}-{{ $jadwal->shift->jam_selesai }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dosen Tujuan -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Dosen Tujuan</label>
                        <select name="dosen_tujuan_id" id="dosen_tujuan_id" class="form-select" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosenList as $dosen)
                            <option value="{{ $dosen->id }}">
                                {{ $dosen->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jadwal Yang Diminta -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Jadwal Yang Diminta</label>
                        <select name="jadwal_tujuan_id" id="jadwal_tujuan_id" class="form-select" required disabled>
                            <option value="">Pilih dosen terlebih dahulu</option>
                        </select>
                    </div>

                    <!-- Alasan -->
                    <div class="mb-3">
                        <label class="form-label">Alasan Barter Jadwal</label>
                        <textarea name="alasan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan Barter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dosenSelect = document.getElementById('dosen_tujuan_id');
    const jadwalSelect = document.getElementById('jadwal_tujuan_id');

    dosenSelect.addEventListener('change', function() {
        const dosenId = this.value;
        if (!dosenId) {
            jadwalSelect.innerHTML = '<option value="">Pilih dosen terlebih dahulu</option>';
            jadwalSelect.disabled = true;
            return;
        }

        jadwalSelect.disabled = true;
        jadwalSelect.innerHTML = '<option value="">Memuat jadwal...</option>';

        fetch(`/barter-jadwal/get-jadwal/${dosenId}`)
            .then(response => response.json())
            .then(jadwalList => {
                let options = '<option value="">Pilih Jadwal</option>';
                jadwalList.forEach(jadwal => {
                    options += `<option value="${jadwal.id}">
                        ${jadwal.surat_tugas_mengajar.mata_kuliah.nama} - 
                        ${jadwal.surat_tugas_mengajar.kelas.nama}
                        (${jadwal.hari}, ${jadwal.shift.jam_mulai}-${jadwal.shift.jam_selesai})
                    </option>`;
                });
                jadwalSelect.innerHTML = options;
                jadwalSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                jadwalSelect.innerHTML = '<option value="">Error memuat jadwal</option>';
            });
    });
});
</script>
@endpush
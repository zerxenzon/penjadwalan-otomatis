# Menu Sidebar Dashboard - Feature Enhancement

## Tanggal Update
**23 Januari 2025**

## Perubahan yang Dilakukan

### 1. Menu KOSMA (Ketua Organisasi Mahasiswa)
Ditambahkan 2 menu items di sidebar untuk role KOSMA:

#### ✅ Permintaan Pindah Jadwal
- **Route**: `pindah-jadwal.index`
- **Icon**: `bi-clock-history`
- **Fungsi**: KOSMA dapat melihat, mereview, approve/reject permintaan pindah jadwal dari Dosen
- **Active State**: Aktif saat route `pindah-jadwal.*`

#### ✅ Jadwal Kelas
- **Route**: `kosma.jadwal-kelas`
- **Icon**: `bi-calendar3`
- **Fungsi**: KOSMA dapat melihat jadwal lengkap kelas mereka (berdasarkan kelas_id di biodata)
- **Active State**: Aktif saat route `kosma.jadwal-kelas`

### 2. Menu MAHASISWA
Ditambahkan 2 menu items di sidebar untuk role Mahasiswa:

#### ✅ Jadwal Kuliah
- **Route**: `dashboard.mahasiswa`
- **Icon**: `bi-calendar-week`
- **Fungsi**: Mahasiswa dapat melihat jadwal kuliah mereka (view tabel/kalender)
- **Active State**: Aktif saat route `dashboard.mahasiswa`

#### ✅ Export PDF
- **Route**: `mahasiswa.jadwal.pdf`
- **Icon**: `bi-file-earmark-pdf`
- **Fungsi**: Mahasiswa dapat export jadwal mereka ke PDF
- **Target**: `_blank` (buka di tab baru)

### 3. Menu DOSEN
Ditambahkan 1 menu item baru di sidebar untuk role Dosen/Kaprodi/Dekan:

#### ✅ Pindah Jadwal
- **Route**: `pindah-jadwal.dosen-index`
- **Icon**: `bi-clock-history`
- **Fungsi**: Dosen dapat membuat permintaan pindah jadwal dan melihat riwayat permintaan
- **Active State**: Aktif saat route `pindah-jadwal.dosen-index` atau `pindah-jadwal.create`

**Menu yang sudah ada:**
- Charter Jadwal
- Barter Jadwal
- Jadwal Mengajar (kondisi active diperbaiki agar tidak bentrok dengan Pindah Jadwal)

## Struktur Menu Lengkap per Role

### 📋 DEKAN
**Dashboard**
- Dashboard

**Menu Dekan:**
- Surat Tugas

**Menu Kaprodi:**
- Mata Kuliah
- Kelas

**Menu Dosen:**
- Charter Jadwal
- Barter Jadwal
- Pindah Jadwal ✨ (BARU)
- Jadwal Mengajar

### 📋 KAPRODI
**Dashboard**
- Dashboard

**Menu Kaprodi:**
- Mata Kuliah
- Kelas

**Menu Dosen:**
- Charter Jadwal
- Barter Jadwal
- Pindah Jadwal ✨ (BARU)
- Jadwal Mengajar

### 📋 DOSEN
**Dashboard**
- Dashboard

**Menu Dosen:**
- Charter Jadwal
- Barter Jadwal
- Pindah Jadwal ✨ (BARU)
- Jadwal Mengajar

### 📋 KOSMA
**Dashboard**
- Dashboard

**Menu Kosma:** ✨ (BARU LENGKAP)
- Permintaan Pindah Jadwal
- Jadwal Kelas

### 📋 MAHASISWA
**Dashboard**
- Dashboard

**Menu Mahasiswa:** ✨ (BARU LENGKAP)
- Jadwal Kuliah
- Export PDF

### 📋 SEKPRODI
**Dashboard**
- Dashboard

**Menu Sekprodi:**
- (Belum ada menu khusus)

## File yang Dimodifikasi
```
resources/views/layouts/dashboard.blade.php
```

### Perubahan Detail:

#### 1. Menu KOSMA (Line 149-167)
```blade
<!-- Menu Kosma -->
@if(auth()->user()->role->nama === 'kosma')
    <div class="nav-section">
        <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Kosma</h6>
        
        <li class="nav-item">
            <a href="{{ route('pindah-jadwal.index') }}" 
               class="nav-link {{ request()->routeIs('pindah-jadwal.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i>
                Permintaan Pindah Jadwal
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('kosma.jadwal-kelas') }}" 
               class="nav-link {{ request()->routeIs('kosma.jadwal-kelas') ? 'active' : '' }}">
                <i class="bi bi-calendar3 me-2"></i>
                Jadwal Kelas
            </a>
        </li>
    </div>
@endif
```

#### 2. Menu MAHASISWA (Line 169-187)
```blade
<!-- Menu Mahasiswa -->
@if(auth()->user()->role->nama === 'mahasiswa')
    <div class="nav-section">
        <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Mahasiswa</h6>
        
        <li class="nav-item">
            <a href="{{ route('dashboard.mahasiswa') }}" 
               class="nav-link {{ request()->routeIs('dashboard.mahasiswa') ? 'active' : '' }}">
                <i class="bi bi-calendar-week me-2"></i>
                Jadwal Kuliah
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('mahasiswa.jadwal.pdf') }}" 
               class="nav-link" target="_blank">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                Export PDF
            </a>
        </li>
    </div>
@endif
```

#### 3. Menu DOSEN - Tambahan Pindah Jadwal (Line 137-143)
```blade
<li class="nav-item">
    <a href="{{ route('pindah-jadwal.dosen-index') }}" 
       class="nav-link {{ request()->routeIs('pindah-jadwal.dosen-index') || request()->routeIs('pindah-jadwal.create') ? 'active' : '' }}">
        <i class="bi bi-clock-history me-2"></i>
        Pindah Jadwal
    </a>
</li>
```

## Testing Checklist

### KOSMA
- [ ] Login sebagai KOSMA (kosma@ruuqi.ac.id / kosma123)
- [ ] Lihat sidebar "Menu Kosma" muncul
- [ ] Klik "Permintaan Pindah Jadwal" → redirect ke halaman review permintaan
- [ ] Klik "Jadwal Kelas" → tampil jadwal kelas SI-R-SM3-20251 dengan 2 jadwal

### MAHASISWA
- [ ] Login sebagai Mahasiswa (mahasiswa@ruuqi.ac.id / mahasiswa123)
- [ ] Lihat sidebar "Menu Mahasiswa" muncul
- [ ] Klik "Jadwal Kuliah" → tampil jadwal dengan view tabel/kalender
- [ ] Klik "Export PDF" → generate PDF jadwal (buka tab baru)

### DOSEN
- [ ] Login sebagai Dosen (dosen@ruuqi.ac.id / dosen123)
- [ ] Lihat sidebar "Menu Dosen" muncul
- [ ] Klik "Pindah Jadwal" → redirect ke halaman riwayat pindah jadwal dosen
- [ ] Tombol "Ajukan Pindah Jadwal" muncul
- [ ] Menu "Jadwal Mengajar" tidak active saat di halaman Pindah Jadwal

## Fitur Dependency

Menu ini tergantung pada:
1. **Routes** di `routes/web.php`:
   - `pindah-jadwal.index` (KOSMA)
   - `pindah-jadwal.dosen-index` (Dosen)
   - `pindah-jadwal.create` (Dosen)
   - `kosma.jadwal-kelas` (KOSMA)
   - `dashboard.mahasiswa` (Mahasiswa)
   - `mahasiswa.jadwal.pdf` (Mahasiswa)

2. **Controllers**:
   - `PindahJadwalController` (index, dosenIndex, create, store, updateStatus)
   - `DashboardController` (kosmaJadwalKelas)
   - `DashboardMahasiswaController` (index, exportPdf)

3. **Database**:
   - Table `biodata` dengan kolom `kelas_id` (untuk KOSMA & Mahasiswa)
   - Table `pindah_jadwal` (untuk tracking permintaan)
   - Relationship: Biodata → Kelas → SuratTugasMengajar → Jadwal

4. **Views**:
   - `resources/views/kosma/jadwal-kelas.blade.php`
   - `resources/views/pindah-jadwal/index.blade.php`
   - `resources/views/pindah-jadwal/dosen-index.blade.php`
   - `resources/views/dashboard/mahasiswa.blade.php`
   - `resources/views/mahasiswa/jadwal-pdf.blade.php`

## Benefits
✅ **Navigasi lebih mudah** - Semua fitur accessible dari sidebar
✅ **Konsistensi UX** - Semua role memiliki menu yang jelas dan terstruktur
✅ **Active state indicator** - User tahu posisi mereka di aplikasi
✅ **Mobile-friendly** - Bootstrap responsive sidebar
✅ **Icon visual cues** - Bootstrap Icons untuk identifikasi cepat

## Next Steps (Optional)
- [ ] Tambahkan badge notifikasi di menu (misalnya jumlah permintaan pending)
- [ ] Tambahkan menu "Data Master" untuk Kaprodi/Dekan
- [ ] Tambahkan submenu/dropdown untuk menu yang kompleks
- [ ] Implementasi breadcrumb navigation
- [ ] Tambahkan keyboard shortcuts untuk quick navigation

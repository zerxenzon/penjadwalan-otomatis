# 📘 PANDUAN LENGKAP UNTUK KAPRODI (KETUA PROGRAM STUDI)

## 🎯 Ringkasan Peran Kaprodi

Kaprodi bertanggung jawab untuk:
1. ✅ **Mengelola Data Master** (Mata Kuliah, Ruangan, Kelas)
2. ✅ **Mengelola Data Dosen**
3. ✅ **Membuat Surat Tugas Mengajar (STM)** untuk dosen
4. ✅ **Menyusun Jadwal Kuliah** untuk setiap kelas
5. ✅ **Mencetak/Download STM dalam format PDF**
6. ✅ **Memantau Jadwal yang sudah di-charter oleh dosen**

---

## 🔐 Cara Login

1. Buka browser dan akses: `http://127.0.0.1:8000/login` (atau sesuai URL server Anda)
2. Masukkan kredensial Kaprodi:
   - **Username**: `kaprodi123`
   - **Password**: `kaprodi123`
3. Klik tombol **Login**

---

## 📋 TAHAPAN KERJA KAPRODI (ALUR LENGKAP)

### **FASE 1: PERSIAPAN DATA MASTER**

#### 1️⃣ Kelola Mata Kuliah
**Menu**: Dashboard → Mata Kuliah

**Langkah-langkah:**
1. Klik menu **"Mata Kuliah"** di sidebar
2. Untuk menambah mata kuliah baru:
   - Klik tombol **"+ Tambah Mata Kuliah"**
   - Isi form:
     - **Kode MK**: Contoh `TI101`, `SI201`
     - **Nama**: Contoh `Pemrograman Web`, `Basis Data`
     - **SKS**: Pilih jumlah SKS (1-4)
     - **Semester**: Pilih semester (1-8)
     - **Prodi**: Pilih program studi
   - Klik **"Simpan"**
3. Untuk edit: Klik tombol **"Edit"** (ikon pensil) pada data yang ingin diubah
4. Untuk hapus: Klik tombol **"Hapus"** (ikon tempat sampah)

---

#### 2️⃣ Kelola Ruangan
**Menu**: Dashboard → Ruangan

**Langkah-langkah:**
1. Klik menu **"Ruangan"** di sidebar
2. Untuk menambah ruangan baru:
   - Klik tombol **"+ Tambah Ruangan"**
   - Isi form:
     - **Kode**: Contoh `LAB1`, `R101`
     - **Nama**: Contoh `Lab Komputer 1`, `Ruang Kelas 101`
     - **Kapasitas**: Contoh `40` (jumlah kursi)
   - Klik **"Simpan"**
3. Untuk edit/hapus: Sama seperti mata kuliah

---

#### 3️⃣ Kelola Kelas
**Menu**: Dashboard → Kelas

**Langkah-langkah:**
1. Klik menu **"Kelas"** di sidebar
2. Untuk menambah kelas baru:
   - Klik tombol **"+ Tambah Kelas"**
   - Isi form:
     - **Nama Kelas**: Contoh `TI-2A`, `SI-3B`
     - **Angkatan**: Pilih tahun angkatan (2021-2025)
     - **Semester**: Pilih semester aktif (1-8)
     - **Prodi**: Pilih program studi
   - Klik **"Simpan"**

---

#### 4️⃣ Kelola Data Dosen
**Menu**: Dashboard → Dosen

**Langkah-langkah:**
1. Klik menu **"Dosen"** di sidebar
2. Untuk menambah dosen baru:
   - Klik tombol **"+ Tambah Dosen"**
   - Isi form:
     - **Username**: Contoh `dosen001` (untuk login)
     - **Password**: Buat password yang aman
     - **Nama**: Nama lengkap dosen
     - **NIDN**: Nomor Induk Dosen Nasional
     - **Email**: Email dosen
   - Klik **"Simpan"**
3. Dosen akan mendapat akses login dengan username dan password yang dibuat

---

### **FASE 2: PEMBUATAN SURAT TUGAS MENGAJAR (STM)**

#### 5️⃣ Buat Surat Tugas Mengajar
**Menu**: Dashboard → Surat Tugas Mengajar

**Apa itu STM?**
STM adalah dokumen penugasan dosen untuk mengajar mata kuliah tertentu di kelas tertentu.

**Langkah-langkah:**
1. Klik menu **"Surat Tugas Mengajar"** di sidebar
2. Klik tombol **"+ Tambah STM"**
3. Isi form:
   - **Dosen**: Pilih nama dosen yang akan mengajar
   - **Mata Kuliah**: Pilih mata kuliah yang akan diampu
   - **Kelas**: Pilih kelas yang akan diajar
   - **Semester**: Pilih semester aktif
4. Klik **"Simpan"**

**Contoh:**
- Dosen: **Dr. Ahmad Wijaya**
- Mata Kuliah: **Pemrograman Web 2**
- Kelas: **TI-3A**
- Semester: **Ganjil 2025/2026**

**Catatan Penting:**
- ⚠️ Satu dosen bisa punya banyak STM (mengajar di beberapa kelas/mata kuliah)
- ⚠️ STM harus dibuat **SEBELUM** membuat jadwal
- ⚠️ STM bisa dicetak sebagai PDF untuk arsip/tanda tangan

---

### **FASE 3: PENYUSUNAN JADWAL KULIAH**

#### 6️⃣ Buat Jadwal Kuliah
**Menu**: Dashboard → Jadwal

**Langkah-langkah:**
1. Klik menu **"Jadwal"** di sidebar
2. Klik tombol **"+ Tambah Jadwal"**
3. Isi form:
   - **Surat Tugas Mengajar**: Pilih STM yang sudah dibuat (akan muncul nama dosen, mata kuliah, dan kelas)
   - **Hari**: Pilih hari (Senin - Sabtu)
   - **Jam Mulai**: Contoh `08:00`
   - **Jam Selesai**: Contoh `10:30` (sesuai SKS)
   - **Ruangan**: Pilih ruangan yang tersedia
   - **Shift**: Pilih shift (Pagi/Siang/Sore)
4. Klik **"Simpan"**

**Validasi Otomatis Sistem:**
- ✅ Tidak boleh bentrok waktu di ruangan yang sama
- ✅ Tidak boleh bentrok waktu untuk dosen yang sama
- ✅ Tidak boleh bentrok waktu untuk kelas yang sama

**Contoh Jadwal:**
```
STM        : Dr. Ahmad Wijaya - Pemrograman Web 2 - TI-3A
Hari       : Selasa
Jam        : 08:00 - 10:30
Ruangan    : Lab Komputer 1
Shift      : Pagi
```

---

### **FASE 4: MONITORING & MANAJEMEN**

#### 7️⃣ Cetak/Download STM PDF
**Menu**: Dashboard → Surat Tugas Mengajar

**Langkah-langkah:**
1. Di halaman **Surat Tugas Mengajar**, cari STM yang ingin dicetak
2. Klik tombol **"Download PDF"** (ikon PDF) di kolom Aksi
3. File PDF akan otomatis ter-download
4. PDF bisa dicetak untuk tanda tangan Kaprodi dan Dekan

**Isi PDF STM:**
- Nomor STM
- Nama Dosen & NIDN
- Mata Kuliah & Kode MK
- Kelas & Program Studi
- SKS & Semester
- Tempat untuk tanda tangan Kaprodi & Dekan

---

#### 8️⃣ Pantau Jadwal yang Di-Charter Dosen
**Menu**: Dashboard → Charter Jadwal

**Apa itu Charter Jadwal?**
Charter adalah proses dimana **dosen mengklaim jadwal kosong** (jadwal yang belum ada dosen pengampunya).

**Langkah-langkah:**
1. Klik menu **"Charter Jadwal"** di sidebar
2. Anda akan melihat daftar jadwal yang sudah di-charter oleh dosen
3. Kolom yang ditampilkan:
   - **Dosen**: Nama dosen yang melakukan charter
   - **Mata Kuliah**: Mata kuliah yang di-charter
   - **Kelas**: Kelas yang di-charter
   - **Hari & Jam**: Waktu jadwal
   - **Ruangan**: Lokasi kuliah
   - **Tanggal Charter**: Kapan dosen melakukan charter

**Fungsi:**
- ✅ Memantau jadwal mana yang sudah diambil dosen
- ✅ Memastikan tidak ada jadwal yang kosong
- ✅ Koordinasi jika ada masalah pada jadwal tertentu

---

#### 9️⃣ Edit Jadwal yang Sudah Ada
**Menu**: Dashboard → Jadwal

**Langkah-langkah:**
1. Di halaman **Jadwal**, klik tombol **"Edit"** pada jadwal yang ingin diubah
2. Ubah data yang perlu diubah (hari, jam, ruangan, dll)
3. Klik **"Simpan"**

**Catatan:**
- ⚠️ Hati-hati saat edit jadwal yang sudah di-charter dosen
- ⚠️ Koordinasikan dengan dosen jika ada perubahan jadwal

---

#### 🔟 Hapus Jadwal
**Menu**: Dashboard → Jadwal

**Langkah-langkah:**
1. Klik tombol **"Hapus"** pada jadwal yang ingin dihapus
2. Konfirmasi penghapusan
3. Jadwal akan terhapus dari sistem

**Catatan:**
- ⚠️ Jika jadwal sudah di-charter dosen, pastikan memberitahu dosen terlebih dahulu
- ⚠️ Penghapusan bersifat permanen

---

## 🔄 ALUR KERJA LENGKAP (SUMMARY)

```
1. LOGIN sebagai Kaprodi
   ↓
2. BUAT DATA MASTER
   - Mata Kuliah
   - Ruangan
   - Kelas
   ↓
3. TAMBAH DATA DOSEN
   ↓
4. BUAT SURAT TUGAS MENGAJAR (STM)
   - Tentukan dosen untuk mata kuliah & kelas tertentu
   ↓
5. BUAT JADWAL KULIAH
   - Pilih STM yang sudah dibuat
   - Tentukan hari, jam, ruangan
   ↓
6. CETAK STM PDF
   - Download untuk arsip/tanda tangan
   ↓
7. MONITOR CHARTER JADWAL
   - Pantau jadwal yang sudah diklaim dosen
```

---

## 📊 TIPS & BEST PRACTICES

### ✅ Do's (Yang Harus Dilakukan)
1. **Buat data master lengkap** sebelum membuat jadwal
2. **Buat STM terlebih dahulu** sebelum membuat jadwal
3. **Cek bentrok** jadwal sebelum finalisasi
4. **Koordinasi dengan dosen** jika ada perubahan jadwal
5. **Backup data** secara berkala
6. **Cetak STM PDF** untuk arsip resmi

### ❌ Don'ts (Yang Harus Dihindari)
1. ❌ Jangan buat jadwal tanpa STM terlebih dahulu
2. ❌ Jangan edit jadwal yang sudah di-charter tanpa konfirmasi dosen
3. ❌ Jangan buat jadwal yang bentrok waktu/ruangan
4. ❌ Jangan hapus mata kuliah yang masih digunakan di jadwal aktif

---

## 🆘 TROUBLESHOOTING

### Problem: "Tidak bisa buat jadwal"
**Solusi:**
- ✅ Pastikan STM sudah dibuat terlebih dahulu
- ✅ Cek apakah ada bentrok waktu/ruangan
- ✅ Pastikan semua field wajib terisi

### Problem: "Dosen tidak bisa login"
**Solusi:**
- ✅ Cek username dan password sudah benar
- ✅ Pastikan data dosen sudah disimpan di sistem
- ✅ Cek role user sudah diset sebagai "dosen"

### Problem: "Jadwal bentrok terus"
**Solusi:**
- ✅ Gunakan fitur filter/search untuk cek jadwal yang ada
- ✅ Buat jadwal di waktu/ruangan yang berbeda
- ✅ Koordinasikan dengan tim penjadwalan

---

## 📞 KONTAK SUPPORT

Jika ada masalah atau pertanyaan:
- 📧 Email: support@university.ac.id
- 📱 WhatsApp: +62 xxx-xxxx-xxxx
- 🏢 Kantor: Gedung Fakultas Komputer Lt. 2

---

## 📝 CHANGELOG

- **v1.0** (23 Oktober 2025): Panduan awal Kaprodi
- Fitur yang tersedia:
  - ✅ Manajemen Data Master
  - ✅ Manajemen Dosen
  - ✅ Surat Tugas Mengajar
  - ✅ Penjadwalan Kuliah
  - ✅ Cetak PDF STM
  - ✅ Monitor Charter Jadwal

---

**© 2025 Sistem Penjadwalan Kuliah - Fakultas Komputer**

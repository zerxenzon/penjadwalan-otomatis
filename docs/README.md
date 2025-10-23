# 📚 DOKUMENTASI SISTEM PENJADWALAN

Selamat datang di dokumentasi lengkap sistem penjadwalan kuliah!

## 📖 Daftar Dokumentasi

### 👨‍💼 Untuk Kaprodi (Ketua Program Studi)
- **[PANDUAN_KAPRODI.md](PANDUAN_KAPRODI.md)** - Panduan lengkap untuk Kaprodi
  - ✅ Cara login & setup awal
  - ✅ Manajemen data master (Mata Kuliah, Ruangan, Kelas, Dosen)
  - ✅ Membuat Surat Tugas Mengajar (STM)
  - ✅ Menyusun jadwal kuliah
  - ✅ Cetak PDF STM
  - ✅ Monitoring charter jadwal
  
- **[KAPRODI_QUICK_GUIDE.md](KAPRODI_QUICK_GUIDE.md)** - Cheat Sheet Kaprodi
  - ⚡ Panduan singkat 1 halaman
  - ⚡ Alur kerja cepat 5 langkah
  - ⚡ Cocok untuk ditempel di ruang kerja

- **[FAQ_KAPRODI.md](FAQ_KAPRODI.md)** - 50+ FAQ Kaprodi
  - ❓ Pertanyaan yang sering ditanyakan
  - ❓ Troubleshooting masalah umum
  - ❓ Tips & tricks

### 🎥 Untuk Pembuatan Tutorial
- **[VIDEO_TUTORIAL_OUTLINE.md](VIDEO_TUTORIAL_OUTLINE.md)** - Outline Video Tutorial
  - 🎬 6 outline video lengkap dengan timestamp
  - 🎬 Script contoh narasi
  - 🎬 Tips produksi video

### 🗄️ Untuk Developer/IT
- **[DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)** - Database Schema
  - 💾 ERD (Entity Relationship Diagram)
  - 💾 Struktur tabel lengkap
  - 💾 Foreign key relationships

---

## 🚀 Quick Start Guide

### 🎯 Saya Kaprodi - Mulai Dari Mana?

**Langkah 1: Baca Quick Guide (5 menit)**
```bash
Buka: KAPRODI_QUICK_GUIDE.md
```

**Langkah 2: Login & Coba Sistem (15 menit)**
```
URL: http://127.0.0.1:8000/login
Username: kaprodi123
Password: kaprodi123
```

**Langkah 3: Jika Ada Pertanyaan (10 menit)**
```bash
Buka: FAQ_KAPRODI.md
Cari pertanyaan yang sesuai dengan Ctrl+F
```

**Langkah 4: Untuk Detail Lengkap (30 menit)**
```bash
Buka: PANDUAN_KAPRODI.md
Baca bagian yang relevan dengan tugas Anda
```

---

### 🎯 Saya Developer - Mulai Dari Mana?

**Langkah 1: Setup Project**
```bash
git clone [repository]
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

**Langkah 2: Pahami Database**
```bash
Buka: DATABASE_SCHEMA.md
Lihat ERD dan struktur tabel
```

**Langkah 3: Eksplorasi Kode**
```
- Models: app/Models/
- Controllers: app/Http/Controllers/
- Views: resources/views/
- Routes: routes/web.php
```

---

## 📊 Struktur Dokumentasi

```
docs/
├── README.md                      ← Anda disini
├── PANDUAN_KAPRODI.md            ← Panduan lengkap Kaprodi
├── KAPRODI_QUICK_GUIDE.md        ← Cheat sheet Kaprodi
├── FAQ_KAPRODI.md                ← 50+ FAQ Kaprodi
├── VIDEO_TUTORIAL_OUTLINE.md      ← Outline video tutorial
└── DATABASE_SCHEMA.md             ← Database schema
```

---

## 🎓 Peran & Akses Sistem

### Kaprodi (Ketua Program Studi)
**Username**: `kaprodi123` | **Password**: `kaprodi123`

**Akses:**
- ✅ Kelola semua data master (Mata Kuliah, Ruangan, Kelas)
- ✅ Kelola data dosen
- ✅ Buat Surat Tugas Mengajar (STM)
- ✅ Buat & kelola jadwal kuliah
- ✅ Cetak PDF STM
- ✅ Monitor charter jadwal

**Tidak Bisa:**
- ❌ Melakukan charter jadwal (khusus dosen)
- ❌ Mengajukan barter jadwal (khusus dosen)

---

### Dosen (Pengajar)
**Username**: `dosen123`, `dosen1234`, dll | **Password**: sama dengan username

**Akses:**
- ✅ Lihat jadwal mengajar mereka sendiri
- ✅ Lihat STM mereka sendiri
- ✅ Melakukan **charter jadwal kosong**
- ✅ Mengajukan **barter jadwal** dengan dosen lain
- ✅ Approve/reject permintaan barter dari dosen lain

**Tidak Bisa:**
- ❌ Membuat jadwal baru
- ❌ Edit jadwal yang sudah ada
- ❌ Akses data master

---

### Dekan
**Username**: `dekan123` | **Password**: `dekan123`

**Akses:**
- ✅ Lihat semua jadwal
- ✅ Monitor semua aktivitas
- ✅ Approve dokumen (fitur mendatang)

---

## 🔧 Sistem Requirements

### Server Requirements
- PHP >= 8.3
- MySQL >= 8.0
- Composer >= 2.0
- Node.js >= 18.0

### Browser Requirements
- Chrome/Edge (Recommended) >= 100
- Firefox >= 100
- Safari >= 15

---

## 📞 Kontak & Support

### Untuk Kaprodi/User
- 📧 Email: support@university.ac.id
- 📱 WhatsApp: +62 xxx-xxxx-xxxx
- 🏢 Kantor: Gedung Fakultas Komputer Lt. 2

### Untuk Developer
- 💻 GitHub Issues: [Link Repository]
- 💬 Slack Channel: #dev-penjadwalan
- 📧 Dev Email: dev@university.ac.id

---

## 🐛 Melaporkan Bug

Jika menemukan bug, mohon laporkan dengan format:

```
**Bug Title**: [Judul singkat bug]

**Langkah Reproduksi**:
1. Login sebagai Kaprodi
2. Buka menu Jadwal
3. Klik Tambah Jadwal
4. ...

**Expected**: Seharusnya bisa simpan jadwal
**Actual**: Muncul error "Validation failed"

**Screenshot**: [Attach screenshot]
**Browser**: Chrome 141
**OS**: Windows 11
```

---

## 🎯 Roadmap Fitur Mendatang

- [ ] Export jadwal ke Excel/PDF
- [ ] Notifikasi real-time
- [ ] Fitur approval multi-level
- [ ] Dashboard analytics
- [ ] Mobile app (Android/iOS)
- [ ] API untuk integrasi sistem lain
- [ ] Fitur backup/restore otomatis

---

## 📜 Changelog

### v1.0 (23 Oktober 2025)
- ✅ Manajemen data master
- ✅ Surat Tugas Mengajar (STM)
- ✅ Penjadwalan kuliah
- ✅ Charter jadwal
- ✅ Barter jadwal
- ✅ Cetak PDF STM
- ✅ Validasi bentrok otomatis

---

## 📖 Lisensi

© 2025 Universitas [Nama Universitas]. All rights reserved.

---

## 🙏 Kontributor

- **Project Manager**: [Nama]
- **Lead Developer**: [Nama]
- **UI/UX Designer**: [Nama]
- **QA Tester**: [Nama]
- **Technical Writer**: AI Assistant

---

**Terakhir Diupdate**: 23 Oktober 2025  
**Versi Dokumentasi**: 1.0  
**Versi Sistem**: 1.0.0

---

💡 **Tips**: Gunakan Ctrl+F untuk mencari topik spesifik dalam dokumentasi ini!

# 📚 PANDUAN LENGKAP UNTUK MAHASISWA

## 🎓 Ringkasan Peran Mahasiswa

Mahasiswa hanya memiliki akses **READ-ONLY** (hanya melihat) di sistem ini. Fungsi utama:
- ✅ **Melihat jadwal kuliah kelas mereka**
- ✅ **Mengetahui dosen pengampu**
- ✅ **Mengetahui ruangan, hari, dan jam kuliah**

---

## 🔐 Cara Login

1. Buka browser dan akses: `http://127.0.0.1:8000/login`
2. Masukkan kredensial mahasiswa:
   - **Username**: `mahasiswa123`
   - **Password**: `mahasiswa123`
3. Klik tombol **Login**

---

## 📋 FITUR YANG TERSEDIA UNTUK MAHASISWA

### 1️⃣ **Dashboard Mahasiswa**
**Apa yang bisa dilakukan?**
- Melihat jadwal kuliah lengkap untuk kelas Anda
- Informasi yang ditampilkan:
  - ✅ Mata Kuliah (nama + kode MK)
  - ✅ Dosen Pengampu
  - ✅ Ruangan
  - ✅ Hari
  - ✅ Jam Mulai - Jam Selesai

**Cara Menggunakan:**
1. Setelah login, Anda akan langsung masuk ke **Dashboard Mahasiswa**
2. Akan muncul tabel jadwal kuliah kelas Anda
3. Jadwal sudah diurutkan berdasarkan hari dan jam
4. Jika tidak ada jadwal, akan muncul pesan "Tidak ada jadwal kuliah"

---

## 📊 CONTOH TAMPILAN JADWAL

```
No | Mata Kuliah              | Dosen                | Ruangan    | Hari   | Jam
---|--------------------------|----------------------|------------|--------|----------------
1  | Pemrograman Web 2        | Dr. Ahmad Wijaya     | Lab Komp 1 | Selasa | 08:00 - 10:30
   | TI301                    |                      |            |        |
---|--------------------------|----------------------|------------|--------|----------------
2  | Basis Data              | Dr. Budi Santoso     | R. 101     | Rabu   | 10:30 - 13:00
   | TI302                   |                      |            |        |
---|--------------------------|----------------------|------------|--------|----------------
3  | Jaringan Komputer       | Ir. Cahya Ramadhan   | Lab Komp 2 | Kamis  | 08:00 - 10:30
   | TI303                   |                      |            |        |
```

---

## ❌ YANG TIDAK BISA DILAKUKAN MAHASISWA

Mahasiswa **TIDAK BISA**:
- ❌ Mengubah jadwal
- ❌ Menambah jadwal baru
- ❌ Menghapus jadwal
- ❌ Melakukan charter jadwal
- ❌ Mengajukan barter jadwal
- ❌ Mengakses data master (mata kuliah, ruangan, dll)
- ❌ Melihat jadwal kelas lain

**Alasan:** Hak akses mahasiswa hanya untuk **melihat jadwal kelas mereka sendiri** saja.

---

## 🆘 TROUBLESHOOTING

### Problem: "Tidak ada jadwal kuliah"
**Kemungkinan Penyebab:**
1. Jadwal belum dibuat oleh Kaprodi
2. Data biodata/kelas mahasiswa belum lengkap
3. Mahasiswa belum terdaftar di kelas tertentu

**Solusi:**
- Hubungi Kaprodi atau admin untuk:
  - Memastikan jadwal sudah dibuat
  - Melengkapi data biodata Anda
  - Mendaftarkan Anda ke kelas yang sesuai

---

### Problem: "Data biodata atau kelas Anda belum lengkap"
**Penyebab:**
- Data biodata Anda di sistem belum lengkap
- Anda belum didaftarkan ke kelas tertentu

**Solusi:**
- Hubungi admin atau Kaprodi untuk melengkapi data:
  - Nama lengkap
  - NIM
  - Kelas (contoh: TI-3A, SI-2B)
  - Data pribadi lainnya

---

### Problem: "Tidak bisa login"
**Penyebab:**
- Username/password salah
- Akun belum dibuat
- Akun tidak aktif

**Solusi:**
- Pastikan username dan password benar
- Hubungi admin untuk:
  - Membuat akun baru
  - Reset password
  - Mengaktifkan akun Anda

---

## 🎯 TIPS UNTUK MAHASISWA

### ✅ Do's (Yang Harus Dilakukan)
1. **Selalu cek jadwal** di awal minggu
2. **Screenshot jadwal** untuk backup
3. **Catat perubahan** jika ada update dari dosen
4. **Hubungi dosen** jika ada pertanyaan tentang jadwal
5. **Logout** setelah selesai menggunakan sistem

### ❌ Don'ts (Yang Harus Dihindari)
1. ❌ Jangan bagikan username/password ke orang lain
2. ❌ Jangan mencoba mengakses menu yang tidak tersedia
3. ❌ Jangan menggunakan akun orang lain
4. ❌ Jangan lupa logout di komputer umum

---

## 📱 AKSES VIA MOBILE

Sistem ini **responsive** dan bisa diakses via smartphone:

**Langkah-langkah:**
1. Buka browser di HP (Chrome/Safari/Firefox)
2. Akses: `http://127.0.0.1:8000/login` (atau URL yang diberikan)
3. Login dengan username dan password
4. Jadwal akan muncul dalam format mobile-friendly
5. Bisa di-scroll untuk melihat semua jadwal

---

## 📞 KONTAK BANTUAN

Jika ada masalah atau pertanyaan:

**Untuk Masalah Teknis (Login, Password, dll):**
- 📧 Email: admin@university.ac.id
- 📱 WhatsApp: +62 xxx-xxxx-xxxx

**Untuk Masalah Jadwal (Bentrok, Salah Ruangan, dll):**
- 📧 Email: kaprodi@university.ac.id
- 🏢 Datang ke ruang Kaprodi

**Untuk Pertanyaan Mata Kuliah:**
- 💬 Hubungi dosen pengampu langsung
- 📧 Email dosen (lihat di sistem)

---

## ❓ FAQ MAHASISWA

### Q1: Apakah jadwal bisa berubah?
**A:** Ya, jadwal bisa berubah jika:
- Ada perubahan dari Kaprodi
- Dosen melakukan barter jadwal dengan dosen lain
- Ada pindah ruangan karena alasan tertentu

Selalu cek sistem secara berkala untuk update terbaru!

---

### Q2: Bagaimana jika ada jadwal yang bentrok?
**A:** Seharusnya tidak ada jadwal bentrok karena sistem sudah validasi otomatis. Tapi jika terjadi:
1. Screenshot jadwal yang bentrok
2. Laporkan ke Kaprodi
3. Kaprodi akan segera memperbaiki

---

### Q3: Apakah bisa download/cetak jadwal?
**A:** Saat ini belum ada fitur download otomatis. Cara manual:
- Screenshot jadwal di layar
- Atau gunakan fitur Print (Ctrl + P) di browser

---

### Q4: Apakah bisa melihat jadwal kelas lain?
**A:** Tidak bisa. Anda hanya bisa melihat jadwal kelas Anda sendiri untuk menjaga privasi.

---

### Q5: Bagaimana jika nama dosen atau ruangan salah?
**A:** Laporkan ke Kaprodi dengan detail:
- Mata kuliah yang salah
- Kesalahan yang terjadi (nama dosen/ruangan/waktu)
- Screenshot sebagai bukti

---

### Q6: Apakah ada notifikasi jika ada perubahan jadwal?
**A:** Saat ini belum ada fitur notifikasi otomatis. Jadi:
- Cek sistem secara berkala (minimal 1x seminggu)
- Ikuti pengumuman dari Kaprodi via grup WhatsApp/email
- Koordinasi dengan ketua kelas

---

### Q7: Berapa jam sebelum kuliah harus cek jadwal?
**A:** Disarankan:
- Cek jadwal di awal minggu (Minggu malam)
- Cek ulang setiap pagi sebelum kuliah
- Jika ada info perubahan dari dosen, segera cek sistem

---

### Q8: Apakah bisa request perubahan jadwal?
**A:** Tidak bisa request langsung via sistem. Cara-nya:
1. Ajukan ke ketua kelas
2. Ketua kelas koordinasi dengan Kaprodi
3. Kaprodi yang akan melakukan perubahan di sistem

---

### Q9: Sistem lambat atau error, apa yang harus dilakukan?
**A:** 
1. Refresh browser (F5)
2. Clear cache browser (Ctrl + Shift + Del)
3. Coba browser lain (Chrome/Firefox/Edge)
4. Jika masih error, lapor ke IT Support

---

### Q10: Apakah data jadwal selalu up-to-date?
**A:** Ya, jadwal yang tampil di sistem adalah data real-time. Setiap perubahan dari Kaprodi/Dosen akan langsung update di sistem.

---

## 🎓 CONTOH KASUS PENGGUNAAN

### **Kasus 1: Mau Cek Jadwal Hari Ini**
```
1. Login ke sistem
2. Di Dashboard, lihat tabel jadwal
3. Cari baris dengan hari ini (contoh: Selasa)
4. Catat mata kuliah, dosen, ruangan, dan jam
5. Logout
```

### **Kasus 2: Jadwal Bentrok dengan Jadwal Pribadi**
```
1. Screenshot jadwal dari sistem
2. Hubungi Kaprodi via email/WhatsApp
3. Jelaskan jadwal mana yang bentrok
4. Tunggu konfirmasi dari Kaprodi
5. (Kaprodi akan koordinasi dengan dosen terkait)
```

### **Kasus 3: Dosen Menginfokan Pindah Ruangan**
```
1. Cek sistem, apakah sudah update?
2. Jika belum update, informasikan ke Kaprodi
3. Kaprodi akan update sistem
4. Refresh browser, jadwal akan update
5. Screenshot jadwal baru untuk backup
```

---

## 📖 PANDUAN VISUAL (Screenshot Contoh)

### Login Page
```
┌────────────────────────────────────┐
│     SISTEM PENJADWALAN KULIAH      │
├────────────────────────────────────┤
│  Username: [mahasiswa123        ]  │
│  Password: [••••••••••••        ]  │
│                                     │
│         [  LOGIN  ]                 │
└────────────────────────────────────┘
```

### Dashboard Mahasiswa
```
┌─────────────────────────────────────────────────────────────────┐
│ Dashboard Mahasiswa                          23 Oktober 2025     │
├─────────────────────────────────────────────────────────────────┤
│                       Jadwal Kelas Anda                          │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ No│Mata Kuliah│Dosen      │Ruangan │Hari  │Jam           │ │
│ ├───┼───────────┼───────────┼────────┼──────┼──────────────┤ │
│ │ 1 │Prog Web 2 │Dr. Ahmad  │Lab 1   │Selasa│08:00 - 10:30│ │
│ │   │TI301      │           │        │      │              │ │
│ ├───┼───────────┼───────────┼────────┼──────┼──────────────┤ │
│ │ 2 │Basis Data │Dr. Budi   │R. 101  │Rabu  │10:30 - 13:00│ │
│ │   │TI302      │           │        │      │              │ │
│ └─────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 ALUR KERJA MAHASISWA (FLOWCHART)

```
[START] 
   ↓
[LOGIN dengan username/password]
   ↓
[Masuk Dashboard Mahasiswa]
   ↓
[Lihat Tabel Jadwal Kuliah]
   ↓
┌─── Ada Jadwal? ────┐
│ YA                 │ TIDAK
↓                    ↓
[Catat/Screenshot   [Hubungi Kaprodi/
 Jadwal]             Admin]
↓                    ↓
[Logout]            [Tunggu Jadwal
                     Dibuat]
   ↓
[END]
```

---

## 📝 CHANGELOG & UPDATE

### v1.0 (23 Oktober 2025)
- ✅ Fitur lihat jadwal kelas
- ✅ Responsive design untuk mobile
- ✅ Error handling jika data tidak lengkap

### Fitur yang Akan Datang
- 📱 Notifikasi push jika ada perubahan jadwal
- 📧 Email notifikasi otomatis
- 📥 Download jadwal dalam format PDF/Excel
- 🔔 Reminder sebelum jadwal kuliah dimulai

---

**© 2025 Sistem Penjadwalan Kuliah - Fakultas Komputer**

**Last Updated**: 23 Oktober 2025  
**Versi Panduan**: 1.0  
**Untuk**: Mahasiswa

---

💡 **TIP**: Bookmark halaman sistem ini di browser agar mudah diakses kapan saja!

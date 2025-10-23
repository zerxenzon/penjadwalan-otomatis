# ❓ FAQ - KAPRODI (Frequently Asked Questions)

## 🔐 TENTANG AKUN & LOGIN

### Q1: Bagaimana cara login sebagai Kaprodi?
**A:** 
- URL: `http://127.0.0.1:8000/login`
- Username: `kaprodi123`
- Password: `kaprodi123`

### Q2: Lupa password, bagaimana cara reset?
**A:** Hubungi admin sistem untuk reset password. Saat ini belum ada fitur lupa password otomatis.

### Q3: Apakah Kaprodi bisa melihat jadwal dosen lain?
**A:** Ya, Kaprodi memiliki akses melihat semua jadwal di program studinya.

---

## 📋 DATA MASTER

### Q4: Urutan apa yang harus dilakukan pertama kali?
**A:** Urutan yang benar:
1. Tambah **Mata Kuliah**
2. Tambah **Ruangan**
3. Tambah **Kelas**
4. Tambah **Dosen**
5. Buat **Surat Tugas Mengajar (STM)**
6. Buat **Jadwal**

### Q5: Bisa tidak menghapus mata kuliah yang sudah ada jadwalnya?
**A:** Tidak disarankan. Sistem akan mencegah penghapusan jika mata kuliah masih terpakai di STM atau jadwal aktif.

### Q6: Bagaimana cara edit data yang salah input?
**A:** Klik tombol "Edit" (ikon pensil) pada data yang ingin diubah, lalu simpan perubahan.

---

## 📄 SURAT TUGAS MENGAJAR (STM)

### Q7: Apa itu Surat Tugas Mengajar (STM)?
**A:** STM adalah dokumen penugasan resmi yang menyatakan dosen tertentu ditugaskan mengajar mata kuliah tertentu di kelas tertentu.

### Q8: Apakah STM wajib dibuat sebelum buat jadwal?
**A:** Ya, **WAJIB**. Sistem tidak akan bisa membuat jadwal tanpa STM terlebih dahulu.

### Q9: Satu dosen bisa punya berapa STM?
**A:** Tidak terbatas. Satu dosen bisa mengajar banyak mata kuliah dan kelas, jadi bisa punya banyak STM.

### Q10: Apakah STM bisa dihapus?
**A:** Ya, tapi **hati-hati**. Jika STM dihapus, semua jadwal yang terkait akan ikut terhapus/bermasalah.

### Q11: Bagaimana cara cetak STM?
**A:** 
1. Masuk ke menu "Surat Tugas Mengajar"
2. Klik tombol "Download PDF" (ikon PDF) pada STM yang ingin dicetak
3. File PDF akan otomatis ter-download
4. Buka dan cetak PDF tersebut

### Q12: Apa saja isi STM PDF?
**A:** 
- Nomor STM
- Nama Dosen & NIDN
- Mata Kuliah & Kode MK
- Kelas & Prodi
- SKS & Semester
- Ruang tanda tangan Kaprodi & Dekan

---

## 📅 JADWAL KULIAH

### Q13: Kenapa tidak bisa buat jadwal?
**A:** Cek hal berikut:
- ✅ STM sudah dibuat?
- ✅ Ada bentrok waktu/ruangan/dosen/kelas?
- ✅ Semua field sudah terisi?
- ✅ Format jam sudah benar? (HH:mm)

### Q14: Apa itu bentrok jadwal?
**A:** Bentrok terjadi jika:
- Ruangan sama di waktu yang sama
- Dosen sama di waktu yang sama
- Kelas sama di waktu yang sama

### Q15: Bagaimana sistem mencegah bentrok?
**A:** Sistem akan **otomatis validasi** dan menolak jadwal yang bentrok dengan memberikan pesan error.

### Q16: Apakah bisa edit jadwal yang sudah ada?
**A:** Ya, tapi **koordinasikan dengan dosen** terlebih dahulu, apalagi jika jadwal sudah di-charter.

### Q17: Berapa lama durasi jadwal yang umum?
**A:** Tergantung SKS:
- 1 SKS = 50 menit
- 2 SKS = 100 menit (1 jam 40 menit)
- 3 SKS = 150 menit (2 jam 30 menit)
- 4 SKS = 200 menit (3 jam 20 menit)

**Contoh:**
- Mata kuliah 3 SKS → 08:00 - 10:30 (2.5 jam)

### Q18: Apakah jadwal bisa dibuat untuk hari Minggu?
**A:** Tergantung konfigurasi sistem. Biasanya sistem hanya support Senin - Sabtu.

---

## 🔄 CHARTER JADWAL

### Q19: Apa itu Charter Jadwal?
**A:** Charter adalah proses dimana **dosen mengklaim jadwal kosong** (jadwal yang sudah dibuat tapi belum ada dosen pengampunya).

### Q20: Apakah Kaprodi bisa melihat jadwal yang di-charter dosen?
**A:** Ya, Kaprodi bisa monitor semua charter jadwal melalui menu "Charter Jadwal".

### Q21: Apakah Kaprodi bisa membatalkan charter dosen?
**A:** Kaprodi bisa menghapus charter jika diperlukan, tapi sebaiknya koordinasi dulu dengan dosen.

### Q22: Kapan dosen bisa melakukan charter?
**A:** Setelah Kaprodi membuat jadwal kosong (jadwal tanpa STM atau STM tanpa dosen).

---

## 🔄 BARTER JADWAL

### Q23: Apa itu Barter Jadwal?
**A:** Barter adalah proses **tukar menukar jadwal** antara dua dosen yang saling setuju.

### Q24: Apakah Kaprodi terlibat dalam barter jadwal?
**A:** Tidak langsung. Barter adalah transaksi antar dosen. Kaprodi hanya bisa memantau saja.

### Q25: Apakah barter jadwal otomatis atau perlu approval?
**A:** Barter memerlukan **approval dari dosen tujuan**. Jika disetujui, sistem otomatis menukar jadwal.

---

## 🛠️ TEKNIS & TROUBLESHOOTING

### Q26: Kenapa tombol "Simpan" tidak berfungsi?
**A:** Kemungkinan:
- Ada field wajib yang belum diisi
- Ada error validasi (cek pesan error di atas form)
- Koneksi internet terputus
- Browser cache perlu di-clear (Ctrl + Shift + R)

### Q27: Kenapa data yang baru ditambah tidak muncul?
**A:** Coba:
1. Refresh halaman (F5)
2. Hard refresh (Ctrl + Shift + R)
3. Clear cache browser
4. Cek apakah ada pesan error saat simpan

### Q28: Kenapa PDF tidak bisa di-download?
**A:** Kemungkinan:
- Pop-up blocker aktif di browser
- Browser tidak support PDF viewer
- File permission error di server
- Hubungi IT support

### Q29: Apakah data bisa di-export ke Excel?
**A:** Saat ini belum ada fitur export. Gunakan screenshot atau copy-paste manual.

### Q30: Bagaimana cara backup data?
**A:** Hubungi admin sistem untuk melakukan backup database berkala.

---

## 👥 MANAJEMEN DOSEN

### Q31: Bagaimana cara membuat akun dosen baru?
**A:** 
1. Masuk menu "Dosen"
2. Klik "+ Tambah Dosen"
3. Isi username, password, nama, NIDN, email
4. Simpan

### Q32: Apakah dosen bisa ganti password sendiri?
**A:** Saat ini belum ada fitur ganti password. Hubungi Kaprodi atau admin untuk reset.

### Q33: Apa saja yang bisa dilakukan dosen di sistem?
**A:** Dosen bisa:
- ✅ Melihat jadwal mereka sendiri
- ✅ Melakukan charter jadwal kosong
- ✅ Mengajukan barter jadwal dengan dosen lain
- ✅ Melihat STM mereka

### Q34: Apakah dosen bisa membuat jadwal sendiri?
**A:** Tidak. Hanya Kaprodi yang bisa membuat jadwal.

---

## 📊 LAPORAN & MONITORING

### Q35: Bagaimana cara melihat jadwal per kelas?
**A:** Di menu "Jadwal", gunakan filter atau search untuk mencari kelas tertentu.

### Q36: Bagaimana cara melihat jadwal per dosen?
**A:** Di menu "Jadwal", gunakan filter STM atau search nama dosen.

### Q37: Apakah ada dashboard statistik?
**A:** Ya, di halaman Dashboard Kaprodi ada ringkasan jumlah mata kuliah, ruangan, kelas, dosen, dan jadwal.

### Q38: Bagaimana cara cetak jadwal seluruh prodi?
**A:** Saat ini belum ada fitur cetak otomatis. Bisa screenshot atau print halaman jadwal.

---

## 🚨 ERROR MESSAGES

### Q39: Error: "STM not found"
**A:** Anda mencoba buat jadwal tanpa STM. Buat STM terlebih dahulu.

### Q40: Error: "Jadwal bentrok"
**A:** Ada konflik dengan jadwal lain (ruangan/dosen/kelas sama di waktu sama). Ubah waktu atau ruangan.

### Q41: Error: "Validation failed"
**A:** Ada field yang tidak valid. Cek pesan error detail di form.

### Q42: Error: "Unauthorized"
**A:** Anda tidak punya akses untuk action tersebut. Pastikan login sebagai Kaprodi.

---

## 💡 TIPS & TRICKS

### Q43: Tips agar penjadwalan lebih efisien?
**A:**
- ✅ Siapkan semua data master di awal semester
- ✅ Buat template jadwal dari semester sebelumnya
- ✅ Koordinasi dengan dosen sebelum finalisasi
- ✅ Gunakan spreadsheet untuk planning sebelum input ke sistem
- ✅ Buat jadwal bertahap (per angkatan/prodi)

### Q44: Berapa lama waktu yang dibutuhkan untuk setup sistem?
**A:**
- Setup data master (pertama kali): ~2 jam
- Buat STM & jadwal per semester: ~4-6 jam
- Maintenance & update: ~1-2 jam per minggu

### Q45: Apakah ada shortcut keyboard?
**A:** Saat ini belum ada shortcut khusus. Gunakan navigasi menu normal.

---

## 🔮 FITUR MENDATANG

### Q46: Apakah akan ada fitur notifikasi?
**A:** Dalam planning untuk versi berikutnya.

### Q47: Apakah akan ada mobile app?
**A:** Saat ini belum dalam roadmap. Sistem responsive untuk mobile browser.

### Q48: Apakah akan ada fitur export Excel?
**A:** Ya, sedang dalam development untuk versi mendatang.

---

## 📞 KONTAK & DUKUNGAN

### Q49: Siapa yang bisa saya hubungi jika ada masalah?
**A:**
- IT Support: support@university.ac.id
- Admin Sistem: admin@university.ac.id
- WhatsApp: +62 xxx-xxxx-xxxx

### Q50: Bagaimana cara melaporkan bug?
**A:**
1. Screenshot error message
2. Catat langkah-langkah yang menyebabkan error
3. Email ke IT Support dengan detail lengkap

---

**Last Updated**: 23 Oktober 2025  
**Version**: 1.0  
**Feedback**: Jika ada pertanyaan yang belum terjawab, silakan hubungi tim support.

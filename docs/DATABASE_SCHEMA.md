role
├── id (PK)
├── nama
└── FK → user

status
├── id (PK)
├── nama
└── FK → user, prodi, mata_kuliah, ruangan, shift, angkatan, semester, kelas, surat_tugas_mengajar, jadwal, barter_jadwal, pindah_jadwal

user
├── id (PK)
├── nama
├── username
├── password
├── role_id (FK → role.id)
├── status_id (FK → status.id)
└── FK → surat_tugas_mengajar, barter_jadwal (dosen_pengaju, dosen_tujuan), pindah_jadwal (kosma_id)

prodi
├── id (PK)
├── nama
├── kode
├── status_id (FK → status.id)
└── FK → mata_kuliah, kelas

angkatan
├── id (PK)
├── tahun
├── status_id (FK → status.id)
└── FK → kelas

semester
├── id (PK)
├── kode_semester
├── tipe
├── status_id (FK → status.id)
└── FK → kelas, surat_tugas_mengajar

shift
├── id (PK)
├── nama
├── jam_mulai
├── jam_selesai
├── status_id (FK → status.id)
└── FK → kelas, jadwal

mata_kuliah
├── id (PK)
├── nama
├── kode
├── sks
├── prodi_id (FK → prodi.id)
├── status_id (FK → status.id)
└── FK → surat_tugas_mengajar

ruangan
├── id (PK)
├── nama
├── kapasitas
├── status_id (FK → status.id)
└── FK → jadwal

kelas
├── id (PK)
├── nama
├── angkatan_id (FK → angkatan.id)
├── prodi_id (FK → prodi.id)
├── semester_id (FK → semester.id)
├── shift_id (FK → shift.id)
├── status_id (FK → status.id)
└── FK → surat_tugas_mengajar

biodata
├── id (PK)
├── user_id (FK → user.id)
├── nip
├── nik
├── alamat
├── nomor_telepon
├── tempat_lahir
├── tanggal_lahir
├── gender
└── agama

surat_tugas_mengajar
├── id (PK)
├── dosen_id (FK → user.id)
├── mata_kuliah_id (FK → mata_kuliah.id)
├── kelas_id (FK → kelas.id)
├── semester_id (FK → semester.id)
├── status_id (FK → status.id)
└── FK → jadwal, barter_jadwal

jadwal
├── id (PK)
├── surat_tugas_mengajar_id (FK → surat_tugas_mengajar.id)
├── ruangan_id (FK → ruangan.id)
├── shift_id (FK → shift.id)
├── hari
├── jam_mulai
├── jam_selesai
├── status_id (FK → status.id)
└── FK → barter_jadwal, pindah_jadwal

barter_jadwal
├── id (PK)
├── jadwal_dosen_a_id (FK → jadwal.id)
├── jadwal_dosen_b_id (FK → jadwal.id)
├── dosen_pengaju_id (FK → user.id)
├── dosen_tujuan_id (FK → user.id)
├── status_id (FK → status.id)
└── alasan

pindah_jadwal
├── id (PK)
├── jadwal_id (FK → jadwal.id)
├── dosen_id (FK → user.id)
├── alasan
├── kosma_id (FK → user.id)
└── status_id (FK → status.id)
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugasMengajar extends Model
{
    protected $table = 'surat_tugas_mengajar';

    protected $fillable = [
        'dosen_id',
        'mata_kuliah_id',
        'kelas_id',
        'semester_id',
        'status_id',
        'nomor_surat'
    ];

    // Relations
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'surat_tugas_mengajar_id');
    }
}


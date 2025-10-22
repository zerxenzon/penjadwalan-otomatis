<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugasMengajar extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas_mengajar';

    protected $fillable = [
        'dosen_id',
        'mata_kuliah_id',
        'kelas_id',
        'semester_id',
        'status_id',
        'catatan',
        'nomor_surat',
    ];

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
        return $this->hasMany(Jadwal::class, 'surat_tugas_mengajar_id');
    }

    public function barterJadwal()
    {
        return $this->hasManyThrough(BarterJadwal::class, Jadwal::class, 'surat_tugas_mengajar_id', 'jadwal_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'surat_tugas_mengajar_id',
        'ruangan_id',
        'shift_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status_id',
    ];

    protected $casts = [
        'jam_mulai' => 'time',
        'jam_selesai' => 'time',
    ];

    public function suratTugasMengajar()
    {
        return $this->belongsTo(SuratTugasMengajar::class, 'surat_tugas_mengajar_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function barterJadwalA()
    {
        return $this->hasMany(BarterJadwal::class, 'jadwal_dosen_a_id');
    }

    public function barterJadwalB()
    {
        return $this->hasMany(BarterJadwal::class, 'jadwal_dosen_b_id');
    }

    public function pindahJadwal()
    {
        return $this->hasMany(PindahJadwal::class, 'jadwal_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $fillable = [
        'nama',
        'keterangan',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'status_id');
    }

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'status_id');
    }

    public function mataKuliah()
    {
        return $this->hasMany(MataKuliah::class, 'status_id');
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'status_id');
    }

    public function shift()
    {
        return $this->hasMany(Shift::class, 'status_id');
    }

    public function angkatan()
    {
        return $this->hasMany(Angkatan::class, 'status_id');
    }

    public function semester()
    {
        return $this->hasMany(Semester::class, 'status_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'status_id');
    }

    public function suratTugasMengajar()
    {
        return $this->hasMany(SuratTugasMengajar::class, 'status_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'status_id');
    }

    public function barterJadwal()
    {
        return $this->hasMany(BarterJadwal::class, 'status_id');
    }

    public function pindahJadwal()
    {
        return $this->hasMany(PindahJadwal::class, 'status_id');
    }
}

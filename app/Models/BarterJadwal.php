<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarterJadwal extends Model
{
    use HasFactory;

    protected $table = 'barter_jadwal';

    protected $fillable = [
        'jadwal_dosen_a_id',
        'jadwal_dosen_b_id',
        'dosen_pengaju_id',
        'dosen_tujuan_id',
        'status_id',
        'alasan',
    ];

    public function jadwalA()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_dosen_a_id');
    }

    public function jadwalB()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_dosen_b_id');
    }

    public function dosenPengaju()
    {
        return $this->belongsTo(User::class, 'dosen_pengaju_id');
    }

    public function dosenTujuan()
    {
        return $this->belongsTo(User::class, 'dosen_tujuan_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}

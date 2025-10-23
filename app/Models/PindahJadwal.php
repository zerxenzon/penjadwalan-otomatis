<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PindahJadwal extends Model
{
    use HasFactory;

    protected $table = 'pindah_jadwal';

    protected $fillable = [
        'jadwal_lama_id',
        'jadwal_baru_id',
        'dosen_id',
        'alasan',
        'kosma_id',
        'status_id',
        'catatan_kosma',
    ];

    // Relations
    public function jadwalLama()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_lama_id');
    }

    public function jadwalBaru()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_baru_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function kosma()
    {
        return $this->belongsTo(User::class, 'kosma_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
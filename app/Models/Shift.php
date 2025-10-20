<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shift';

    protected $fillable = [
        'nama',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'status_id',
    ];

    protected $casts = [
        'jam_mulai' => 'time',
        'jam_selesai' => 'time',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'shift_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'shift_id');
    }
}

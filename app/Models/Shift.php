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

    // Change these invalid 'time' casts to 'datetime'
    protected $casts = [
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
    ];

    // Add accessor methods to format the time
    public function getJamMulaiFormattedAttribute()
    {
        return $this->jam_mulai ? $this->jam_mulai->format('H:i') : '';
    }

    public function getJamSelesaiFormattedAttribute()
    {
        return $this->jam_selesai ? $this->jam_selesai->format('H:i') : '';
    }

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

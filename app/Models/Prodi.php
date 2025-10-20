<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function mataKuliah()
    {
        return $this->hasMany(MataKuliah::class, 'prodi_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'prodi_id');
    }
}

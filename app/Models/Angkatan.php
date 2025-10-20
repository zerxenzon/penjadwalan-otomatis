<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    use HasFactory;

    protected $table = 'angkatan';

    protected $fillable = [
        'tahun',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'angkatan_id');
    }
}

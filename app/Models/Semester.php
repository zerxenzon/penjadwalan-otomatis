<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';

    protected $fillable = [
        'kode_semester',
        'tipe',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'semester_id');
    }

    public function suratTugasMengajar()
    {
        return $this->hasMany(SuratTugasMengajar::class, 'semester_id');
    }
}

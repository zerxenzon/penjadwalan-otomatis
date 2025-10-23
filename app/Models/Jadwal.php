<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'surat_tugas_mengajar_id',
        'ruangan_id',
        'shift_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status_id'
    ];

    // PERBAIKAN: Set cast untuk jam dengan format yang konsisten
    protected $casts = [
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
    ];

    // PERBAIKAN: Tambahkan eager loading untuk relasi
    protected $with = ['ruangan', 'shift', 'status'];

    // Relations
    public function suratTugasMengajar()
    {
        // PERBAIKAN: Hapus eager loading yang tidak perlu di sini
        return $this->belongsTo(SuratTugasMengajar::class, 'surat_tugas_mengajar_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Scope to get available slots
    public function scopeAvailable($query)
    {
        return $query->whereNull('surat_tugas_mengajar_id');
    }

    // Scope to get chartered slots for a specific dosen
    public function scopeCharteredByDosen($query, $dosenId)
    {
        return $query->whereHas('suratTugasMengajar', function($q) use ($dosenId) {
            $q->where('dosen_id', $dosenId);
        });
    }
    
    // Utility method to check if this jadwal belongs to specified dosen
    public function belongsToDosen($dosenId)
    {
        return $this->suratTugasMengajar && $this->suratTugasMengajar->dosen_id == $dosenId;
    }
}

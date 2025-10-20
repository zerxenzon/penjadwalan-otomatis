<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role_id',
        'status_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function biodata()
    {
        return $this->hasOne(Biodata::class, 'user_id');
    }

    public function suratTugasMengajar()
    {
        return $this->hasMany(SuratTugasMengajar::class, 'dosen_id');
    }

    public function barterJadwalPengaju()
    {
        return $this->hasMany(BarterJadwal::class, 'dosen_pengaju_id');
    }

    public function barterJadwalTujuan()
    {
        return $this->hasMany(BarterJadwal::class, 'dosen_tujuan_id');
    }

    public function pindahJadwalDosen()
    {
        return $this->hasMany(PindahJadwal::class, 'dosen_id');
    }

    public function pindahJadwalKosma()
    {
        return $this->hasMany(PindahJadwal::class, 'kosma_id');
    }
}

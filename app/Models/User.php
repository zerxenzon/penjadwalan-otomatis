<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasRoleAndPermissions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoleAndPermissions;

    protected $table = 'user';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role_id',
        'status_id',
        'is_dekan', // tambahkan ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_dekan' => 'boolean', // tambahkan ini
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
        return $this->hasOne(Biodata::class, 'user_id', 'id');
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

        // === Role Checking Methods ===
        public function isDosen()
        {
            return $this->role && $this->role->nama === 'dosen';
        }

        public function isKosma()
        {
            return $this->role && $this->role->nama === 'kosma';
        }

        public function isDekan()
        {
            return $this->role && $this->role->nama === 'dekan';
        }

        public function isKaprodiOrDekan()
        {
            return $this->role && in_array($this->role->nama, ['kaprodi', 'dekan']);
        }

        public function isKaprodiAndDekan(): bool
        {
            return $this->hasRole('kaprodi') && $this->is_dekan;
        }
}

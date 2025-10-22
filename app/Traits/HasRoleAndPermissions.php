<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoleAndPermissions
{
    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        return $this->role?->nama === $role;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole($roles)
    {
        return in_array($this->role?->nama, (array) $roles);
    }

    /**
     * Check if user is Kaprodi or Dekan
     */
    public function isKaprodiOrDekan()
    {
        return $this->hasAnyRole(['kaprodi', 'dekan']);
    }

    /**
     * Check if user is Dekan
     */
    public function isDekan()
    {
        return $this->hasRole('dekan');
    }

    /**
     * Check if user is Dosen
     */
    public function isDosen()
    {
        return $this->hasRole('dosen');
    }

    /**
     * Check if user is KOSMA (Ketua Grup Kelas Mahasiswa)
     */
    public function isKosma()
    {
        return $this->hasRole('kosma');
    }
}
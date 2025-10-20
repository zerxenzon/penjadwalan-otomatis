<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RoleHelper
{
    /**
     * Cek apakah user adalah dekan
     */
    public static function isDekan(): bool
    {
        $user = Auth::user();
        return $user !== null && ($user->role->nama ?? null) === 'dekan';
    }

    /**
     * Cek apakah user adalah kaprodi
     */
    public static function isKaprodi(): bool
    {
        $user = Auth::user();
        return $user !== null && ($user->role->nama ?? null) === 'kaprodi';
    }

    /**
     * Cek apakah user adalah dosen
     */
    public static function isDosen(): bool
    {
        $user = Auth::user();
        return $user !== null && ($user->role->nama ?? null) === 'dosen';
    }

    /**
     * Cek apakah user adalah KOSMA
     */
    public static function isKosma(): bool
    {
        $user = Auth::user();
        return $user !== null && ($user->role->nama ?? null) === 'kosma';
    }

    /**
     * Cek apakah user adalah mahasiswa
     */
    public static function isMahasiswa(): bool
    {
        $user = Auth::user();
        return $user !== null && ($user->role->nama ?? null) === 'mahasiswa';
    }

    /**
     * Cek apakah user adalah sekprodi
     */
    public static function isSekprodi(): bool
    {
        $user = Auth::user();
        return $user !== null && ($user->role->nama ?? null) === 'sekprodi';
    }

    /**
     * Ambil nama role user
     */
    public static function getRoleName(): ?string
    {
        $user = Auth::user();
        return $user ? ($user->role->nama ?? 'unknown') : null;
    }

    /**
     * Ambil user saat ini dengan relasi lengkap
     *
     * @return User|null
     */
    public static function getUserWithRelations(): ?User
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user ? $user->load('role', 'status', 'biodata') : null;
    }
}


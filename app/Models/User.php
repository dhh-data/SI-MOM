<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'nim', 'no_hp', 'angkatan',
        'jabatan', 'role', 'departemen_id', 'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function peminjamanInventaris()
    {
        return $this->hasMany(PeminjamanInventaris::class, 'peminjam_id');
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class, 'uploaded_by');
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKepalaDepartemen(): bool
    {
        return in_array($this->role, ['kepala_departemen', 'kepala_inventaris']);
    }

    public function isKepalaInventaris(): bool
    {
        return $this->role === 'kepala_inventaris';
    }

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }

    public function canApproveInventaris(): bool
    {
        return $this->isAdmin() || $this->isKepalaInventaris();
    }

    public function canManageInventaris(): bool
    {
        return $this->isAdmin() || $this->isKepalaInventaris();
    }

    public function canAjukanPeminjaman(): bool
    {
        return $this->isAdmin() || $this->isKepalaDepartemen();
    }

    public function getRoleLabel(): string
    {
        return match($this->role) {
            'admin' => 'Admin Utama',
            'kepala_departemen' => 'Kepala Departemen',
            'kepala_inventaris' => 'Kepala Dep. Inventaris',
            'anggota' => 'Anggota / Staff',
            default => 'Anggota',
        };
    }

    public function getRoleBadgeClass(): string
    {
        return match($this->role) {
            'admin' => 'bg-purple-100 text-purple-700',
            'kepala_departemen' => 'bg-blue-100 text-blue-700',
            'kepala_inventaris' => 'bg-orange-100 text-orange-700',
            'anggota' => 'bg-gray-100 text-gray-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $fillable = ['nama_departemen', 'deskripsi', 'icon'];

    public function anggota()
    {
        return $this->hasMany(User::class);
    }

    public function programKerja()
    {
        return $this->hasMany(ProgramKerja::class);
    }

    public function kepalaDepartemen()
    {
        return $this->hasOne(User::class)->whereIn('role', ['kepala_departemen', 'kepala_inventaris']);
    }

    public function getJumlahAnggota(): int
    {
        return $this->anggota()->count();
    }

    public function getProgressProker(): array
    {
        $total = $this->programKerja()->count();
        $selesai = $this->programKerja()->where('status', 'Selesai')->count();
        return [
            'selesai' => $selesai,
            'total' => $total,
            'persen' => $total > 0 ? round(($selesai / $total) * 100) : 0,
        ];
    }
}

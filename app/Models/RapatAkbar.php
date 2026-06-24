<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapatAkbar extends Model
{
    protected $fillable = [
        'nama_rapat', 'tanggal', 'waktu', 'lokasi', 'agenda', 'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function notulensi()
    {
        return $this->hasOne(NotulensiRapat::class);
    }

    public function dokumentasi()
    {
        return $this->hasMany(DokumentasiRapat::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'Dijadwalkan' => 'bg-blue-100 text-blue-700',
            'Berlangsung' => 'bg-green-100 text-green-700',
            'Selesai' => 'bg-gray-100 text-gray-700',
            'Dibatalkan' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getJumlahHadir(): int
    {
        return $this->presensis()->where('status', 'Hadir')->count();
    }

    public function getJumlahIzin(): int
    {
        return $this->presensis()->where('status', 'Izin')->count();
    }

    public function getJumlahTidakHadir(): int
    {
        return $this->presensis()->where('status', 'Tidak Hadir')->count();
    }
}

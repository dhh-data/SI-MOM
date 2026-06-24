<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = ['rapat_akbar_id', 'user_id', 'status', 'keterangan'];

    public function rapat()
    {
        return $this->belongsTo(RapatAkbar::class, 'rapat_akbar_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'Hadir' => 'bg-green-100 text-green-700',
            'Izin' => 'bg-yellow-100 text-yellow-700',
            'Tidak Hadir' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $fillable = [
        'nama_barang', 'kategori', 'jumlah',
        'kondisi', 'lokasi_penyimpanan', 'status', 'keterangan',
    ];

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanInventaris::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'Tersedia' => 'bg-green-100 text-green-700',
            'Dipinjam' => 'bg-yellow-100 text-yellow-700',
            'Maintenance' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getKondisiBadgeClass(): string
    {
        return match($this->kondisi) {
            'Baik' => 'bg-green-100 text-green-700',
            'Rusak Ringan' => 'bg-yellow-100 text-yellow-700',
            'Rusak Berat' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getKategoriIcon(): string
    {
        return match($this->kategori) {
            'Elektronik' => '💻',
            'Perlengkapan' => '🔧',
            'Dokumentasi' => '📄',
            'ATK' => '✏️',
            default => '📦',
        };
    }
}

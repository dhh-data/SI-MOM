<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanInventaris extends Model
{
    protected $fillable = [
        'peminjam_id', 'departemen_id', 'inventaris_id',
        'jumlah', 'tanggal_pinjam', 'tanggal_kembali',
        'alasan', 'status_pengajuan', 'approved_by',
        'catatan_approval', 'approved_at',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'approved_at' => 'datetime',
    ];

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status_pengajuan) {
            'Pending' => 'bg-yellow-100 text-yellow-700',
            'Approved' => 'bg-green-100 text-green-700',
            'Rejected' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }
}

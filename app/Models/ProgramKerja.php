<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $fillable = [
        'nama_proker', 'departemen_id', 'pic',
        'tanggal_mulai', 'tanggal_selesai',
        'deskripsi', 'status', 'progress',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'Perencanaan' => 'badge-warning',
            'Berjalan' => 'badge-info',
            'Selesai' => 'badge-success',
            default => 'badge-secondary',
        };
    }

    public function getProgressBarClass(): string
    {
        if ($this->progress >= 80) return 'bg-green-500';
        if ($this->progress >= 50) return 'bg-blue-500';
        if ($this->progress >= 25) return 'bg-yellow-500';
        return 'bg-red-500';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotulensiRapat extends Model
{
    protected $fillable = [
        'rapat_akbar_id', 'judul_notulensi', 'isi_notulensi', 'penulis_id', 'tanggal',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function rapat()
    {
        return $this->belongsTo(RapatAkbar::class, 'rapat_akbar_id');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}

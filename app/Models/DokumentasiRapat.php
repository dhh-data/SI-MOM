<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiRapat extends Model
{
    protected $fillable = ['rapat_akbar_id', 'jenis', 'file_path', 'nama_file', 'keterangan'];

    public function rapat()
    {
        return $this->belongsTo(RapatAkbar::class, 'rapat_akbar_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $fillable = [
        'judul_berkas', 'kategori', 'deskripsi',
        'file_path', 'nama_file', 'ukuran_file', 'uploaded_by',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getKategoriBadgeClass(): string
    {
        return match($this->kategori) {
            'Proposal' => 'bg-blue-100 text-blue-700',
            'LPJ' => 'bg-purple-100 text-purple-700',
            'Notulen' => 'bg-green-100 text-green-700',
            'Surat' => 'bg-orange-100 text-orange-700',
            'Dokumentasi' => 'bg-pink-100 text-pink-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getFileIcon(): string
    {
        $ext = strtolower(pathinfo($this->nama_file, PATHINFO_EXTENSION));
        return match($ext) {
            'pdf' => '📕',
            'doc', 'docx' => '📘',
            'xls', 'xlsx' => '📗',
            'ppt', 'pptx' => '📙',
            'jpg', 'jpeg', 'png' => '🖼️',
            'zip', 'rar' => '🗜️',
            default => '📄',
        };
    }
}

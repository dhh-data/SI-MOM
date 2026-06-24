<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->string('judul_berkas');
            $table->enum('kategori', ['Proposal', 'LPJ', 'Notulen', 'Surat', 'Dokumentasi']);
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->string('nama_file');
            $table->string('ukuran_file')->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};

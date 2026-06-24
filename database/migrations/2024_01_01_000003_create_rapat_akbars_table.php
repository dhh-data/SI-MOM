<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapat_akbars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rapat');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('lokasi');
            $table->text('agenda');
            $table->enum('status', ['Dijadwalkan', 'Berlangsung', 'Selesai', 'Dibatalkan'])->default('Dijadwalkan');
            $table->timestamps();
        });

        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapat_akbar_id')->constrained('rapat_akbars')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['Hadir', 'Izin', 'Tidak Hadir'])->default('Tidak Hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->unique(['rapat_akbar_id', 'user_id']);
        });

        Schema::create('notulensi_rapats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapat_akbar_id')->constrained('rapat_akbars')->cascadeOnDelete();
            $table->string('judul_notulensi');
            $table->longText('isi_notulensi');
            $table->foreignId('penulis_id')->constrained('users');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('dokumentasi_rapats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapat_akbar_id')->constrained('rapat_akbars')->cascadeOnDelete();
            $table->enum('jenis', ['foto', 'lampiran', 'hasil']);
            $table->string('file_path');
            $table->string('nama_file');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_rapats');
        Schema::dropIfExists('notulensi_rapats');
        Schema::dropIfExists('presensis');
        Schema::dropIfExists('rapat_akbars');
    }
};

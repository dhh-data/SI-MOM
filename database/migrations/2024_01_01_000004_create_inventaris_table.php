<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->enum('kategori', ['Elektronik', 'Perlengkapan', 'Dokumentasi', 'ATK', 'Lainnya']);
            $table->unsignedInteger('jumlah')->default(1);
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->string('lokasi_penyimpanan');
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Maintenance'])->default('Tersedia');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('peminjaman_inventaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjam_id')->constrained('users');
            $table->foreignId('departemen_id')->constrained('departemens');
            $table->foreignId('inventaris_id')->constrained('inventaris');
            $table->unsignedInteger('jumlah');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->text('alasan');
            $table->enum('status_pengajuan', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('catatan_approval')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_inventaris');
        Schema::dropIfExists('inventaris');
    }
};

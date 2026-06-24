<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proker');
            $table->foreignId('departemen_id')->constrained('departemens')->cascadeOnDelete();
            $table->string('pic');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Perencanaan', 'Berjalan', 'Selesai'])->default('Perencanaan');
            $table->unsignedTinyInteger('progress')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_kerjas');
    }
};

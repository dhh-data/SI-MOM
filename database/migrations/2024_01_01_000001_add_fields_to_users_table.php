<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('name');
            $table->string('no_hp')->nullable()->after('nim');
            $table->string('angkatan')->nullable()->after('no_hp');
            $table->enum('jabatan', ['Ketua Umum', 'Sekretaris', 'Kepala Departemen', 'Staff'])->default('Staff')->after('angkatan');
            $table->enum('role', ['admin', 'kepala_departemen', 'kepala_inventaris', 'anggota'])->default('anggota')->after('jabatan');
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->nullOnDelete()->after('role');
            $table->string('avatar')->nullable()->after('departemen_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'no_hp', 'angkatan', 'jabatan', 'role', 'departemen_id', 'avatar']);
        });
    }
};

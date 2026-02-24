<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Tambahkan kolom baru yang boleh kosong (nullable) pada awalnya
            $table->string('judul_ta')->nullable();
            $table->string('dosen_pembimbing')->nullable();
            $table->string('status_sidang')->default('Belum Daftar'); // Status awal
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['judul_ta', 'dosen_pembimbing', 'status_sidang']);
        });
    }
};
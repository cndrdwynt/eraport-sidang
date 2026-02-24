<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Hancurkan dulu tabel revisis versi lama yang strukturnya beda
        Schema::dropIfExists('revisis');

        // 2. Buat tabel revisis baru yang sesuai dengan Controller kita
        Schema::create('revisis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id'); // Dihubungkan ke Mahasiswa
            $table->text('catatan')->nullable(); // Catatan dosen
            $table->integer('status')->default(0); // 0 = Proses, 1 = Selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisis');
    }
};
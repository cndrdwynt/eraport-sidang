<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('revisis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('penilaian_id')->constrained()->onDelete('cascade'); // Terhubung ke mahasiswa
        $table->text('catatan'); // Isi revisinya apa
        $table->date('tanggal_bimbingan'); // Kapan bimbingannya
        $table->enum('status', ['pending', 'selesai'])->default('pending'); // Status per item
        $table->timestamps();
    });
}
};

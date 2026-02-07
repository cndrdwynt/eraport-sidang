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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa');
            $table->string('nrp');

            // KITA GANTI BAGIAN INI:
            // Dari kolom satu-satu menjadi satu kolom JSON (Data Fleksibel)
            $table->json('detail_penilaian'); 

            // Hasil Akhir tetap ada
            $table->integer('total_error');
            $table->integer('nilai_akhir');
            $table->string('predikat');
            $table->string('status');
            $table->text('catatan')->nullable();
            
            $table->timestamps();
        });
    }
};

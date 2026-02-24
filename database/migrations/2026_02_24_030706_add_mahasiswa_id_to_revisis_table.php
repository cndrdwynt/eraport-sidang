<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('revisis', function (Blueprint $table) {
            // Menambahkan kolom mahasiswa_id
            $table->unsignedBigInteger('mahasiswa_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('revisis', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn('mahasiswa_id');
        });
    }
};
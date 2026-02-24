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
        Schema::table('revisis', function (Blueprint $table) {
            $table->string('link_file')->nullable()->after('catatan');
            $table->text('balasan_mahasiswa')->nullable()->after('link_file');
        });
    }
    public function down(): void
    {
         Schema::table('revisis', function (Blueprint $table) {
            $table->dropColumn(['link_file', 'balasan_mahasiswa']);
        });
    }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dateTime('jadwal_sidang')->nullable()->after('ruangan_sempro');
            $table->string('ruangan_sidang')->nullable()->after('jadwal_sidang');
        });
    }
    public function down(): void {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['jadwal_sidang', 'ruangan_sidang']);
        });
    }
};
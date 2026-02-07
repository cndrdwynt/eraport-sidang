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
    Schema::table('penilaians', function (Blueprint $table) {
        // Kolom penanda pemilik data (Foreign Key)
        // Kita pakai nullable() dulu biar data lama gak error
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Hapus foreign key dulu, baru hapus kolomnya
            $table->dropForeign(['user_id']); 
            $table->dropColumn('user_id');
        });
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_mahasiswa',
        'nrp',
        'detail_penilaian',
        'total_error',      
        'nilai_akhir',
        'predikat',
        'status',
        'catatan',
        // Tambahan kolom revisi sederhana (kalau masih mau dipakai)
        'catatan_revisi',
        'status_revisi'
    ];

    protected $casts = [
        'detail_penilaian' => 'array',
    ];

    // --- RELASI KE TABEL REVISI (TRACKER) ---
    // (Harus di dalam class Penilaian)
    public function revisis()
    {
        return $this->hasMany(Revisi::class)->orderBy('tanggal_bimbingan', 'desc');
    }

} 
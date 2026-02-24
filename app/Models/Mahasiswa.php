<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable; 

class Mahasiswa extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\MahasiswaFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'nrp',
        'name',
        'email',
        'password',
        'judul_ta',
        'dosen_pembimbing',
        'status_sidang',
        // --- TAMBAHAN BARU: Izin untuk menyimpan Jadwal ---
        'jadwal_sempro',
        'ruangan_sempro',
        'jadwal_sidang',
        'ruangan_sidang'
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mengambil inisial nama (copy dari User.php)
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
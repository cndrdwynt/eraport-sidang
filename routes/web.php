<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevisiController; // <--- INI YANG KURANG!

/*
|--------------------------------------------------------------------------
| 1. JALUR TAMU (GUEST)
|--------------------------------------------------------------------------
| Bisa diakses oleh siapa saja tanpa login.
*/

Route::get('/', function () {
    return view('landing');
});

// --- FITUR LOGIN (DARI LANGKAH SEBELUMNYA) ---
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// --- FITUR REGISTER (YANG BARU KITA BUAT) ---
Route::get('/register', [RegisterController::class, 'index']); // Buka Form Daftar
Route::post('/register', [RegisterController::class, 'store']); // Simpan Data Daftar


/*
|--------------------------------------------------------------------------
| 2. JALUR KHUSUS DOSEN (PROTECTED)
|--------------------------------------------------------------------------
| Hanya bisa dibuka kalau user sudah Login.
| Kita bungkus pakai middleware 'auth'.
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/cetak/{id}', [PenilaianController::class, 'cetakPdf']);
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout']);

    // Dashboard Utama
    Route::get('/dashboard', [PenilaianController::class, 'index']);

    // CRUD Penilaian (Hanya bisa akses kalau login)
    Route::get('/tambah-nilai', function () { return view('form_nilai'); });
    Route::post('/simpan-data', [PenilaianController::class, 'store']);
    Route::get('/edit/{id}', [PenilaianController::class, 'edit']);
    Route::put('/update/{id}', [PenilaianController::class, 'update']);
    Route::get('/hapus/{id}', [PenilaianController::class, 'destroy']);
    
    // --- FITUR PROFIL ---
    Route::get('/profil', [ProfileController::class, 'index']);
    Route::put('/profil', [ProfileController::class, 'update']);

    // --- FITUR TRACKER REVISI ---
    Route::get('/tracker/{id}', [RevisiController::class, 'index']); // Buka Halaman
    Route::post('/tracker/{id}', [RevisiController::class, 'store']); // Simpan Catatan
    Route::get('/tracker/status/{id_revisi}', [RevisiController::class, 'updateStatus']); // Ganti Status Checkwlist
    Route::get('/tracker/hapus/{id_revisi}', [RevisiController::class, 'destroy']); // Hapus
});

// ... (Kode route login & dashboard di atas biarkan saja)

// --- AREA PUBLIK (BISA DIBUKA SIAPA SAJA TANPA LOGIN) ---
// Ini jalur khusus buat HP yang scan QR.
Route::get('/cek-validasi/{id}', [PenilaianController::class, 'halamanValidasi']);
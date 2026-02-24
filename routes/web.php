<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevisiController; 
use App\Http\Controllers\Mahasiswa\DashboardController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. AREA PUBLIK & VALIDASI (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
});

// Halaman Form untuk mengetik Kode ID (Verifikasi Manual)
Route::get('/cek-keaslian', function() {
    return view('mahasiswa.verifikasi_manual');
})->name('verifikasi.form');

// Proses pencarian Kode ID
Route::post('/cek-keaslian/proses', [DashboardController::class, 'prosesVerifikasi'])->name('verifikasi.proses');

// Halaman Hasil Validasi (Muncul kalau kode cocok)
Route::get('/cek-validasi/{id}', [PenilaianController::class, 'halamanValidasi'])->name('validasi.hasil');


/*
|--------------------------------------------------------------------------
| 2. JALUR DOSEN (Guard: web)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PenilaianController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profil', [ProfileController::class, 'index']);

    Route::get('/form-nilai', function(Request $request) {
        $prefillNrp = $request->query('nrp', '');
        $prefillNama = $request->query('nama', '');
        return view('form_nilai', compact('prefillNrp', 'prefillNama'));
    })->name('form_nilai.create');

    Route::post('/simpan-nilai', [PenilaianController::class, 'store'])->name('simpan_nilai');
    Route::get('/edit/{id}', [PenilaianController::class, 'edit'])->name('edit_nilai');
    Route::post('/update-nilai/{id}', [PenilaianController::class, 'update'])->name('update_nilai');
    Route::get('/hapus/{id}', [PenilaianController::class, 'destroy'])->name('hapus_nilai');
    Route::get('/cetak/{id}', [PenilaianController::class, 'cetakPdf'])->name('cetak_pdf');
    
    Route::get('/tracker/{id}', [RevisiController::class, 'index'])->name('tracker_revisi');
    Route::post('/acc-revisi/{id}', [RevisiController::class, 'accRevisi'])->name('acc_revisi');
    
    Route::post('/set-jadwal-sempro/{id}', [PenilaianController::class, 'setJadwalSempro'])->name('set_jadwal_sempro');
    Route::post('/set-jadwal-sidang/{id}', [PenilaianController::class, 'setJadwalSidangAkhir'])->name('set_jadwal_sidang');
});


/*
|--------------------------------------------------------------------------
| 3. JALUR MAHASISWA (Guard: mahasiswa)
|--------------------------------------------------------------------------
*/
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::middleware('guest:mahasiswa')->group(function () {
        Route::get('/login', [LoginController::class, 'showMahasiswaLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'mahasiswaLogin']);
        Route::get('/register', [RegisterController::class, 'showMahasiswaRegisterForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'storeMahasiswa']);
    });

    Route::middleware(['auth:mahasiswa'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/daftar-sidang', [DashboardController::class, 'createSidang'])->name('daftar_sidang');
        Route::post('/daftar-sidang', [DashboardController::class, 'storeSidang']);
        Route::get('/daftar-sempro', [DashboardController::class, 'createSempro'])->name('daftar_sempro');
        Route::post('/daftar-sempro', [DashboardController::class, 'storeSempro']);
        Route::post('/daftar-sidang-akhir', [DashboardController::class, 'storeSidangAkhir'])->name('store_sidang_akhir');
        Route::post('/logout', [LoginController::class, 'logoutMahasiswa'])->name('logout');

        Route::post('/kirim-revisi/{id}', [DashboardController::class, 'kirimProgressRevisi'])->name('kirim_revisi');
        
        // Rute Cetak PDF untuk Mahasiswa
        Route::get('/cetak-rapot', [DashboardController::class, 'cetakRapot'])->name('cetak_rapot');
    });
});
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa; // Pastikan Model Mahasiswa di-import

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIKA UNTUK DOSEN
    |--------------------------------------------------------------------------
    */

    // 1. Tampilkan Halaman Login Dosen
    public function index()
    {
        return view('login_dosen');
    }

    // 2. Proses Login Dosen (Menggunakan Email)
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah nih, Pak!',
        ])->onlyInput('email');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIKA UNTUK MAHASISWA
    |--------------------------------------------------------------------------
    */

    // 3. Tampilkan Halaman Login Mahasiswa
    public function showMahasiswaLoginForm()
    {
        return view('mahasiswa.login_mahasiswa');
    }

    // 4. Proses Login Mahasiswa (Menggunakan NRP)
    public function mahasiswaLogin(Request $request)
    {
        $request->validate([
            'nrp' => 'required',
            'password' => 'required', 
        ]);

        // Menggunakan Guard 'mahasiswa' dan kolom 'nrp'
        if (Auth::guard('mahasiswa')->attempt(['nrp' => $request->nrp, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return back()->withErrors([
            'nrp' => 'NRP atau password kamu salah, nih!',
        ])->onlyInput('nrp');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    // Logout Dosen
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Logout Mahasiswa
    public function logoutMahasiswa(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/mahasiswa/login');
    }
}
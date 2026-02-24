<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa; // Tambahkan ini juga
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 1. Tampilkan Form Dosen
    public function index()
    {
        return view('register');
    }

    // 2. Proses Simpan User Baru (Dosen)
    public function store(Request $request)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users', // Email gak boleh kembar
            'password' => 'required|min:5|confirmed'  // Password harus sama dgn konfirmasi
        ]);

        // Enkripsi Password biar aman
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan ke Database
        $user = User::create($validatedData);

        // Langsung Login-kan user tersebut (biar gak usah login ulang)
        Auth::login($user);

        // Lempar ke Dashboard
        return redirect('/dashboard')->with('sukses', 'Akun berhasil dibuat! Selamat Datang.');
    }

    // 3. Tampilkan Form Register Mahasiswa
    public function showMahasiswaRegisterForm()
    {
        return view('mahasiswa.register_mahasiswa');
    }

    // 4. Proses Simpan Mahasiswa Baru
    public function storeMahasiswa(Request $request)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'nrp' => 'required|unique:mahasiswas', // NRP tidak boleh kembar
            'name' => 'required|max:255',
            'email' => 'required|email|unique:mahasiswas', 
            'password' => 'required|min:5|confirmed' 
        ]);

        // Enkripsi Password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan ke Database (menggunakan model Mahasiswa)
        $mahasiswa = Mahasiswa::create($validatedData);

        // Langsung Login-kan mahasiswa tersebut (menggunakan guard mahasiswa)
        Auth::guard('mahasiswa')->login($mahasiswa);

        // Lempar ke Dashboard Mahasiswa
        return redirect()->route('mahasiswa.dashboard')->with('sukses', 'Akun berhasil dibuat! Selamat Datang.');
    }
}

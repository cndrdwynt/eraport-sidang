<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 1. Tampilkan Form
    public function index()
    {
        return view('register');
    }

    // 2. Proses Simpan User Baru
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
}
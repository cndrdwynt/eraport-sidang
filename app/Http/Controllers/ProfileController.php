<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // 1. Tampilkan Halaman Profil
    public function index()
    {
        return view('profil', [
            'user' => Auth::user()
        ]);
    }

    // 2. Proses Update Data
    public function update(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:6|confirmed', // Password opsional (nullable)
        ]);

        $user = User::find(Auth::id());

        // Update Data Dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek: Apakah user mengisi password baru?
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('sukses', 'Profil berhasil diperbarui!');
    }
}
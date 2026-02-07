<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Revisi;
use Illuminate\Support\Facades\Auth;

class RevisiController extends Controller
{
    // 1. Buka Halaman Tracker
    public function index($id)
    {
        // Ambil data mahasiswa beserta history revisinya
        $siswa = Penilaian::with('revisis')->where('user_id', Auth::id())->findOrFail($id);
        
        return view('tracker_revisi', compact('siswa'));
    }

    // 2. Tambah Catatan Baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required',
            'tanggal_bimbingan' => 'required|date',
        ]);

        Revisi::create([
            'penilaian_id' => $id,
            'catatan' => $request->catatan,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'status' => 'pending'
        ]);

        return back()->with('sukses', 'Catatan revisi ditambahkan!');
    }

    // 3. Update Status (Jadi Selesai/Belum)
    public function updateStatus($id)
    {
        $revisi = Revisi::findOrFail($id);
        // Toggle status: Kalau pending jadi selesai, kalau selesai jadi pending
        $revisi->status = ($revisi->status == 'pending') ? 'selesai' : 'pending';
        $revisi->save();

        return back()->with('sukses', 'Status diperbarui!');
    }
    
    // 4. Hapus Catatan
    public function destroy($id)
    {
        Revisi::findOrFail($id)->delete();
        return back()->with('sukses', 'Catatan dihapus.');
    }
}
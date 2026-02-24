<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RevisiController extends Controller
{
    // Menampilkan halaman tracker revisi ke Dosen
    public function index($id)
    {
        // Cari data penilaian
        $penilaian = Penilaian::where('user_id', Auth::id())->findOrFail($id);

        // Cari mahasiswa berdasarkan nrp di penilaian
        $mahasiswa = DB::table('mahasiswas')->where('nrp', $penilaian->nrp)->first();

        // Ambil revisis berdasarkan ID Mahasiswa (Bukan Penilaian)
        if ($mahasiswa) {
            $revisis = DB::table('revisis')
                         ->where('mahasiswa_id', $mahasiswa->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        } else {
            $revisis = collect([]); 
        }

        return view('tracker_revisi', compact('penilaian', 'revisis', 'mahasiswa'));
    }

    // Fungsi untuk mengubah status revisi jadi Selesai (ACC)
    public function accRevisi($id)
    {
        DB::table('revisis')->where('id', $id)->update([
            'status' => 1,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('sukses', 'Revisi berhasil di-ACC (Selesai).');
    }
}
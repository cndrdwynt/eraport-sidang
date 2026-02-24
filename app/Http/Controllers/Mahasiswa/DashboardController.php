<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $statusSidang = $mahasiswa->status_sidang ?? 'Belum Daftar';

        $currentStep = 0;
        if (str_contains($statusSidang, 'Tahap 1')) $currentStep = 1;
        elseif (str_contains($statusSidang, 'Tahap 2') || str_contains($statusSidang, 'Tahap 3')) $currentStep = 2; 
        elseif (str_contains($statusSidang, 'Tahap 4')) $currentStep = 4;
        elseif (str_contains($statusSidang, 'Tahap 5')) $currentStep = 5;
        elseif (str_contains($statusSidang, 'Lulus') || str_contains($statusSidang, 'Tahap 6')) $currentStep = 6;

        try {
            $list_revisi = DB::table('revisis')->where('mahasiswa_id', $mahasiswa->id)->get();
            $sisaRevisi = $list_revisi->where('status', 0)->count();
        } catch (\Exception $e) {
            $list_revisi = collect([]); 
            $sisaRevisi = 0;
        }

        return view('mahasiswa.dashboard', compact(
            'mahasiswa', 'statusSidang', 'currentStep', 'list_revisi', 'sisaRevisi'
        ));
    }

    // ... (Fungsi storeSidang, storeSempro, dll tetap sama) ...
    
    public function storeSidang(Request $request) { /* kode kamu */ }
    public function storeSempro(Request $request) { /* kode kamu */ }
    public function kirimProgressRevisi(Request $request, $id) { /* kode kamu */ }
    public function storeSidangAkhir(Request $request) { /* kode kamu */ }

    /*
    |--------------------------------------------------------------------------
    | TAHAP 6: CETAK PDF (VERSI KODE UNIK - ANTI GAGAL)
    |--------------------------------------------------------------------------
    */
    public function cetakRapot(Request $request) 
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $penilaian = Penilaian::where('nrp', $mahasiswa->nrp)->latest()->first();

        if (!$penilaian) {
            return redirect()->back()->with('error', 'Data nilai belum ditemukan.');
        }

        // MEMBUAT KODE VERIFIKASI UNIK (10 Digit)
        $kodeVerifikasi = strtoupper(substr(md5($penilaian->id . 'ITS'), 0, 10));
        
        // Menggunakan link statis agar tidak NULL
        $linkWeb = $request->getSchemeAndHttpHost() . '/cek-keaslian';

        $pdf = Pdf::loadView('rapot_pdf', compact('penilaian', 'mahasiswa', 'kodeVerifikasi', 'linkWeb'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('E-Rapot_'.$mahasiswa->nrp.'.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIKA PROSES CEK KODE ID (DIPANGGIL DARI HALAMAN CEK-KEASLIAN)
    |--------------------------------------------------------------------------
    */
    public function prosesVerifikasi(Request $request)
    {
        $kodeInput = strtoupper($request->kode_id);
        
        // Ambil semua data penilaian untuk dicocokkan kodenya
        $penilaian = Penilaian::all()->filter(function($p) use ($kodeInput) {
            return strtoupper(substr(md5($p->id . 'ITS'), 0, 10)) === $kodeInput;
        })->first();

        if ($penilaian) {
            // Jika kode cocok, lempar ke halaman validasi yang sudah ada datanya
            return redirect('/cek-validasi/' . $penilaian->id);
        }

        return redirect()->back()->with('error', 'Kode ID salah atau dokumen tidak terdaftar!');
    }
}
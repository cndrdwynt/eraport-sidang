<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF

class PenilaianController extends Controller
{
    // 1. Tampilkan Dashboard (Dengan Search + Statistik + Pagination + GRAFIK)
    public function index(Request $request)
    {
        // A. QUERY DASAR (Punya User Login)
        $query = Penilaian::where('user_id', Auth::id());

        // B. HITUNG STATISTIK KARTU
        // Kita clone query-nya biar statistik tetap menghitung SEMUA data
        $totalSiswa = (clone $query)->count();
        $totalLulus = (clone $query)->where('status', 'LULUS')->count();
        $totalRemidi = (clone $query)->where('status', '!=', 'LULUS')->count();

        // --- C. HITUNG DATA UNTUK CHART (PENTING! JANGAN DIHAPUS) ---
        $sebaranPredikat = (clone $query)
            ->select('predikat', \DB::raw('count(*) as total'))
            ->groupBy('predikat')
            ->pluck('total', 'predikat')
            ->toArray();

        $chartData = [
            'A'  => $sebaranPredikat['A'] ?? 0,
            'AB' => $sebaranPredikat['AB'] ?? 0,
            'B'  => $sebaranPredikat['B'] ?? 0,
            'BC' => $sebaranPredikat['BC'] ?? 0,
            'C'  => $sebaranPredikat['C'] ?? 0,
            'D'  => $sebaranPredikat['D'] ?? 0,
            'E'  => $sebaranPredikat['E'] ?? 0,
        ];
        // -----------------------------------------------------------

        // D. LOGIKA PENCARIAN
        if ($request->has('cari')) {
            $keyword = $request->cari;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_mahasiswa', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('nrp', 'LIKE', '%'.$keyword.'%');
            });
        }

        // E. AMBIL DATA (Pagination)
        $dataSiswa = $query->latest()->paginate(10)->withQueryString();
        
        // F. KIRIM SEMUA KE VIEW (Termasuk chartData)
        return view('dashboard', compact(
            'dataSiswa', 
            'totalSiswa', 
            'totalLulus', 
            'totalRemidi', 
            'chartData' // <--- INI WAJIB ADA BIAR GRAFIK MUNCUL
        ));
    }

    // 2. Tampilkan Form Edit
    public function edit($id)
    {
        $penilaian = Penilaian::where('user_id', Auth::id())->findOrFail($id);
        return view('form_nilai', compact('penilaian'));
    }

    // 3. Hapus Data
    public function destroy($id)
    {
        $penilaian = Penilaian::where('user_id', Auth::id())->findOrFail($id);
        $penilaian->delete();
        return redirect('/dashboard')->with('sukses', 'Data berhasil dihapus!');
    }

    // 4. Simpan Data BARU
    public function store(Request $request)
    {
        return $this->simpanAtauUpdate($request);
    }

    // 5. Simpan Data EDIT
    public function update(Request $request, $id)
    {
        return $this->simpanAtauUpdate($request, $id);
    }

    // 6. CETAK PDF (DENGAN QR CODE)
    public function cetakPdf($id)
    {
        // Ambil data (pakai keamanan user_id)
        $penilaian = Penilaian::where('user_id', Auth::id())->findOrFail($id);

        // Load View PDF
        $pdf = Pdf::loadView('rapot_pdf', compact('penilaian'));

        // --- PENTING: IZINKAN GAMBAR DARI INTERNET (QR CODE) ---
        $pdf->setOption(['isRemoteEnabled' => true]); 
        // -------------------------------------------------------

        // Download file otomatis
        return $pdf->download('Rapot-'.$penilaian->nrp.'.pdf');
    }

    // --- LOGIKA UTAMA (Private Function) ---
    private function simpanAtauUpdate($request, $id = null)
    {
        $rawData = $request->input('p'); 
        $detailData = [];
        $totalError = 0;

        if($rawData) {
            foreach($rawData as $paramID => $dataParam) {
                $namaParameter = $dataParam['judul'];
                $listSubAspek = [];

                if(isset($dataParam['subs'])) {
                    foreach($dataParam['subs'] as $sub) {
                        $poin = (int)($sub['error'] ?? 0); 
                        $totalError += $poin;
                        $namaSub = $sub['nama'] ?? '-';

                        $listSubAspek[] = [
                            'deskripsi' => $namaSub,
                            'error'     => $poin
                        ];
                    }
                }
                $detailData[] = [
                    'parameter' => $namaParameter,
                    'sub_aspek' => $listSubAspek
                ];
            }
        }

        $nilaiAkhir = 90 - $totalError;
        if($nilaiAkhir < 0) $nilaiAkhir = 0;

        $predikat = 'E'; $status = 'MENGULANG';
        if($nilaiAkhir >= 81) { $predikat = 'A'; $status = 'LULUS'; }
        elseif($nilaiAkhir >= 71) { $predikat = 'AB'; $status = 'LULUS'; }
        elseif($nilaiAkhir >= 66) { $predikat = 'B'; $status = 'LULUS'; }
        elseif($nilaiAkhir >= 56) { $predikat = 'C'; $status = 'LULUS'; }

        $dataToSave = [
            'user_id'        => Auth::id(),
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'nrp'            => $request->nrp,
            'detail_penilaian' => $detailData,
            'catatan'        => $request->catatan,
            'total_error'    => $totalError,
            'nilai_akhir'    => $nilaiAkhir,
            'predikat'       => $predikat,
            'status'         => $status,
        ];

        if($id) {
            Penilaian::where('id', $id)->where('user_id', Auth::id())->firstOrFail()->update($dataToSave);
            $pesan = 'Data Berhasil Diupdate!';
        } else {
            Penilaian::create($dataToSave);
            $pesan = 'Data Baru Berhasil Disimpan!';
        }

        return redirect('/dashboard')->with('sukses', $pesan);
    }
    
    // 8. HALAMAN VALIDASI (PUBLIC)
    public function halamanValidasi($id)
    {
        // Cari data (Jika ID ngawur, otomatis error 404 Not Found)
        $penilaian = Penilaian::findOrFail($id);
        
        // Panggil view 'validasi'
        return view('validasi', compact('penilaian'));
    }
}
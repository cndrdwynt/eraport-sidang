<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $query = Penilaian::where('user_id', Auth::id());

        // Statistik
        $totalSiswa = (clone $query)->count();
        $totalLulus = (clone $query)->where('status', 'LULUS')->count();
        $totalRemidi = (clone $query)->where('status', '!=', 'LULUS')->count();

        // Data Chart
        $sebaranPredikat = (clone $query)
            ->select('predikat', DB::raw('count(*) as total'))
            ->groupBy('predikat')
            ->pluck('total', 'predikat')
            ->toArray();

        $chartData = [
            'A'  => $sebaranPredikat['A'] ?? 0, 'AB' => $sebaranPredikat['AB'] ?? 0,
            'B'  => $sebaranPredikat['B'] ?? 0, 'BC' => $sebaranPredikat['BC'] ?? 0,
            'C'  => $sebaranPredikat['C'] ?? 0, 'D'  => $sebaranPredikat['D'] ?? 0,
            'E'  => $sebaranPredikat['E'] ?? 0,
        ];

        if ($request->has('cari')) {
            $keyword = $request->cari;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_mahasiswa', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('nrp', 'LIKE', '%'.$keyword.'%');
            });
        }

        $dataSiswa = $query->latest()->paginate(10)->withQueryString();
        $mahasiswaAktif = Mahasiswa::whereNotNull('judul_ta')->get();
        
        return view('dashboard', compact('dataSiswa', 'totalSiswa', 'totalLulus', 'totalRemidi', 'chartData', 'mahasiswaAktif'));
    }

    public function edit($id)
    {
        $penilaian = Penilaian::where('user_id', Auth::id())->findOrFail($id);
        return view('form_nilai', compact('penilaian'));
    }

    public function destroy($id)
    {
        Penilaian::where('user_id', Auth::id())->findOrFail($id)->delete();
        return redirect('/dashboard')->with('sukses', 'Data berhasil dihapus!');
    }

    public function store(Request $request)
    {
        return $this->simpanAtauUpdate($request);
    }

    public function update(Request $request, $id)
    {
        return $this->simpanAtauUpdate($request, $id);
    }

    public function cetakPdf($id)
{
    $penilaian = Penilaian::findOrFail($id);
    $mahasiswa = \App\Models\Mahasiswa::where('nrp', $penilaian->nrp)->first();

    // 1. Load View
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('rapot_pdf', compact('penilaian', 'mahasiswa'));

    // 2. BUKA PINTU INTERNET (Tanpa ini QR tidak akan muncul)
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOptions([
        'isRemoteEnabled' => true,
        'isHtml5ParserEnabled' => true,
        'isPhpEnabled' => true
    ]);

    return $pdf->download('E-Rapot-'.$penilaian->nrp.'.pdf');
}

    // --- LOGIKA UTAMA SINKRONISASI PENILAIAN ---
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
                        $listSubAspek[] = ['deskripsi' => $sub['nama'] ?? '-', 'error' => $poin];
                    }
                }
                $detailData[] = ['parameter' => $namaParameter, 'sub_aspek' => $listSubAspek];
            }
        }

        $nilaiAkhir = max(0, 90 - $totalError);
        $predikat = 'E'; $status = 'MENGULANG';
        if($nilaiAkhir >= 81) { $predikat = 'A'; $status = 'LULUS'; }
        elseif($nilaiAkhir >= 71) { $predikat = 'AB'; $status = 'LULUS'; }
        elseif($nilaiAkhir >= 66) { $predikat = 'B'; $status = 'LULUS'; }
        elseif($nilaiAkhir >= 56) { $predikat = 'C'; $status = 'LULUS'; }

        $dataToSave = [
            'user_id' => Auth::id(), 'nama_mahasiswa' => $request->nama_mahasiswa,
            'nrp' => $request->nrp, 'detail_penilaian' => $detailData,
            'catatan' => $request->catatan, 'total_error' => $totalError,
            'nilai_akhir' => $nilaiAkhir, 'predikat' => $predikat, 'status' => $status,
        ];

        DB::transaction(function() use ($id, $dataToSave, $request) {
            if($id) {
                Penilaian::where('id', $id)->where('user_id', Auth::id())->firstOrFail()->update($dataToSave);
            } else {
                Penilaian::create($dataToSave);
            }

            // CEK STATUS MAHASISWA SAAT DINILAI
            $mhs = Mahasiswa::where('nrp', $request->nrp)->first();
            if($mhs) {
                if(str_contains($mhs->status_sidang, 'Tahap 5')) {
                    // Jika dinilai saat Tahap 5 (Sidang Akhir), maka dia LULUS
                    $mhs->update(['status_sidang' => 'Lulus']);
                } else {
                    // Jika dinilai saat Sempro (Tahap 2/3), maka dia masuk Tahap 4: Revisi
                    $mhs->update(['status_sidang' => 'Tahap 4: Revisi']);
                    DB::table('revisis')->insert([
                        'mahasiswa_id' => $mhs->id,
                        'catatan'      => $request->catatan ?? 'Silakan revisi sesuai arahan dosen.',
                        'status'       => 0,
                        'created_at'   => now(), 'updated_at' => now(),
                    ]);
                }
            }
        });

        return redirect('/dashboard')->with('sukses', 'Penilaian berhasil disimpan!');
    }

    public function halamanValidasi($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        return view('validasi', compact('penilaian'));
    }

    // ====================================================================
    // FUNGSI PENJADWALAN OLEH DOSEN (HANYA SET JADWAL, TIDAK LULUS)
    // ====================================================================
    
    // Jadwal Sempro
    public function setJadwalSempro(Request $request, $id_mahasiswa)
    {
        $request->validate(['jadwal_sempro' => 'required|date', 'ruangan_sempro' => 'required|string']);
        Mahasiswa::findOrFail($id_mahasiswa)->update([
            'jadwal_sempro' => $request->jadwal_sempro,
            'ruangan_sempro' => $request->ruangan_sempro,
            'status_sidang' => 'Tahap 2: Menunggu Sidang Sempro', // Status update
        ]);
        return redirect()->back()->with('sukses', 'Jadwal Sempro berhasil ditetapkan!');
    }

    // Jadwal Sidang Akhir
    public function setJadwalSidangAkhir(Request $request, $id_mahasiswa)
    {
        $request->validate(['jadwal_sidang' => 'required|date', 'ruangan_sidang' => 'required|string']);
        Mahasiswa::findOrFail($id_mahasiswa)->update([
            'jadwal_sidang' => $request->jadwal_sidang,
            'ruangan_sidang' => $request->ruangan_sidang,
            'status_sidang' => 'Tahap 5: Menunggu Sidang Akhir', // Status update
        ]);
        return redirect()->back()->with('sukses', 'Jadwal Sidang Akhir berhasil ditetapkan!');
    }
}
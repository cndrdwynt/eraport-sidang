<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tracker Revisi - Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; color: #444; }
        .navbar-custom { background: linear-gradient(to right, #141E30, #243B55); padding: 15px 0; }
        .card-modern { background: #fff; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-5">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/dashboard"><i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard</a>
  </div>
</nav>

<div class="container pb-5">

    @if(session('sukses'))
    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show rounded-4 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- HEADER INFO MAHASISWA --}}
    <div class="card card-modern p-4 mb-4 border-start border-5 border-primary">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="text-muted small text-uppercase fw-bold mb-1"><i class="bi bi-person-bounding-box me-2"></i>Tracker Revisi Mahasiswa</p>
                <h3 class="fw-bold text-dark mb-2">{{ $penilaian->nama_mahasiswa }}</h3>
                <div class="d-flex gap-3 text-secondary small">
                    <span><i class="bi bi-credit-card-2-front me-1"></i> NRP: {{ $penilaian->nrp }}</span>
                    <span>
                        <i class="bi bi-activity me-1"></i> Status: 
                        <strong class="text-primary">{{ $mahasiswa ? $mahasiswa->status_sidang : 'Tidak Diketahui' }}</strong>
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="bg-light p-3 rounded-4 d-inline-block text-center border">
                    <p class="small text-muted mb-0">Nilai Akhir</p>
                    <h2 class="fw-bold text-primary m-0">{{ $penilaian->nilai_akhir }} <span class="fs-5 text-dark">({{ $penilaian->predikat }})</span></h2>
                </div>
            </div>
        </div>
    </div>

    {{-- DAFTAR REVISI & ACC --}}
    <div class="card card-modern p-4 mb-4">
        <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-list-check me-2 text-warning"></i>Daftar Catatan Revisi Anda</h5>

        @forelse($revisis as $index => $revisi)
            <div class="card border mb-3 rounded-4 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark m-0">Revisi #{{ $index + 1 }}</h6>
                    @if($revisi->status == 1)
                        <span class="badge bg-success rounded-pill px-3"><i class="bi bi-check2-all me-1"></i> Selesai (ACC)</span>
                    @else
                        <span class="badge bg-warning text-dark rounded-pill px-3"><i class="bi bi-hourglass-split me-1"></i> Menunggu ACC</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Catatan Dosen --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <p class="small text-muted fw-bold mb-1">Catatan Anda:</p>
                                <p class="mb-0 text-dark">{{ $revisi->catatan }}</p>
                            </div>
                        </div>
                        
                        {{-- Balasan Mahasiswa --}}
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 h-100 {{ $revisi->balasan_mahasiswa ? 'border-primary bg-primary bg-opacity-10' : 'border-dashed text-muted' }}">
                                <p class="small text-muted fw-bold mb-1">Balasan Mahasiswa:</p>
                                @if($revisi->balasan_mahasiswa)
                                    <p class="mb-2 text-dark">{{ $revisi->balasan_mahasiswa }}</p>
                                    @if($revisi->link_file)
                                        <a href="{{ $revisi->link_file }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill mb-3">
                                            <i class="bi bi-box-arrow-up-right me-1"></i> Buka File Revisi
                                        </a>
                                    @endif
                                    
                                    {{-- Tombol ACC Dosen --}}
                                    @if($revisi->status == 0)
                                        <form action="{{ route('acc_revisi', $revisi->id) }}" method="POST" class="mt-2 border-top border-primary pt-3">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 fw-bold shadow-sm" onclick="return confirm('Yakin ingin menyetujui revisi ini?')">
                                                <i class="bi bi-check-circle-fill me-1"></i> Setujui & Tandai Selesai (ACC)
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <p class="mb-0 small"><i class="bi bi-clock-history me-1"></i> Mahasiswa belum mengirimkan balasan/progress.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <p class="text-muted">Tidak ada catatan revisi untuk mahasiswa ini.</p>
            </div>
        @endforelse
    </div>

    {{-- KOTAK PENJADWALAN SIDANG AKHIR (Muncul jika mahasiswa sudah di Tahap 5) --}}
    @if($mahasiswa && str_contains($mahasiswa->status_sidang, 'Tahap 5'))
        <div class="card card-modern p-4 border-0 shadow-lg" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
            <div class="row align-items-center">
                <div class="col-md-7 mb-3 mb-md-0">
                    <h4 class="fw-bold mb-1"><i class="bi bi-calendar-check-fill me-2"></i>Jadwalkan Sidang Akhir</h4>
                    <p class="mb-0 opacity-75">Mahasiswa ini telah mendaftar Sidang Akhir. Silakan tentukan waktu dan ruangannya.</p>
                </div>
                <div class="col-md-5 bg-white p-3 rounded-4 shadow-sm text-dark">
                    <form action="{{ route('set_jadwal_sidang', $mahasiswa->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Tanggal & Waktu Sidang</label>
                            <input type="datetime-local" name="jadwal_sidang" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Ruangan</label>
                            <input type="text" name="ruangan_sidang" class="form-control form-control-sm" placeholder="Contoh: Ruang Sidang 1" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill fw-bold">
                            <i class="bi bi-send-fill me-1"></i> Tetapkan Jadwal Sidang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @elseif($mahasiswa && str_contains($mahasiswa->status_sidang, 'Lulus'))
        <div class="card card-modern p-4 text-center border-0 bg-success bg-opacity-10 text-success">
            <h4 class="fw-bold m-0"><i class="bi bi-patch-check-fill me-2"></i>Mahasiswa Ini Telah Lulus</h4>
            <p class="m-0 mt-2 text-dark">
                Jadwal Sidang Akhir: <strong>{{ $mahasiswa->jadwal_sidang ? \Carbon\Carbon::parse($mahasiswa->jadwal_sidang)->format('d M Y, H:i') : '-' }}</strong> | 
                Ruangan: <strong>{{ $mahasiswa->ruangan_sidang ?? '-' }}</strong>
            </p>
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
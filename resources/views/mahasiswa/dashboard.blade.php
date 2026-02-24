<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Mahasiswa - E-Rapot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .navbar { background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        
        .stepper-wrapper { font-family: Arial, Helvetica, sans-serif; margin-top: 30px; display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stepper-item { position: relative; display: flex; flex-direction: column; align-items: center; flex: 1; }
        .stepper-item::before { position: absolute; content: ""; border-bottom: 2px solid #ccc; width: 100%; top: 20px; left: -50%; z-index: 2; }
        .stepper-item::after { position: absolute; content: ""; border-bottom: 2px solid #ccc; width: 100%; top: 20px; left: 50%; z-index: 2; }
        .stepper-item .step-counter { position: relative; z-index: 5; display: flex; justify-content: center; align-items: center; width: 40px; height: 40px; border-radius: 50%; background: #ccc; margin-bottom: 6px; color: white; font-weight: bold; transition: all 0.3s ease; }
        
        .stepper-item.completed .step-counter { background-color: #198754; } 
        .stepper-item.completed::after { border-bottom-color: #198754; }
        .stepper-item.completed::before { border-bottom-color: #198754; }
        .stepper-item.active .step-counter { background-color: #0ea5e9; box-shadow: 0 0 0 5px rgba(14,165,233,0.2); } 
        
        .stepper-item:first-child::before { content: none; }
        .stepper-item:last-child::after { content: none; }
        .step-name { font-size: 11px; font-weight: bold; text-align: center; color: #6c757d; text-transform: uppercase; }
        .stepper-item.active .step-name { color: #0ea5e9; }
        .stepper-item.completed .step-name { color: #198754; }

        .card { border: none; border-radius: 20px; transition: transform 0.2s; }
        .accordion-button:not(.collapsed) { background-color: #f8f9fa; color: #000; box-shadow: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#"><i class="bi bi-mortarboard-fill me-2"></i>Portal Mahasiswa</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 fw-medium text-secondary">{{ $mahasiswa->name }}</span>
            <form action="{{ route('mahasiswa.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Keluar</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5">
    
    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 bg-success text-white shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(empty($mahasiswa->judul_ta))
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border border-warning border-opacity-50 mt-4">
            <i class="bi bi-file-earmark-text text-warning" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">Mulai Perjalanan Tugas Akhirmu</h4>
            <p class="text-muted">Daftarkan Judul dan Dosen Pembimbing untuk mengaktifkan Tracker Kelulusan.</p>
            <a href="{{ route('mahasiswa.daftar_sidang') }}" class="btn btn-primary btn-lg mt-2 px-4 rounded-pill">Daftar Sekarang</a>
        </div>
    @else
        
        <div class="card shadow-sm rounded-4 border-0 mb-4 p-4 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 bg-primary text-white px-4 py-1 fw-bold" style="border-bottom-left-radius: 15px;">Aktif</div>
            <p class="text-muted mb-1 small text-uppercase fw-bold"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Informasi Tugas Akhir</p>
            <h4 class="fw-bold text-dark mb-3">{{ $mahasiswa->judul_ta }}</h4>
            <div class="d-flex gap-3 text-secondary small">
                <span><i class="bi bi-person-badge me-1"></i> NRP: <strong>{{ $mahasiswa->nrp }}</strong></span>
                <span><i class="bi bi-person-check me-1"></i> Pembimbing: <strong>{{ $mahasiswa->dosen_pembimbing }}</strong></span>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 border-0 mb-4 p-4">
            <h5 class="fw-bold mb-4 text-center">Progress Kelulusan Anda</h5>
            <div class="stepper-wrapper">
                <div class="stepper-item {{ $currentStep > 1 ? 'completed' : ($currentStep == 1 ? 'active' : '') }}">
                    <div class="step-counter">1</div><div class="step-name">Bimbingan</div>
                </div>
                <div class="stepper-item {{ $currentStep > 2 ? 'completed' : ($currentStep == 2 ? 'active' : '') }}">
                    <div class="step-counter">2</div><div class="step-name">Sempro</div>
                </div>
                <div class="stepper-item {{ $currentStep > 3 ? 'completed' : ($currentStep == 3 ? 'active' : '') }}">
                    <div class="step-counter">3</div><div class="step-name">Penilaian</div>
                </div>
                <div class="stepper-item {{ $currentStep > 4 ? 'completed' : ($currentStep == 4 ? 'active' : '') }}">
                    <div class="step-counter">4</div><div class="step-name">Revisi</div>
                </div>
                <div class="stepper-item {{ $currentStep > 5 ? 'completed' : ($currentStep == 5 ? 'active' : '') }}">
                    <div class="step-counter">5</div><div class="step-name">Sidang</div>
                </div>
                <div class="stepper-item {{ $currentStep == 6 ? 'completed' : '' }}">
                    <div class="step-counter">6</div><div class="step-name">Lulus</div>
                </div>
            </div>
            <div class="text-center mt-3">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Status: <strong>{{ $statusSidang }}</strong></span>
            </div>
        </div>

        {{-- INFO JADWAL (MUNCUL JIKA ADA JADWAL) --}}
        @if($mahasiswa->jadwal_sempro || $mahasiswa->jadwal_sidang)
        <div class="row mb-4 g-3">
            @if($mahasiswa->jadwal_sempro)
            <div class="col-md-6">
                <div class="card bg-info bg-opacity-10 border-info border-start border-4 p-3 h-100">
                    <p class="small text-info fw-bold mb-1"><i class="bi bi-calendar-event me-1"></i> Jadwal Sempro</p>
                    <h6 class="fw-bold">{{ \Carbon\Carbon::parse($mahasiswa->jadwal_sempro)->format('d M Y, H:i') }}</h6>
                    <span class="small text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $mahasiswa->ruangan_sempro }}</span>
                </div>
            </div>
            @endif
            
            @if($mahasiswa->jadwal_sidang)
            <div class="col-md-6">
                <div class="card bg-success bg-opacity-10 border-success border-start border-4 p-3 h-100">
                    <p class="small text-success fw-bold mb-1"><i class="bi bi-calendar-check me-1"></i> Jadwal Sidang Akhir</p>
                    <h6 class="fw-bold">{{ \Carbon\Carbon::parse($mahasiswa->jadwal_sidang)->format('d M Y, H:i') }}</h6>
                    <span class="small text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $mahasiswa->ruangan_sidang }}</span>
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- KOTAK REVISI --}}
        @if($currentStep >= 4 && $currentStep < 6)
        <div class="card shadow-sm rounded-4 border-0 mb-4 p-4 border-start border-5 border-warning">
            <h5 class="fw-bold mb-3"><i class="bi bi-list-check text-warning me-2"></i>Catatan Revisi Dosen</h5>
            @if(count($list_revisi) > 0)
                <div class="accordion" id="accordionRevisi">
                    @foreach($list_revisi as $index => $revisi)
                    <div class="accordion-item mb-3 border rounded-3">
                        <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#col{{$revisi->id}}">Revisi #{{ $index + 1 }}</button></h2>
                        <div id="col{{$revisi->id}}" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="alert alert-secondary mb-3"><h6 class="fw-bold mb-1">Catatan Penguji:</h6><p class="mb-0">{{ $revisi->catatan }}</p></div>
                                @if($revisi->status == 0)
                                    <form action="{{ route('mahasiswa.kirim_revisi', $revisi->id) }}" method="POST">
                                        @csrf
                                        <textarea name="balasan_mahasiswa" class="form-control mb-2" required placeholder="Keterangan perbaikan...">{{ $revisi->balasan_mahasiswa }}</textarea>
                                        <input type="url" name="link_file" class="form-control mb-2" value="{{ $revisi->link_file }}" placeholder="Link G-Drive (Opsional)">
                                        <button type="submit" class="btn btn-primary btn-sm rounded-pill">Kirim Progress</button>
                                    </form>
                                @else
                                    <div class="p-3 bg-light rounded-3 border"><h6 class="text-success fw-bold">Disetujui Dosen</h6><p class="mb-0">{{ $revisi->balasan_mahasiswa }}</p></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif

        {{-- LANGKAH BERIKUTNYA (LOGBOOK DIHAPUS, DIGANTI FULL KOTAK) --}}
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold fs-5 mb-3"><i class="bi bi-rocket-takeoff me-2 text-primary"></i>Langkah Berikutnya</h6>
            @if($currentStep == 1)
                <a href="{{ route('mahasiswa.daftar_sempro') }}" class="btn btn-primary btn-lg rounded-pill w-100">Daftar Sempro Sekarang</a>
            @elseif($currentStep == 2 || $currentStep == 3)
                <button class="btn btn-secondary btn-lg rounded-pill w-100" disabled>Menunggu Penilaian/Jadwal</button>
            @elseif($currentStep == 4)
                @if($sisaRevisi == 0)
                    <form action="{{ route('mahasiswa.store_sidang_akhir') }}" method="POST">
                        @csrf <button type="submit" class="btn btn-success btn-lg rounded-pill w-100">Daftar Sidang Akhir <i class="bi bi-arrow-right"></i></button>
                    </form>
                @else
                    <button class="btn btn-warning btn-lg rounded-pill w-100" disabled>Selesaikan Revisi Untuk Sidang</button>
                @endif
            @elseif($currentStep == 5)
                <button class="btn btn-info text-white btn-lg rounded-pill w-100" disabled>Menunggu Jadwal Sidang</button>
            @elseif($currentStep == 6)
                <div class="alert alert-success text-center rounded-4 py-4 mb-0">
                    <i class="bi bi-patch-check-fill text-success" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-2">Selamat! Anda Telah Lulus.</h4>
                    <p class="text-muted mb-4">Silakan unduh bukti E-Rapot Kelulusan Anda.</p>
                    <a href="{{ route('mahasiswa.cetak_rapot') }}" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm"><i class="bi bi-download me-2"></i> Unduh E-Rapot (PDF)</a>
                </div>
            @endif
        </div>

    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
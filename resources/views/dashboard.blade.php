<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen - E-Rapot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* 1. GLOBAL STYLE */
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; color: #444; }
        
        /* 2. NAVBAR & CARDS */
        .navbar-custom { background: linear-gradient(to right, #141E30, #243B55); padding: 15px 0; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; font-size: 1.3rem; }
        .card-modern { background: rgba(255, 255, 255, 0.95); border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); transition: transform 0.3s; }
        .card-modern:hover { transform: translateY(-5px); }
        
        /* 3. BUTTONS */
        .btn-gradient { background: linear-gradient(45deg, #11998e, #38ef7d); border: none; color: white; padding: 10px 25px; border-radius: 50px; font-weight: 600; box-shadow: 0 5px 15px rgba(56, 239, 125, 0.4); transition: all 0.3s ease; }
        .btn-gradient:hover { transform: scale(1.05); color: white; box-shadow: 0 8px 20px rgba(56, 239, 125, 0.6); }
        
        /* 4. TABLE */
        .table-custom thead { background-color: #f8f9fa; color: #6c757d; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; }
        .table-custom tbody tr { transition: background-color 0.2s; }
        .table-custom tbody tr:hover { background-color: #f1f3f5; }
        .badge-status { padding: 8px 15px; border-radius: 30px; font-weight: 500; }
        .search-input:focus { box-shadow: none; border-color: #11998e; }

        /* 5. DROPDOWN MENU */
        .dropdown-menu { border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 15px; }
        .dropdown-item { padding: 10px 20px; font-size: 0.9rem; transition: all 0.2s; }
        .dropdown-item:hover { background-color: #f8f9fa; transform: translateX(5px); }
        .dropdown-item:active { background-color: #e9ecef; color: #000; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-5">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="bi bi-mortarboard-fill me-2"></i> E-RAPOT <span class="fw-light">SYSTEM</span></a>
    
    <div class="d-flex align-items-center gap-2">
        <a href="/profil" class="text-white text-decoration-none me-3 d-none d-md-block fw-light" title="Edit Profil">
            <i class="bi bi-person-circle me-1"></i> Halo, <span class="fw-bold">{{ Auth::user()->name ?? 'Dosen' }}</span>
        </a>
        <form action="/logout" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-4">Logout <i class="bi bi-box-arrow-right ms-1"></i></button>
        </form>
    </div>
  </div>
</nav>

<div class="container pb-5">

    @if(session('sukses'))
    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show rounded-4 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- KOTAK STATISTIK --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #3a7bd5, #00d2ff); border-radius: 15px;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="display-4 me-3"><i class="bi bi-people-fill"></i></div>
                    <div><h6 class="text-white-50 text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Total Dinilai</h6><h2 class="fw-bold m-0">{{ $totalSiswa }}</h2></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #11998e, #38ef7d); border-radius: 15px;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="display-4 me-3"><i class="bi bi-trophy-fill"></i></div>
                    <div><h6 class="text-white-50 text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Lulus</h6><h2 class="fw-bold m-0">{{ $totalLulus }}</h2></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #ff416c, #ff4b2b); border-radius: 15px;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="display-4 me-3"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <div><h6 class="text-white-50 text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Mengulang</h6><h2 class="fw-bold m-0">{{ $totalRemidi }}</h2></div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARU: TABEL MAHASISWA AKTIF (SINKRON DARI PORTAL MAHASISWA) --}}
    <div class="card card-modern p-4 mb-4">
        <div class="row align-items-center mb-3 pb-3 border-bottom">
            <div class="col-12">
                <h4 class="fw-bold m-0 text-dark"><i class="bi bi-bell-fill text-warning me-2"></i>Daftar Mahasiswa Menunggu Penilaian</h4>
                <p class="text-muted small m-0 mt-1">Data mahasiswa yang mendaftar Sempro/Sidang dari portal mahasiswa.</p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-custom align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">NRP</th>
                        <th>Mahasiswa</th>
                        <th>Judul Tugas Akhir</th>
                        <th>Status</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($mahasiswaAktif) && $mahasiswaAktif->count() > 0)
                        @foreach($mahasiswaAktif as $mhs)
                        <tr>
                            <td class="ps-3 fw-bold text-secondary">{{ $mhs->nrp }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $mhs->name }}</div>
                            </td>
                            <td><span title="{{ $mhs->judul_ta }}">{{ Str::limit($mhs->judul_ta, 40) }}</span></td>
                            <td>
                                @php
                                    $bColor = 'bg-secondary';
                                    if(str_contains($mhs->status_sidang, 'Bimbingan')) $bColor = 'bg-info';
                                    elseif(str_contains($mhs->status_sidang, 'Sempro')) $bColor = 'bg-primary';
                                    elseif(str_contains($mhs->status_sidang, 'Revisi')) $bColor = 'bg-warning text-dark';
                                @endphp
                                <span class="badge {{ $bColor }} rounded-pill px-3 py-2">{{ $mhs->status_sidang }}</span>
                            </td>
                            <td class="text-center pe-3">
                                <a href="{{ route('form_nilai.create', ['nrp' => $mhs->nrp, 'nama' => $mhs->name]) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                    <i class="bi bi-pencil-square me-1"></i>Beri Nilai
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada mahasiswa yang mendaftar.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>


    {{-- TABEL RIWAYAT PENILAIAN LAMA (TIDAK ADA YANG DIUBAH) --}}
    <div class="card card-modern p-4">
        
        <div class="row align-items-center mb-4 pb-3 border-bottom">
            <div class="col-md-4">
                <h3 class="fw-bold m-0 text-dark">📊 Riwayat Penilaian</h3>
                <p class="text-muted small m-0 mt-1">Kelola data nilai yang sudah disubmit.</p>
            </div>
            <div class="col-md-8 d-flex justify-content-md-end mt-3 mt-md-0 gap-2">
                <form action="/dashboard" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="cari" class="form-control border-end-0 rounded-start-pill ps-3 search-input" placeholder="Cari Mahasiswa/NRP..." value="{{ request('cari') }}">
                        <button class="btn btn-white border border-start-0 rounded-end-pill bg-white text-muted" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                {{-- TOMBOL NILAI BARU MENGARAH KE ROUTE form_nilai.create --}}
                <a href="{{ route('form_nilai.create') }}" class="btn btn-gradient text-nowrap"><i class="bi bi-plus-lg me-1"></i> Nilai Bebas</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-custom align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Nilai Akhir</th>
                        <th>Predikat</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataSiswa as $siswa)
                    <tr>
                        <td class="ps-3 text-muted small">{{ $siswa->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $siswa->nama_mahasiswa }}</div>
                            <div class="small text-muted">{{ $siswa->nrp }}</div>
                        </td>
                        <td><h5 class="fw-bold text-primary m-0">{{ $siswa->nilai_akhir }}</h5></td>
                        <td><span class="fw-bold">{{ $siswa->predikat }}</span></td>
                        <td>
                            @if($siswa->status == 'LULUS')
                                <span class="badge bg-success bg-opacity-10 text-success badge-status"><i class="bi bi-check-circle me-1"></i> LULUS</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger badge-status"><i class="bi bi-x-circle me-1"></i> MENGULANG</span>
                            @endif
                        </td>
                        
                        <td class="text-end pe-3">
                            <div class="d-inline-flex align-items-center gap-1">
                                
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 35px; height: 35px;" title="Opsi Lainnya">
                                        <i class="bi bi-three-dots-vertical text-muted"></i>
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 overflow-hidden">
                                        <li>
                                            <a class="dropdown-item py-2" href="/edit/{{ $siswa->id }}">
                                                <i class="bi bi-pencil-square text-primary me-2"></i> Edit Data
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 d-flex justify-content-between align-items-center" href="/tracker/{{ $siswa->id }}">
                                                <span><i class="bi bi-clock-history text-warning me-2"></i> Tracker Revisi</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="/cetak/{{ $siswa->id }}" target="_blank">
                                                <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Cetak PDF
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <a href="/hapus/{{ $siswa->id }}" 
                                   class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" 
                                   onclick="return confirm('Yakin ingin menghapus data {{ $siswa->nama_mahasiswa }}? Data yang dihapus tidak bisa dikembalikan.')" 
                                   style="width: 35px; height: 35px; display:inline-flex; align-items:center; justify-content:center;" 
                                   title="Hapus Data">
                                    <i class="bi bi-trash-fill"></i>
                                </a>

                            </div>
                        </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" width="80" class="mb-3 opacity-50">
                            <h6 class="text-muted">Data tidak ditemukan / Belum ada penilaian.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 px-3">
            {{ $dataSiswa->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<div class="text-center mt-5 mb-4 text-muted small">&copy; 2026 Teknik Komputer ITS - E-Rapot System</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
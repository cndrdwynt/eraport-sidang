<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sempro - E-Rapot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-primary { background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%); border: none; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">Pendaftaran Seminar Proposal</h2>
                <p class="text-muted">Langkah kedua menuju kelulusan. Pastikan draft proposal Anda sudah siap.</p>
            </div>

            <div class="card p-4 p-md-5">
                <form action="{{ route('mahasiswa.daftar_sempro') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Tugas Akhir (Konfirmasi)</label>
                        <input type="text" class="form-control form-control-lg bg-light" value="{{ Auth::guard('mahasiswa')->user()->judul_ta }}" readonly>
                        <div class="form-text">Judul diambil otomatis dari pendaftaran awal.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Dosen Pembimbing</label>
                        <input type="text" class="form-control form-control-lg bg-light" value="{{ Auth::guard('mahasiswa')->user()->dosen_pembimbing }}" readonly>
                    </div>

                    <div class="alert alert-warning border-0 rounded-4 d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                        <div class="small">
                            Dengan mendaftar, Anda menyatakan telah menyelesaikan minimal <strong>4 kali bimbingan</strong> dan mendapatkan persetujuan untuk maju Seminar Proposal.
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-light w-100 rounded-pill py-2 fw-bold text-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                                Daftar Sempro <i class="bi bi-send-fill ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <p class="text-center text-muted mt-4 small">
                Sistem E-Rapot Mahasiswa &copy; 2026
            </p>
        </div>
    </div>
</div>

</body>
</html>
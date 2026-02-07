<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Data - ITS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card-verify { max-width: 450px; width: 100%; border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.08); overflow: hidden; }
        .top-accent { height: 6px; background: linear-gradient(90deg, #004d99, #00c6ff); }
        .status-valid { background-color: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 8px; text-align: center; font-weight: bold; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="card-body p-4 text-center">

    <div class="d-flex justify-content-center align-items-center gap-4 mb-3">
        <img src="{{ asset('img/logoits.png') }}" width="70" height="auto" alt="Logo ITS">

        <img src="{{ asset('img/logoce.png') }}" width="70" height="auto" alt="Logo Departemen">
    </div>    
            <h5 class="fw-bold mt-3 text-dark">E-RAPOT VERIFICATION</h5>
            <small class="text-muted">Institut Teknologi Sepuluh Nopember</small>

            <div class="status-valid"><i class="bi bi-patch-check-fill me-2"></i> DOKUMEN ASLI</div>

            <ul class="list-group list-group-flush text-start mb-4">
                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted small">Mahasiswa</span><span class="fw-bold">{{ $penilaian->nama_mahasiswa }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted small">NRP</span><span class="fw-bold">{{ $penilaian->nrp }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted small">Predikat</span><span class="fw-bold text-primary">{{ $penilaian->predikat }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted small">Status</span>
                    <span class="badge {{ $penilaian->status == 'LULUS' ? 'bg-success' : 'bg-danger' }}">{{ $penilaian->status }}</span>
                </li>
            </ul>
            <p class="small text-muted mb-0"><i class="bi bi-shield-lock"></i> Data valid dari server pusat.</p>
        </div>
    </div>
</body>
</html>
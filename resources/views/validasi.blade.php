<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi E-Rapot - ITS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .card-verify { max-width: 480px; width: 100%; border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.1); background: white; overflow: hidden; }
        .top-accent { height: 8px; background: linear-gradient(90deg, #004d99, #00c6ff); }
        .status-valid { background-color: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 12px; text-align: center; font-weight: bold; margin: 20px 0; border: 1px solid #c8e6c9; }
    </style>
</head>
<body>
    <div class="card-verify">
        <div class="top-accent"></div>
        <div class="card-body p-4 text-center">
            <h5 class="fw-bold mb-0" style="color: #004d99;">E-RAPOT VERIFICATION</h5>
            <small class="text-muted text-uppercase">Institut Teknologi Sepuluh Nopember</small>

            <div class="status-valid">
                <i class="bi bi-patch-check-fill me-2 fs-5"></i> DATA TERVERIFIKASI ASLI
            </div>

            <div class="text-start mt-4">
                <div class="mb-3 border-bottom pb-2">
                    <small class="text-muted d-block">Nama Mahasiswa</small>
                    <span class="fw-bold fs-5">{{ strtoupper($penilaian->nama_mahasiswa) }}</span>
                </div>
                <div class="mb-3 border-bottom pb-2">
                    <small class="text-muted d-block">NRP / NIM</small>
                    <span class="fw-bold">{{ $penilaian->nrp }}</span>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted d-block">Predikat</small>
                        <span class="fw-bold text-primary fs-4">{{ $penilaian->predikat }}</span>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge rounded-pill {{ $penilaian->status == 'LULUS' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                            {{ $penilaian->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="text-center pt-4 border-top mt-4">
                <p class="small text-muted mb-0"><i class="bi bi-shield-lock-fill text-primary"></i> Data valid dari Server Pusat.</p>
            </div>
        </div>
    </div>
</body>
</html>
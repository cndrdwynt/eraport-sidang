<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sidang - E-Rapot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h3 class="fw-bold text-primary mb-1">Form Pendaftaran Sidang</h3>
                <p class="text-muted mb-4">Lengkapi data tugas akhir Anda di bawah ini.</p>

                <form action="{{ route('mahasiswa.daftar_sidang') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Tugas Akhir</label>
                        <textarea name="judul_ta" class="form-control" rows="3" placeholder="Masukkan judul TA Anda..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Dosen Pembimbing</label>
                        <input type="text" name="dosen_pembimbing" class="form-control" placeholder="Nama lengkap beserta gelar" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan & Daftarkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
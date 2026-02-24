<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa - E-Rapot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #eef2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; padding: 20px; }
        .register-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-width: 500px; width: 100%; }
        .form-label { font-weight: bold; color: #333; font-size: 0.9rem; }
        .custom-input { background-color: #dbeafe; border: none; border-radius: 8px; padding: 10px 15px; color: #1e3a8a; }
        .custom-input:focus { background-color: #bfdbfe; box-shadow: none; outline: none; }
        .btn-register { background-color: #0ea5e9; color: white; font-weight: bold; padding: 12px; border-radius: 10px; border: none; width: 100%; margin-top: 15px; }
        .btn-register:hover { background-color: #0284c7; color: white; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="register-card">
        <h3 class="fw-bold mb-1 text-center text-primary">Portal Mahasiswa</h3>
        <p class="text-center text-muted mb-4">Buat akun untuk melihat nilai dan revisi</p>
        
        <form action="{{ route('mahasiswa.register') }}" method="POST">
            @csrf
            
            @if($errors->any())
            <div class="alert alert-danger py-2 small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label">NRP</label>
                <input type="text" name="nrp" class="form-control custom-input" placeholder="Masukkan NRP" value="{{ old('nrp') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control custom-input" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Aktif</label>
                <input type="email" name="email" class="form-control custom-input" placeholder="mahasiswa@its.ac.id" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control custom-input" placeholder="Minimal 5 karakter" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control custom-input" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn btn-register shadow">Daftar Sekarang</button>

            <div class="text-center mt-3">
                <small>Sudah punya akun? <a href="{{ route('mahasiswa.login') }}" class="fw-bold text-decoration-none" style="color: #0ea5e9;">Masuk di sini</a></small>
            </div>
        </form>
    </div>
</div>

</body>
</html>
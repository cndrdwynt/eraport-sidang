<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        .form-control {
            background-color: #f0f4f8;
            border: none;
            padding: 12px;
            margin-bottom: 15px;
        }
        .btn-register {
            background-color: #0ea5e9;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            border: none;
        }
        .btn-register:hover { background-color: #0284c7; color: white; }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center fw-bold mb-4">Daftar Akun Baru</h3>

    @if($errors->any())
        <div class="alert alert-danger text-small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf
        
        <label class="fw-bold small mb-1">Nama Lengkap</label>
        <input type="text" name="name" class="form-control" placeholder="Budi Santoso, S.Kom" required>

        <label class="fw-bold small mb-1">Email Kampus</label>
        <input type="email" name="email" class="form-control" placeholder="dosen@its.ac.id" required>

        <label class="fw-bold small mb-1">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>

        <label class="fw-bold small mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password" required>

        <button type="submit" class="btn-register shadow mt-3">Buat Akun</button>
    </form>

    <div class="text-center mt-3">
        <small>Sudah punya akun? <a href="/login" class="text-decoration-none fw-bold">Login disini</a></small>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-Rapot</title>
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
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .form-label { font-weight: bold; color: #333; }
        .custom-input {
            background-color: #dbeafe;
            border: none;
            border-radius: 8px;
            padding: 12px 15px;
            color: #1e3a8a;
            font-weight: 500;
        }
        .custom-input:focus { background-color: #bfdbfe; box-shadow: none; outline: none; }
        .btn-login {
            background-color: #0ea5e9;
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 10px;
            border: none;
            width: 100%;
            margin-top: 20px;
        }
        .btn-login:hover { background-color: #0284c7; color: white; }
        .illustration { width: 100%; max-width: 2000px; display: block; margin: auto; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-card">
        <div class="row align-items-center">
            
            <div class="col-md-6 p-5">
                <h2 class="fw-bold mb-4 text-center">Login Dosen</h2>
                
                <form action="/login" method="POST">
                    @csrf
                    
                    @if($errors->any())
                    <div class="alert alert-danger py-2 small mb-3">
                        {{ $errors->first() }}
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Email / NIP</label>
                        <input type="email" name="email" class="form-control custom-input" placeholder="dosen@its.ac.id" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control custom-input" placeholder="••••••••" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Tahun Pelajaran</label>
                        <select class="form-control custom-input form-select">
                            <option>2025/2026 - Ganjil</option>
                            <option>2025/2026 - Genap</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-login shadow">
                        Log in Masuk
                    </button>

                    <div class="text-center mt-3">
                        <small>Belum punya akun? <a href="/register" class="fw-bold text-decoration-none" style="color: #0ea5e9;">Daftar Sekarang</a></small>
                    </div>
                </form>
            </div> <div class="col-md-6 d-none d-md-block text-center bg-light p-5 rounded-end">
                <img src="{{ asset('img/tameng.png') }}" class="illustration" alt="Security Shield">
            </div>

        </div>
    </div>
</div>

</body>
</html>
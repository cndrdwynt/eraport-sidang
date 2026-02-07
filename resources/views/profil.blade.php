<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - E-Rapot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #444;
        }
        .navbar-custom {
            background: linear-gradient(to right, #141E30, #243B55);
            padding: 15px 0;
        }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; font-size: 1.3rem; }
        
        /* Card Style */
        .card-profile {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            max-width: 800px;
            margin: auto;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #11998e;
        }
        .btn-gradient {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: scale(1.05);
            color: white;
            box-shadow: 0 8px 20px rgba(56, 239, 125, 0.4);
        }
        .avatar-circle {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #3a7bd5, #00d2ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-5">
  <div class="container">
    <a class="navbar-brand" href="/dashboard"><i class="bi bi-mortarboard-fill me-2"></i> E-RAPOT</a>
    <div class="d-flex align-items-center">
        <a href="/dashboard" class="btn btn-outline-light btn-sm rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
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

    <div class="card card-profile p-5">
        
        <div class="text-center mb-4">
            <div class="avatar-circle shadow">
                <i class="bi bi-person"></i>
            </div>
            <h3 class="fw-bold">{{ $user->name }}</h3>
            <p class="text-muted">{{ $user->email }}</p>
        </div>

        <hr class="mb-4">

        <form action="/profil" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control p-3 bg-light border-0" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Email / NIP</label>
                    <input type="email" name="email" class="form-control p-3 bg-light border-0" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="col-12 mt-4">
                    <div class="alert alert-info border-0 bg-opacity-10 bg-info text-info small">
                        <i class="bi bi-info-circle me-1"></i> Kosongkan bagian password jika tidak ingin menggantinya.
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Password Baru</label>
                    <input type="password" name="password" class="form-control p-3 bg-light border-0" placeholder="Min. 6 Karakter">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control p-3 bg-light border-0" placeholder="Ulangi Password Baru">
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-gradient shadow-lg px-5">
                    <i class="bi bi-save me-2"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>

</body>
</html>
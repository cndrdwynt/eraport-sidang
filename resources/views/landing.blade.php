<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem E-Rapot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya Khusus agar terlihat Profesional */
        body { 
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); /* Warna Gelap Elegan */
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-card {
            background: rgba(255, 255, 255, 0.1); /* Efek Kaca (Glassmorphism) */
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            max-width: 600px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .btn-start {
            background-color: #00d2ff;
            background-image: linear-gradient(90deg, #00d2ff 0%, #3a7bd5 100%);
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            color: white;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .btn-start:hover {
            transform: scale(1.05); /* Efek membesar saat disentuh mouse */
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="hero-card mx-auto">
            <div class="mb-4">
                <img src="https://img.icons8.com/color/96/university.png" alt="Logo Kampus" width="80">
            </div>

            <h1 class="fw-bold mb-3">E-Rapot Sidang</h1>
            <p class="lead mb-4 text-white-50">
                Sistem Penilaian Sidang Akhir Mahasiswa.<br>
                Silakan masuk untuk memulai penilaian.
            </p>

            <hr class="border-white opacity-25 my-4">

            <p class="mb-4 small">Login sebagai: <strong>Dosen Penguji</strong></p>
            
            <a href="/login" class="btn btn-start shadow">
            Mulai Penilaian <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="text-center mt-4 text-white-50 small">
            &copy; 2026 Teknik Komputer - ITS
        </div>
    </div>

</body>
</html>
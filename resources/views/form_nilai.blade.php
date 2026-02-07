<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #444;
            padding-bottom: 50px;
        }
        
        /* Navbar */
        .navbar-custom { background: linear-gradient(to right, #141E30, #243B55); }

        /* Card Input */
        .card-input {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            background: white;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card-header-custom {
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 15px 25px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        /* Form Field */
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.3s;
        }
        .form-control:focus {
            background-color: white;
            border-color: #3a7bd5;
            box-shadow: 0 0 0 4px rgba(58, 123, 213, 0.1);
        }
        label { font-weight: 500; font-size: 0.9rem; margin-bottom: 5px; color: #64748b; }

        /* Tombol Aksi */
        .btn-add-param {
            border: 2px dashed #cbd5e1;
            color: #64748b;
            font-weight: 600;
            border-radius: 15px;
            transition: 0.3s;
        }
        .btn-add-param:hover {
            border-color: #3a7bd5;
            color: #3a7bd5;
            background: #f1f5f9;
        }

        .btn-save {
            background: linear-gradient(to right, #2b5876, #4e4376); /* Gradasi Biru-Ungu */
            border: none;
            color: white;
            font-weight: 600;
            padding: 15px;
            border-radius: 12px;
            font-size: 1.1rem;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(78, 67, 118, 0.3);
        }
        .btn-save:hover { transform: translateY(-2px); color: white; }

        /* Input Poin Error */
        .input-poin { 
            text-align: center; 
            font-weight: bold; 
            color: #ef4444; 
            background: #fef2f2 !important;
            border-color: #fee2e2 !important;
        }
        .input-poin:focus { border-color: #ef4444 !important; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark navbar-custom mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold fs-6" href="/dashboard">
        <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
    </a>
  </div>
</nav>

<div class="container">
    <form action="{{ isset($penilaian) ? '/update/'.$penilaian->id : '/simpan-data' }}" method="POST">
        @csrf 
        @if(isset($penilaian)) @method('PUT') @endif

        <div class="row">
            <div class="col-lg-8">
                
                <div class="card card-input">
                    <div class="card-header-custom"><i class="bi bi-person-badge me-2"></i> Identitas Mahasiswa</div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_mahasiswa" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ $penilaian->nama_mahasiswa ?? '' }}" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label>NRP</label>
                                <input type="text" name="nrp" class="form-control" placeholder="5024..." value="{{ $penilaian->nrp ?? '' }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="container_parameter"></div>

                <button type="button" class="btn btn-add-param w-100 py-3 mb-4" onclick="tambahParameter()">
                    <i class="bi bi-plus-circle-dotted fs-5 d-block mb-1"></i>
                    TAMBAH PARAMETER PENILAIAN BARU
                </button>
            </div>

            <div class="col-lg-4">
                <div class="card card-input position-sticky" style="top: 20px;">
                    <div class="card-header-custom bg-white border-0 pt-4 pb-0">
                        <h6 class="text-uppercase text-muted fw-bold small m-0">Ringkasan Nilai</h6>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <div class="text-center py-3">
                            <h1 class="display-2 fw-bold text-primary m-0" id="txt_nilai">90</h1>
                            <div id="badge_status_wrapper">
                                <span class="badge bg-success rounded-pill px-3 py-2 mt-2" id="badge_status">LULUS</span>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-3 mt-2">
                            <span class="text-muted">Nilai Awal</span>
                            <span class="fw-bold">90</span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                            <span class="text-danger"><i class="bi bi-dash-circle me-1"></i> Total Error</span>
                            <span class="fw-bold text-danger" id="txt_error">0</span>
                        </div>

                        <div class="mb-4">
                            <label>Catatan Dosen</label>
                            <textarea name="catatan" class="form-control" rows="4" placeholder="Berikan evaluasi...">{{ $penilaian->catatan ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-save w-100">
                            <i class="bi bi-save me-2"></i> {{ isset($penilaian) ? 'UPDATE NILAI' : 'SIMPAN NILAI' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let dataLama = @json($penilaian->detail_penilaian ?? null);

    window.onload = function() {
        if(dataLama) {
            dataLama.forEach(param => {
                let pid = tambahParameter(param.parameter);
                param.sub_aspek.forEach(sub => tambahSub(pid, sub.deskripsi, sub.error));
            });
        } else {
            let pid = tambahParameter();
            tambahSub(pid); 
        }
        hitung();
    };

    function tambahParameter(judulAwal = '') {
        let container = document.getElementById('container_parameter');
        let paramID = Date.now() + Math.floor(Math.random() * 1000);

        let cardHTML = `
        <div class="card card-input animate__animated animate__fadeIn" id="card_${paramID}">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input type="text" name="p[${paramID}][judul]" class="form-control fw-bold border-0 bg-transparent fs-5 ps-0 text-primary" 
                           style="box-shadow:none;" placeholder="Judul Parameter (Klik utk edit)" value="${judulAwal}" required>
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-circle bg-light" onclick="hapusCard('${paramID}')"><i class="bi bi-trash"></i></button>
                </div>
                <div class="bg-light rounded-3 p-3">
                    <table class="table table-borderless table-sm m-0 align-middle">
                        <tbody id="tbody_${paramID}"></tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-link text-decoration-none mt-2 ps-0 fw-bold" onclick="tambahSub('${paramID}')">
                        <i class="bi bi-plus"></i> Tambah Sub Aspek
                    </button>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', cardHTML);
        return paramID;
    }

    function tambahSub(paramID, namaAwal = '', errorAwal = 0) {
        let tbody = document.getElementById(`tbody_${paramID}`);
        let subID = Math.floor(Math.random() * 1000000); 

        let rowHTML = `
        <tr class="border-bottom border-light">
            <td class="ps-0"><input type="text" name="p[${paramID}][subs][${subID}][nama]" class="form-control form-control-sm bg-white" placeholder="Detail aspek..." value="${namaAwal}" required></td>
            <td style="width: 80px"><input type="number" name="p[${paramID}][subs][${subID}][error]" class="form-control form-control-sm input-poin" value="${errorAwal}" min="0" oninput="hitung()"></td>
            <td style="width: 30px" class="text-end pe-0"><i class="bi bi-x text-muted cursor-pointer" onclick="hapusBaris(this)" style="cursor:pointer"></i></td>
        </tr>`;
        tbody.insertAdjacentHTML('beforeend', rowHTML);
        hitung();
    }

    function hapusCard(id) { if(confirm('Hapus parameter ini?')) document.getElementById(`card_${id}`).remove(); hitung(); }
    function hapusBaris(btn) { btn.closest('tr').remove(); hitung(); }
    
    function hitung() {
        let total = 0;
        document.querySelectorAll('.input-poin').forEach(el => total += parseInt(el.value) || 0);
        
        let nilai = Math.max(0, 90 - total);
        let status = nilai >= 56 ? "LULUS" : "MENGULANG";
        let color = nilai >= 56 ? "bg-success" : "bg-danger";

        document.getElementById('txt_error').innerText = total;
        document.getElementById('txt_nilai').innerText = nilai;
        
        let badge = document.getElementById('badge_status');
        badge.innerText = status;
        badge.className = `badge ${color} rounded-pill px-3 py-2 mt-2`;
    }
</script>

</body>
</html>
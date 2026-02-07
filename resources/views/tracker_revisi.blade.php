<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tracker Revisi - {{ $siswa->nama_mahasiswa }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f5f7fa; color: #444; }
        .card-timeline { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        
        /* TIMELINE STYLE */
        .timeline-item { padding-left: 30px; position: relative; border-left: 2px solid #e0e0e0; padding-bottom: 30px; }
        .timeline-item::before {
            content: ''; position: absolute; left: -9px; top: 0; width: 16px; height: 16px;
            border-radius: 50%; background: white; border: 3px solid #ccc;
        }
        .timeline-item.done { border-left-color: #198754; }
        .timeline-item.done::before { border-color: #198754; background: #198754; }
        .timeline-item.pending::before { border-color: #ffc107; background: #fff; }

        .btn-check-custom:hover { transform: scale(1.1); }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">🚀 Tracker Revisi</h3>
            <p class="text-muted">{{ $siswa->nama_mahasiswa }} ({{ $siswa->nrp }})</p>
        </div>
        <a href="/dashboard" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card card-timeline p-4 bg-white sticky-top" style="top: 20px;">
                <h5 class="fw-bold mb-3">📝 Tambah Catatan</h5>
                <form action="/tracker/{{ $siswa->id }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted">Tanggal Bimbingan</label>
                        <input type="date" name="tanggal_bimbingan" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Isi Revisi</label>
                        <textarea name="catatan" rows="4" class="form-control" placeholder="Misal: Perbaiki Bab 4..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="bi bi-send-fill me-1"></i> Simpan Catatan
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-timeline p-4 bg-white">
                <h5 class="fw-bold mb-4">⏳ Riwayat Bimbingan</h5>
                
                @if($siswa->revisis->count() > 0)
                    <div class="timeline-box ps-2">
                        @foreach($siswa->revisis as $revisi)
                            <div class="timeline-item {{ $revisi->status == 'selesai' ? 'done' : 'pending' }}">
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-light text-dark border mb-2">
                                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($revisi->tanggal_bimbingan)->format('d F Y') }}
                                    </span>
                                    
                                    <a href="/tracker/hapus/{{ $revisi->id }}" onclick="return confirm('Hapus?')" class="text-muted small text-decoration-none"><i class="bi bi-trash"></i></a>
                                </div>

                                <div class="d-flex align-items-start bg-light p-3 rounded-3">
                                    <a href="/tracker/status/{{ $revisi->id }}" class="btn-check-custom text-decoration-none me-3 mt-1">
                                        @if($revisi->status == 'selesai')
                                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                        @else
                                            <i class="bi bi-circle text-muted fs-4"></i>
                                        @endif
                                    </a>
                                    
                                    <div>
                                        <p class="mb-1 {{ $revisi->status == 'selesai' ? 'text-decoration-line-through text-muted' : 'fw-bold text-dark' }}">
                                            {{ $revisi->catatan }}
                                        </p>
                                        <small class="text-muted">
                                            Status: 
                                            @if($revisi->status == 'selesai')
                                                <span class="text-success fw-bold">Selesai (ACC)</span>
                                            @else
                                                <span class="text-warning fw-bold">Belum Dikerjakan</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" width="80" class="opacity-50 mb-3">
                        <p class="text-muted">Belum ada riwayat revisi.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

</body>
</html>
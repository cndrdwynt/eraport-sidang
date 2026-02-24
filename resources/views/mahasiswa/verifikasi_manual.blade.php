<div class="container text-center" style="margin-top: 100px; max-width: 450px;">
    <img src="/img/logoits.png" width="80" class="mb-4">
    <h4 class="fw-bold">Verifikasi Dokumen E-Rapot</h4>
    <p class="text-muted small">Masukkan 10 digit Kode ID yang tertera pada dokumen PDF untuk mengecek validitas data.</p>
    
    <form action="{{ route('verifikasi.proses') }}" method="POST" class="mt-4">
        @csrf
        <input type="text" name="kode_id" class="form-control form-control-lg text-center fw-bold mb-3" placeholder="Contoh: A1B2C3D4E5" maxlength="10" required>
        <button type="submit" class="btn btn-primary w-100 py-2">VERIFIKASI SEKARANG</button>
    </form>
</div>
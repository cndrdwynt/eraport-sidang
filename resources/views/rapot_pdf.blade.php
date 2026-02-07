<!DOCTYPE html>
<html>
<head>
    <title>Rapor Penilaian - {{ $penilaian->nama_mahasiswa }}</title>
    <style type="text/css">
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header h2, .header h3 { margin: 0; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid black; padding: 8px; text-align: left; }
        table.data-table th { background-color: #f2f2f2; }
        
        .info-siswa td { padding: 5px 0; }
    </style>
</head>
<body>

    <div class="header">
        <h3>INSTITUT TEKNOLOGI SEPULUH NOPEMBER</h3>
        <h2>LEMBAR HASIL EVALUASI MAHASISWA</h2>
        <small>Kampus ITS Sukolilo, Surabaya 60111</small>
    </div>

    <table class="info-siswa" style="width: 100%; border: none;">
        <tr>
            <td width="150">Nama Mahasiswa</td>
            <td>: <strong>{{ $penilaian->nama_mahasiswa }}</strong></td>
        </tr>
        <tr>
            <td>NRP</td>
            <td>: {{ $penilaian->nrp }}</td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>: {{ date('d F Y') }}</td>
        </tr>
    </table>

    <h4 style="margin-top: 20px;">Detail Penilaian:</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th width="30" style="text-align: center;">No</th>
                <th>Parameter Penilaian</th>
                <th>Sub Aspek (Kesalahan)</th>
                <th width="80" style="text-align:center;">Poin Error</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($penilaian->detail_penilaian as $item)
                <tr>
                    <td style="text-align: center; vertical-align: top;">{{ $no++ }}</td>
                    <td style="vertical-align: top;"><strong>{{ $item['parameter'] }}</strong></td>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                        @foreach($item['sub_aspek'] as $sub)
                            <li>{{ $sub['deskripsi'] }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td style="text-align: center; vertical-align: top;">
                         @php 
                            $totalSub = 0;
                            foreach($item['sub_aspek'] as $s) $totalSub += $s['error'];
                         @endphp
                         {{ $totalSub }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; border: 1px solid black; padding: 10px;">
        <h3>Hasil Akhir:</h3>
        <table style="width: 100%;">
            <tr><td width="150">Total Error</td><td>: {{ $penilaian->total_error }} Poin</td></tr>
            <tr><td>Nilai Akhir</td><td>: <strong>{{ $penilaian->nilai_akhir }} / 100</strong></td></tr>
            <tr><td>Predikat</td><td>: <strong>{{ $penilaian->predikat }} ({{ $penilaian->status }})</strong></td></tr>
        </table>
    </div>

    @if($penilaian->catatan)
    <div style="margin-top: 15px; background: #eee; padding: 10px; font-style: italic;">
        <strong>Catatan Dosen:</strong> <br> "{{ $penilaian->catatan }}"
    </div>
    @endif

    <table style="width: 100%; margin-top: 50px; border: none;">
        <tr>
            <td style="width: 30%; text-align: center; vertical-align: top; border: none;">
                <?php 
                    $linkValidasi = trim(config('app.url')) . '/cek-validasi/' . $penilaian->id;
                    $qrImage = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($linkValidasi);
                ?>
                <img src="{{ $qrImage }}" width="80" height="80" style="display: block; margin: 0 auto;">
                <br>
                <span style="font-size: 10px; color: #555;">Scan untuk Validasi</span>
            </td>

            <td style="width: 30%; border: none;"></td>

            <td style="width: 40%; text-align: center; vertical-align: top; border: none;">
                <p style="margin-bottom: 60px;">Surabaya, {{ date('d F Y') }}</p>
                <p style="text-decoration: underline; font-weight: bold; margin-bottom: 5px;">{{ Auth::user()->name }}</p>
                <p style="margin: 0;">Dosen Pengampu</p>
            </td>
        </tr>
    </table>

</body>
</html>
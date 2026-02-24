<!DOCTYPE html>
<html>
<head>
    <title>Rapor Penilaian - {{ $penilaian->nama_mahasiswa }}</title>
    <style type="text/css">
        @page { margin: 1.5cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 3px double black; padding-bottom: 10px; }
        .header h3 { margin: 0; font-size: 14pt; color: #004d99; }
        .header h2 { margin: 5px 0; font-size: 16pt; text-transform: uppercase; }
        
        .info-siswa { width: 100%; margin-bottom: 20px; border: none; }
        .info-siswa td { padding: 4px 0; vertical-align: top; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th, .data-table td { border: 1px solid black; padding: 10px; text-align: left; }
        .data-table th { background-color: #f2f2f2; text-transform: uppercase; font-size: 10pt; }
        
        .result-box { margin-top: 20px; border: 2px solid black; padding: 15px; background-color: #f9f9f9; }

        .footer-table { width: 100%; margin-top: 40px; border: none; }
        .footer-table td { vertical-align: top; border: none; }

        /* Kotak Verifikasi ID Unik */
        .verify-box {
            border: 1px solid #000;
            padding: 10px;
            background-color: #fff;
            text-align: center;
        }
        .verify-id {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 2px;
            border: 1px dashed #333;
            padding: 5px;
            margin: 10px 0;
            display: block;
        }
    </style>
</head>
<body>

    <div class="header">
        <h3>INSTITUT TEKNOLOGI SEPULUH NOPEMBER</h3>
        <h2>LEMBAR HASIL EVALUASI TUGAS AKHIR</h2>
        <small>Kampus ITS Sukolilo, Surabaya 60111 | Departemen Teknik Komputer</small>
    </div>

    <table class="info-siswa">
        <tr>
            <td width="160">Nama Mahasiswa</td>
            <td>: <strong>{{ strtoupper($penilaian->nama_mahasiswa) }}</strong></td>
        </tr>
        <tr>
            <td>NRP</td>
            <td>: {{ $penilaian->nrp }}</td>
        </tr>
        <tr>
            <td>Dosen Pembimbing</td>
            <td>: {{ $mahasiswa->dosen_pembimbing ?? 'Belum Ditentukan' }}</td>
        </tr>
        <tr>
            <td>Judul Tugas Akhir</td>
            <td>: {{ $mahasiswa->judul_ta ?? '-' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">No</th>
                <th width="75%">Parameter Penilaian & Catatan</th>
                <th width="20%" style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penilaian->detail_penilaian as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item['parameter'] }}</strong><br>
                    <small>Catatan: {{ $penilaian->catatan ?? 'Terpenuhi dengan baik' }}</small>
                </td>
                <td align="center" style="font-weight: bold; color: green;">TERPENUHI</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="result-box">
        <table width="100%">
            <tr>
                <td>
                    <span style="font-size: 10pt;">Nilai Akhir / Predikat:</span><br>
                    <span style="font-size: 16pt; font-weight: bold;">{{ $penilaian->nilai_akhir }} / {{ $penilaian->predikat }}</span>
                </td>
                <td align="right">
                    <span style="font-size: 10pt;">Status Kelulusan:</span><br>
                    <span style="font-size: 16pt; font-weight: bold; color: green;">{{ strtoupper($penilaian->status) }}</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="footer-table">
        <tr>
            <td width="45%" style="text-align: left;">
                <div class="verify-box">
                    <strong style="font-size: 9pt;">VERIFIKASI DIGITAL</strong><br>
                    <span style="font-size: 8pt; color: #555;">Gunakan Kode ID di bawah untuk cek keaslian dokumen di sistem E-Rapot:</span>
                    
                    <span class="verify-id">
                        {{ strtoupper(substr(md5($penilaian->id . 'ITS'), 0, 10)) }}
                    </span>
                    
                    <span style="font-size: 8pt; color: #004d99;">
                        {{ request()->getSchemeAndHttpHost() }}/cek-keaslian
                    </span>
                </div>
            </td>

            <td width="15%"></td>

            <td width="40%" style="text-align: center;">
                <p>Surabaya, {{ date('d F Y') }}</p>
                <p>Dosen Pembimbing,</p>
                <div style="height: 60px;"></div>
                <p><strong>{{ $mahasiswa->dosen_pembimbing ?? '..........................' }}</strong></p>
                <p style="font-size: 8pt; margin-top: -10px;">Tanda Tangan Elektronik Sah</p>
            </td>
        </tr>
    </table>

</body>
</html>
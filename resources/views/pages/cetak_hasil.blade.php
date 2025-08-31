<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Deteksi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            border-bottom: 4px solid #0056b3;
        }

        .header img {
            position: absolute;
            left: 30px;
            top: 15px;
            height: 60px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .content {
            padding: 25px;
        }

        .content h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            color: #333;
            text-transform: uppercase;
            border-bottom: 2px solid #007BFF;
            display: inline-block;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 15px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
        }

        table th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #333;
            width: 35%;
        }

        table tr:nth-child(even) td {
            background-color: #fafafa;
        }

        table tr:hover td {
            background-color: #f0f8ff;
        }

        .hasil {
            font-weight: bold;
            color: #007BFF;
        }

        .usia-kategori {
            color: #555;
            font-style: italic;
            margin-left: 4px;
        }

        .footer {
            margin: 40px 25px 20px;
            text-align: right;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo.png') }}" alt="Logo">
        <h2>Sistem Deteksi Diabetes Mellitus</h2>
        <p>Laporan Hasil Deteksi</p>
    </div>

    <div class="content">
        <h3>Detail Pasien</h3>
        @if ($latest)
            @php
                $usia = $latest->usia;
                if ($usia < 18) {
                    $kategori = 'Anak-anak / Remaja';
                } elseif ($usia >= 18 && $usia <= 40) {
                    $kategori = 'Dewasa Awal';
                } elseif ($usia >= 41 && $usia <= 59) {
                    $kategori = 'Dewasa Akhir';
                } elseif ($usia >= 60 && $usia <= 74) {
                    $kategori = 'Lansia Awal';
                } elseif ($usia >= 75 && $usia <= 90) {
                    $kategori = 'Lansia Akhir';
                } else {
                    $kategori = 'Manula';
                }
            @endphp

            <table>
                <tr>
                    <th>Nama</th>
                    <td>{{ $latest->nama }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $latest->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th>Usia</th>
                    <td>
                        {{ $latest->usia }} tahun
                        <span class="usia-kategori">({{ $kategori }})</span>
                    </td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td>{{ $latest->telepon }}</td>
                </tr>
                <tr>
                    <th>Aktivitas</th>
                    <td>{{ $latest->aktivitas }}</td>
                </tr>
                <tr>
                    <th>Tinggi Badan</th>
                    <td>{{ $latest->tinggi_badan }} cm</td>
                </tr>
                <tr>
                    <th>Berat Badan</th>
                    <td>{{ $latest->berat_badan }} kg</td>
                </tr>
                <tr>
                    <th>IMT</th>
                    <td>{{ $latest->imt }}</td>
                </tr>
                <tr>
                    <th>Tekanan Darah</th>
                    <td>{{ $latest->tekanan_darah }}</td>
                </tr>
                <tr>
                    <th>Gula Darah</th>
                    <td>{{ $latest->gula_darah }} mg/dL</td>
                </tr>
                <tr>
                    <th>Hasil</th>
                    <td class="hasil">{{ $latest->hasil }}</td>
                </tr>
            </table>
        @else
            <p style="text-align: center; color: #999; margin-top: 20px;">Belum ada data deteksi.</p>
        @endif
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
    </div>
</body>

</html>

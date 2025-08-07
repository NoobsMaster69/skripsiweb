@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Rekognisi Dosen' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 15px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #4472C4;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            color: #4472C4;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            font-size: 11px;
            margin: 4px 0;
            color: #666;
        }

        .summary {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #4472C4;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .summary h3 {
            margin: 0 0 8px;
            font-size: 12px;
            color: #4472C4;
        }

        .summary-item {
            display: inline-block;
            margin-right: 25px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #4472C4;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Data Rekognisi Dosen<br>Universitas Catur Insan Cendekia</h1>
        {{-- <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} | {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</p> --}}
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Dosen:</strong> {{ $rekognisiDosens->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Prodi:</strong> {{ $rekognisiDosens->groupBy('prodi')->count() }}
        </div>
        <div class="summary-item">
            <strong>Tahun Akademik Aktif:</strong> {{ $rekognisiDosens->groupBy('tahun_akademik')->keys()->implode(', ') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Dosen</th>
                <th>Prodi</th>
                <th>Bidang Rekognisi</th>
                <th>Deskripsi</th>
                <th>Tahun Akademik</th>
                <th>Tanggal Rekognisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekognisiDosens as $item)
            <tr>
                <td>{{ $item->nama_dosen }}</td>
                <td>{{ $item->prodi }}</td>
                <td>{{ $item->bidang_rekognisi }}</td>
                <td>{{ Str::limit($item->deskripsi, 150) }}</td>
                <td class="text-center">{{ $item->tahun_akademik }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_rekognisi)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="font-style: italic; color: #666;">
                    Tidak ada data rekognisi dosen tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh sistem pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }} WIB
    </div>

</body>
</html>

@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Export PDF - Keterampilan Umum' }}</title>
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
            border-bottom: 2px solid #3e5da9;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            color: #3e5da9;
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
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3e5da9;
        }

        .summary h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #3e5da9;
        }

        .summary-item {
            display: inline-block;
            margin-right: 25px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #3e5da9;
            color: white;
            text-align: center;
            font-weight: bold;
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
        <h1>Data Keterampilan Umum<br>Universitas Catur Insan Cendekia</h1>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Waktu Cetak: {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Keterampilan Umum:</strong> {{ $keterampilanUmum->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Sumber Unik:</strong> {{ $keterampilanUmum->groupBy('sumber')->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode CPL</th>
                <th>Deskripsi</th>
                <th>Sumber</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keterampilanUmum as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ Str::limit($item->deskripsi, 150) }}</td>
                    <td>{{ $item->sumber }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="font-style: italic; color: #666;">
                        Belum ada data keterampilan umum.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }} WIB</p>
        <p>LAPORAN KETERAMPILAN UMUM - PRODI UCIC</p>
    </div>
</body>
</html>

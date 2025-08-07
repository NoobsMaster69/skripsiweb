@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Sikap' }}</title>
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
            margin: 5px 0;
            color: #666;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4472C4;
        }
        .summary h3 {
            margin: 0 0 8px 0;
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
            font-size: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            vertical-align: top;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-align: center;
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
        <h1>Laporan Data Profil Lulusan - Sikap</h1>
        <p>Tanggal Export: {{ now()->format('d F Y') }}</p>
        <p>Waktu Export: {{ now()->format('H:i:s') }} WIB</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Data:</strong> {{ $sikaps->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Sumber Unik:</strong> {{ $sikaps->groupBy('sumber')->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">CPL SN-DIKTI</th>
                <th>Deskripsi</th>
                <th style="width: 20%;">Sumber</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sikaps as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $item->kode }}</td>
                    <td>{{ Str::limit($item->deskripsi, 200) }}</td>
                    <td class="text-center">{{ $item->sumber }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="font-style: italic; color: #666;">
                        Tidak ada data sikap yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }} WIB</p>
        <p>Sistem Informasi Profil Lulusan FTI - UCIC</p>
    </div>

</body>
</html>

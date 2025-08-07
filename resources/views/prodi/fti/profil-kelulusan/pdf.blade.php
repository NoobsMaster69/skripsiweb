@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Profil Lulusan' }}</title>
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
            padding-bottom: 15px;
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
            font-size: 9px;
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
        td.text-center {
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
        <h1>Laporan Profil Lulusan<br>Universitas Catur Insan Cendekia</h1>
        <p>Tanggal Export: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Waktu Export: {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Profil Lulusan:</strong> {{ $items->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Aspek:</strong> {{ $items->groupBy('aspek')->count() }}
        </div>
        <div class="summary-item">
            <strong>Level KKNI Tertinggi:</strong> {{ $items->max('level_kkni') ?? '-' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode PL</th>
                <th>Profil Lulusan</th>
                <th>Aspek</th>
                <th>Profesi</th>
                <th>Level KKNI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->kode_pl }}</td>
                    <td>{{ Str::limit($item->profil_lulusan, 120) }}</td>
                    <td>{{ $item->aspek }}</td>
                    <td>{{ $item->profesi }}</td>
                    <td class="text-center">{{ $item->level_kkni }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="font-style: italic; color: #666;">
                        Belum ada data profil lulusan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }} WIB</p>
        <p>LAPORAN DATA PROFIL LULUSAN - PRODI UCIC</p>
    </div>
</body>
</html>

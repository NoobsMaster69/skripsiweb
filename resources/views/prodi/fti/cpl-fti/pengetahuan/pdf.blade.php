@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan Data Pengetahuan' }}</title>
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
            border-bottom: 2px solid #4472C4;
            margin-bottom: 25px;
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
            padding: 6px 8px;
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
            font-size: 9px;
            text-align: right;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Data Pengetahuan</h1>
        <p>Program Studi - Universitas Catur Insan Cendekia</p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} | {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Data:</strong> {{ $pengetahuans->count() }}
        </div>
        <div class="summary-item">
            <strong>Sumber Unik:</strong> {{ $pengetahuans->groupBy('sumber')->count() }}
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
            @forelse ($pengetahuans as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $item->kode }}</td>
                    <td>{{ Str::limit($item->deskripsi, 150) }}</td>
                    <td class="text-center">{{ $item->sumber }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="font-style: italic; color: #666;">
                        Tidak ada data tersedia.
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

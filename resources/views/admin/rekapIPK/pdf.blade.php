@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Rekap Data IPK' }}</title>
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
            margin-top: 15px;
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
        <h1>Laporan Rekap IPK Mahasiswa<br>Universitas Catur Insan Cendekia</h1>
        <p>Tanggal Export: {{ date('d F Y') }}</p>
        <p>Waktu Export: {{ date('H:i:s') }} WIB</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Mahasiswa:</strong> {{ $data->count() }}
        </div>
        <div class="summary-item">
            <strong>Rata-rata IPK:</strong> {{ number_format($data->avg('ipk'), 2) }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Prodi:</strong> {{ $data->groupBy('prodi')->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Tahun Lulus</th>
                <th>Tanggal Lulus</th>
                <th>IPK</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $row)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $row->nim }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->prodi }}</td>
                    <td class="text-center">{{ $row->tahun_lulus }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal_lulus)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ number_format($row->ipk, 2) }}</td>
                    <td class="text-center">{{ $row->predikat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="font-style: italic; color: #666;">
                        Belum ada data yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }} WIB</p>
        <p> LAPORAN DATA IPK MAHASISWA - ADMIN UCIC</p>
    </div>
</body>
</html>

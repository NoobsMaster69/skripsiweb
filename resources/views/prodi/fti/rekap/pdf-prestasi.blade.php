@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Prestasi Mahasiswa' }}</title>
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
            border-bottom: 2px solid #1c3a9e;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 16px;
            margin: 0;
            color: #1c3a9e;
            font-weight: bold;
            text-transform: uppercase;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #1c3a9e;
        }
        .summary h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #1c3a9e;
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
            background-color: #1c3a9e;
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
        <h1>Laporan Prestasi Mahasiswa<br>Universitas Catur Insan Cendekia</h1>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Mahasiswa:</strong> {{ $data->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Prodi:</strong> {{ $data->groupBy('prodi')->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Fakultas:</strong> {{ $data->groupBy('fakultas')->count() }}
        </div>
    </div>

    @php
        $sortedData = $data->sortBy('prodi')->values();
    @endphp

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Fakultas</th>
                <th>Program Studi</th>
                <th>Judul Karya</th>
                <th>Tingkatan</th>
                <th>Tanggal Perolehan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sortedData as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->nm_mhs }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->fakultas }}</td>
                    <td>{{ $item->prodi }}</td>
                    <td>{{ $item->judul_karya }}</td>
                    <td class="text-center">{{ ucfirst($item->tingkat) }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_perolehan
                            ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y')
                            : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="font-style: italic; color: #666;">
                        Belum ada data yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }} WIB</p>
        <p>LAPORAN PRESTASI MAHASISWA - PRODI UCIC</p>
    </div>
</body>
</html>

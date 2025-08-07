@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Rekap Karya Mahasiswa Lainnya' }}</title>
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
            border-bottom: 2px solid #2140a3;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            color: #2140a3;
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
            border-left: 4px solid #2140a3;
        }

        .summary h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #2140a3;
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
            background-color: #2140a3;
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
        <h1>Rekapitulasi Karya Mahasiswa Lainnya<br>Universitas Catur Insan Cendekia</h1>
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
        $sorted = $data->sortBy([['prodi', 'asc'], ['nm_mhs', 'asc']])->values();
    @endphp

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Fakultas</th>
                <th>Program Studi</th>
                <th>Tahun</th>
                <th>Kegiatan</th>
                <th>Judul Karya</th>
                <th>Tanggal Perolehan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sorted as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->nm_mhs }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->fakultas }}</td>
                    <td>{{ $item->prodi }}</td>
                    <td class="text-center">{{ $item->tahun }}</td>
                    <td>{{ $item->kegiatan }}</td>
                    <td>{{ $item->judul_karya }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_perolehan
                            ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y')
                            : '-' }}
                    </td>
                    <td class="text-center">{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="font-style: italic; color: #666;">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }} WIB</p>
        <p>LAPORAN KARYA MAHASISWA LAINNYA - UCIC</p>
    </div>
</body>
</html>

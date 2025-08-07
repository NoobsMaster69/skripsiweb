<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan Publikasi Mahasiswa' }}</title>
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

        .summary-item {
            display: inline-block;
            margin-right: 20px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        .text-center {
            text-align: center;
        }

        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        .footer {
            margin-top: 30px;
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
        <h1>{{ $title ?? 'Laporan Publikasi Mahasiswa' }}</h1>
        <p>Universitas Catur Insan Cendekia</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total Publikasi:</strong> {{ $publikasiMahasiswa->count() }} Karya
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="16%">Nama Mahasiswa</th>
                <th width="10%">NIM</th>
                <th width="12%">Program Studi</th>
                <th width="12%">Fakultas</th>
                <th width="7%">Tahun</th>
                <th width="18%">Judul Karya</th>
                <th width="10%">Jenis Publikasi</th>
                <th width="8%">Tanggal</th>
                <th width="8%">Lampiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($publikasiMahasiswa as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nm_mhs }}</td>
                    <td class="text-center">{{ $item->nim }}</td>
                    <td>{{ $item->prodi }}</td>
                    <td>{{ $item->fakultas }}</td>
                    <td class="text-center">{{ $item->tahun }}</td>
                    <td>{{ $item->judul_karya }}</td>
                    <td class="text-center">{{ ucwords(str_replace('_', ' ', $item->jenis_publikasi)) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        @if ($item->file_upload)
                            <a href="{{ asset('storage/' . $item->file_upload) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="no-data">
                        Tidak ada data publikasi mahasiswa yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }} WIB
    </div>

</body>
</html>

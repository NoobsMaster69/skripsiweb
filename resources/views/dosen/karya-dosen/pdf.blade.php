<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
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
        <h1>{{ $title }}</h1>
        <p>Universitas Catur Insan Cendekia</p>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total Karya:</strong> {{ $karyaDosen->count() }} Karya
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Nama Dosen</th>
                <th width="25%">Judul Karya</th>
                <th width="12%">Program Studi</th>
                <th width="12%">Fakultas</th>
                <th width="12%">Jenis Karya</th>
                <th width="8%">Tahun</th>
                <th width="24%">Deskripsi</th>
                <th width="10%">Lampiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($karyaDosen as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_dosen }}</td>
                    <td>{{ $item->judul_karya }}</td>
                    <td class="text-center">{{ $item->prodi }}</td>
                    <td class="text-center">{{ $item->fakultas }}</td>
                    <td class="text-center">{{ $item->jenis_karya }}</td>
                    <td class="text-center">{{ $item->tahun_pembuatan }}</td>
                    <td>{{ $item->deskripsi ?? '-' }}</td>
                    <td class="text-center">
                        @if ($item->file_karya)
                            <a href="{{ asset('storage/' . $item->file_karya) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">Data karya dosen belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i:s') }} WIB
    </div>
</body>
</html>

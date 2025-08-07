<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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
            padding-bottom: 10px;
        }

        .header h2 {
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
            font-size: 10px;
        }

        .summary p {
            margin: 0;
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

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>{{ $title }}</h2>
        <p>Universitas Catur Insan Cendekia</p>
    </div>

    <div class="summary">
        <p><strong>Total Data HKI:</strong> {{ $mahasiswaHki->count() }} Karya</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Program Studi</th>
                <th>Fakultas</th>
                <th>Tahun</th>
                <th>Judul Karya</th>
                <th>Tanggal Perolehan</th>
                <th>Kegiatan</th>
                <th>Lampiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mahasiswaHki as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nm_mhs }}</td>
                    <td class="text-center">{{ $item->nim }}</td>
                    <td>{{ $item->prodi }}</td>
                    <td>{{ $item->fakultas }}</td>
                    <td class="text-center">{{ $item->tahun }}</td>
                    <td>{{ $item->judul_karya }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $item->kegiatan }}</td>
                    <td class="text-center">
                        @if ($item->file_upload)
                            <a href="{{ asset($item->file_upload) }}" target="_blank">Lihat</a>
                        @else
                            <span style="background-color:#f8d7da; color:#721c24; padding:2px 6px; border-radius:4px;">Tidak Ada</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="no-data">Data HKI mahasiswa belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB
    </div>

</body>
</html>

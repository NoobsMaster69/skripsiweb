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
            padding: 0;
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

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
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

        .text-right {
            text-align: right;
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
        <p>Fakultas Teknologi Informasi - Universitas Catur Insan Cendekia</p>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total Prestasi:</strong> {{ $prestasiMahasiswa->count() }} Karya
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">NIM</th>
                <th width="18%">Nama Mahasiswa</th>
                <th width="7%">Tahun</th>
                <th width="25%">Judul Karya</th>
                <th width="12%">Kegiatan</th>
                <th width="10%">Tingkat</th>
                <th width="11%">Prestasi</th>
                <th width="15%">Lampiran</th>

            </tr>
        </thead>
        <tbody>
            @forelse($prestasiMahasiswa as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nm_mhs }}</td>
                    <td class="text-center">{{ $item->tahun }}</td>
                    <td>{{ $item->judul_karya }}</td>
                    <td class="text-center">{{ $item->kegiatan }}</td>
                    <td class="text-center">{{ $item->formatted_tingkat }}</td>
                    <td class="text-center">{{ $item->formatted_prestasi }}</td>
                    <td class="text-center">
                        @if ($item->file_upload)
                            <a href="{{ url('storage/' . $item->file_upload) }}" target="_blank">Lihat</a>
                        @else
                            <span
                                style="background-color:#f8d7da; color:#721c24; padding:2px 6px; border-radius:4px;">Tidak
                                Ada</span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">
                        Data prestasi mahasiswa belum tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i:s') }} WIB
    </div>
</body>

</html>

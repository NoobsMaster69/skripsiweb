@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Buku Kurikulum</title>
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

        th,
        td {
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
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Buku Kurikulum</h1>
        <p>Tanggal Export: {{ now()->format('d F Y') }}</p>
        <p>Waktu Export: {{ now()->format('H:i:s') }} WIB</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item"><strong>Total Dokumen:</strong> {{ $data->count() }}</div>
        <div class="summary-item"><strong>Dengan Lampiran:</strong> {{ $data->whereNotNull('file_path')->count() }}</div>
        <div class="summary-item"><strong>Status 'Menunggu':</strong> {{ $data->where('status', 'menunggu')->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Upload Oleh</th>
                <th>Tgl Upload</th>
                <th>Tgl Pengesahan</th>
                <th>Status</th>
                <th>Lampiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->nomor_dokumen }}</td>
                    <td>{{ $item->nama_dokumen }}</td>
                    <td class="text-center">{{ $item->di_upload }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_pengesahan ? \Carbon\Carbon::parse($item->tanggal_pengesahan)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">{{ ucfirst($item->status) }}</td>
                    <td class="text-center">
                        @if ($item->file_path)
                            <a href="{{ asset($item->file_path) }}" target="_blank">Lihat</a>
                        @else
                            <span
                                style="background-color:#f8d7da; color:#721c24; padding:2px 6px; border-radius:4px;">Tidak
                                Ada</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="font-style: italic;">Data tidak tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }} WIB</p>
        <p> Buku Kurikulum- UCIC</p>
    </div>

</body>

</html>

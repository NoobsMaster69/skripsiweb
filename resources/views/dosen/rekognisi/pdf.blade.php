@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan Rekognisi Dosen' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
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
            font-size: 14px;
            margin: 0;
            color: #1c3a9e;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            font-size: 10px;
            margin: 5px 0;
            color: #666;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #1c3a9e;
        }
        .summary h3 {
            margin: 0 0 8px 0;
            font-size: 11px;
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
            font-size: 9px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            vertical-align: top;
        }
        th {
            background-color: #1c3a9e;
            color: white;
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
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            color: #fff;
            font-size: 9px;
            display: inline-block;
        }
        .primary { background-color: #007bff; }
        .success { background-color: #28a745; }
        .warning { background-color: #ffc107; }
        .secondary { background-color: #6c757d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Rekognisi Dosen<br>Universitas Catur Insan Cendekia</h1>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item"><strong>Total Rekognisi:</strong> {{ $data->count() }}</div>
        <div class="summary-item"><strong>Jumlah Prodi:</strong> {{ $data->groupBy('prodi')->count() }}</div>
        <div class="summary-item"><strong>Jumlah Bidang:</strong> {{ $data->groupBy('bidang_rekognisi')->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dosen</th>
                <th>Prodi</th>
                <th>Bidang</th>
                <th>Tahun</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->nama_dosen }}</td>
                    <td>{{ $item->prodi }}</td>
                    <td>
                        @php
                            $colors = [
                                'Penelitian' => 'primary',
                                'Pengabdian Masyarakat' => 'success',
                                'Penghargaan' => 'warning',
                            ];
                            $badge = $colors[$item->bidang_rekognisi] ?? 'secondary';
                        @endphp
                        <span class="badge {{ $badge }}">{{ $item->bidang_rekognisi }}</span>
                    </td>
                    <td class="text-center">{{ $item->tahun_akademik }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_rekognisi
                            ? \Carbon\Carbon::parse($item->tanggal_rekognisi)->format('d/m/Y')
                            : '-' }}
                    </td>
                    <td>{{ Str::limit($item->deskripsi, 100) ?? '-' }}</td>
                    <td class="text-center">{{ $item->file_bukti ? 'Tersedia' : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="font-style: italic; color: #666;">
                        Tidak ada data rekognisi dosen.
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

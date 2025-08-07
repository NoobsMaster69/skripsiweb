
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
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
            border-bottom: 2px solid #4472C4;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 14px;
            margin: 0;
            padding: 0;
            color: #4472C4;
            font-weight: bold;
            text-transform: uppercase;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #4472C4;
        }
        .summary-item {
            font-size: 9px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            table-layout: fixed;
            word-wrap: break-word;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            vertical-align: top;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        td {
            word-break: break-word;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 25px;
            text-align: right;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Fakultas Teknologi Informasi - Universitas Catur Insan Cendekia</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total CPL Dosen:</strong> {{ $targets->count() }} Data
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tahun</th>
                <th width="13%">Prodi</th>
                <th width="15%">Mata Kuliah</th>
                <th width="8%">Target</th>
                <th width="10%">Capaian</th>
                <th width="10%">Dokumen</th>
                <th width="15%">Link</th>
                <th width="14%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($targets as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->masterCpl->tahun_akademik ?? '-' }}</td>
                    <td>{{ $item->masterCpl->program_studi ?? '-' }}</td>
                    <td>{{ $item->masterCpl->mata_kuliah ?? '-' }}</td>
                    <td class="text-center">{{ number_format($item->masterCpl->target_pencapaian ?? 0, 1) }}%</td>
                    <td class="text-center">{{ number_format($item->ketercapaian ?? 0, 1) }}%</td>
                    <td class="text-center">{{ $item->dokumen_pendukung ? 'Tersedia' : '-' }}</td>
                    <td class="text-center">{{ $item->link ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="no-data text-center">Data CPL Dosen belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i:s') }} WIB
    </div>
</body>
</html>

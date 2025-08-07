<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Target Rektorat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            padding: 0;
        }
        .header p {
            font-size: 12px;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
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
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA TARGET REKTORAT</h1>
        <p>Tanggal Export: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tahun Akademik</th>
                <th width="25%">Program Studi</th>
                <th width="25%">Mata Kuliah</th>
                <th width="10%">Target</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($targets as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->tahun_akademik }}</td>
                    <td>{{ $item->program_studi }}</td>
                    <td>{{ $item->mata_kuliah }}</td>
                    <td class="text-center">
                        @php
                            $targetValue = floatval($item->target_pencapaian ?? 0);
                            $badgeClass = $targetValue >= 80 ? 'success' : ($targetValue >= 60 ? 'warning' : 'danger');
                        @endphp
                        <span class="badge badge-{{ $badgeClass }}">{{ number_format($targetValue, 1) }}%</span>
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Data masih kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

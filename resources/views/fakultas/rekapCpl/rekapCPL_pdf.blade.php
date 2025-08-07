@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Rekap CPL' }}</title>
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
            border-bottom: 2px solid #2052BE;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 16px;
            margin: 0;
            color: #2052BE;
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
            border-left: 4px solid #2052BE;
        }
        .summary h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #2052BE;
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
            background-color: #2052BE;
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
        <h1>Laporan Rekap Capaian Pembelajaran Lulusan (CPL)</h1>
        <p>Universitas Catur Insan Cendekia</p>
        {{-- <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p> --}}
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Data:</strong> {{ $data->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Program Studi:</strong> {{ $data->groupBy('program_studi')->count() }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Tahun Akademik:</strong> {{ $data->groupBy('tahun_akademik')->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Akademik</th>
                <th>Program Studi</th>
                <th>Mata Kuliah</th>
                <th>Target</th>
                <th>Ketercapaian</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $item->tahun_akademik }}</td>
                    <td>{{ $item->program_studi }}</td>
                    <td>{{ $item->mata_kuliah }}</td>
                    <td class="text-center">{{ $item->target_pencapaian }}%</td>
                    <td class="text-center">
                        {{ optional($item->cplDosen)->ketercapaian !== null
                            ? number_format($item->cplDosen->ketercapaian, 1) . '%'
                            : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="font-style: italic; color: #666;">
                        Belum ada data yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }} WIB</p>
        <p>LAPORAN REKAP CPL - FAKULTAS UCIC</p>
    </div>
</body>
</html>

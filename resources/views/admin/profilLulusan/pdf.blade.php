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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #ccc;
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
        <p>Tanggal Cetak: {{ $tanggal ?? now()->format('d F Y') }}</p>
    </div>

    <div class="summary">
        <strong>Total Profil Lulusan:</strong> {{ $items->count() }} Data
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode PL</th>
                <th>Profil Lulusan</th>
                <th width="18%">Aspek</th>
                <th width="18%">Profesi</th>
                <th width="15%">Level KKNI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->kode_pl }}</td>
                    <td>{{ $item->profil_lulusan }}</td>
                    <td>{{ $item->aspek }}</td>
                    <td>{{ $item->profesi }}</td>
                    <td class="text-center">{{ $item->level_kkni }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-data">Tidak ada data profil lulusan tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i:s') }} WIB
    </div>

</body>
</html>

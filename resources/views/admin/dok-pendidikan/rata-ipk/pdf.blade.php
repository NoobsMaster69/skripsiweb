<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan IPK Mahasiswa Lulusan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #2052be;
            color: white;
        }

        h3,
        p {
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body>
    <h3>LAPORAN DATA IPK MAHASISWA LULUSAN</h3>
    <p>Universitas Catur Insan Cendekia</p>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Tahun Lulus</th>
                <th>Tanggal Lulus</th>
                <th>IPK</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rataipk as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->prodi }}</td>
                    <td>{{ $item->tahun_lulus }}</td>
                    <td>
                        {{ $item->tanggal_lulus ? \Carbon\Carbon::parse($item->tanggal_lulus)->format('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $item->ipk }}</td>
                    <td>{{ $item->predikat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

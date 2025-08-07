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

        .summary h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #4472C4;
        }

        .summary-item {
            display: inline-block;
            margin-right: 20px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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
            font-size: 9px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
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
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        .file-indicator {
            font-size: 8px;
            color: #28a745;
            font-weight: bold;
        }

        .no-file {
            color: #dc3545;
        }

        .description {
            max-width: 150px;
            word-wrap: break-word;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Data Dokumen Kebijakan Rektorat</h1>
        <p>Tanggal Export: {{ date('d F Y') }}</p>
        <p>Waktu Export: {{ date('H:i:s') }} WIB</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Data</h3>
        <div class="summary-item">
            <strong>Total Dokumen:</strong> {{ $dokReks->count() }}
        </div>
        <div class="summary-item">
            <strong>Belum Validasi:</strong> {{ $dokReks->where('status', 'belum_validasi')->count() }}
        </div>
        <div class="summary-item">
            <strong>Menunggu:</strong> {{ $dokReks->where('status', 'menunggu')->count() }}
        </div>
        <div class="summary-item">
            <strong>Terverifikasi:</strong> {{ $dokReks->where('status', 'terverifikasi')->count() }}
        </div>
        <div class="summary-item">
            <strong>Ditolak:</strong> {{ $dokReks->where('status', 'ditolak')->count() }}
        </div>
    </div>


    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Nomor Dokumen</th>
                <th width="15%">Nama Dokumen</th>
                <th width="10%">Di Upload Oleh</th>
                <th width="8%">Tgl Upload</th>
                <th width="8%">Tgl Pengesahan</th>
                <th width="8%">Status</th>
                <th width="20%">Deskripsi</th>
                <th width="6%">File</th>
                <th width="10%">Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dokReks as $index => $dokRek)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $dokRek->nomor_dokumen }}</td>
                    <td>{{ $dokRek->nama_dokumen }}</td>
                    <td>{{ $dokRek->di_upload }}</td>
                    <td class="text-center">
                        {{ $dokRek->tanggal_upload ? date('d/m/Y', strtotime($dokRek->tanggal_upload)) : '-' }}
                    </td>
                    <td class="text-center">
                        {{ $dokRek->tanggal_pengesahan ? date('d/m/Y', strtotime($dokRek->tanggal_pengesahan)) : '-' }}
                    </td>
                    <td class="text-center">
                        @php
                            $statusClass = '';
                            $statusLabel = '';
                            switch ($dokRek->status) {
                                case 'belum_validasi':
                                    $statusClass = 'warning';
                                    $statusLabel = 'Belum Validasi';
                                    break;
                                case 'validasi':
                                    $statusClass = 'success';
                                    $statusLabel = 'Validasi';
                                    break;
                                case 'ditolak':
                                    $statusClass = 'danger';
                                    $statusLabel = 'Ditolak';
                                    break;
                                default:
                                    $statusClass = 'warning';
                                    $statusLabel = $dokRek->status;
                            }

                        @endphp
                        <span class="badge badge-{{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="description">
                        {{ Str::limit($dokRek->deskripsi ?? '-', 100) }}
                    </td>
                    <td class="text-center">
                        @if ($dokRek->file_path)
                            <span class="file-indicator">✓ Ada</span>
                        @else
                            <span class="file-indicator no-file">✗ Tidak</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $dokRek->created_at ? date('d/m/Y', strtotime($dokRek->created_at)) : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="no-data">
                        Data dokumen kebijakan rektorat masih kosong.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($dokReks->count() > 0)
        <div style="margin-bottom: 5px;">
            <span class="badge badge-warning">Belum Validasi</span> - Dokumen belum divalidasi oleh admin
        </div>
        <div style="margin-bottom: 5px;">
            <span class="badge badge-warning">Menunggu</span> - Dokumen sedang dalam proses validasi
        </div>
        <div style="margin-bottom: 5px;">
            <span class="badge badge-success">Terverifikasi</span> - Dokumen telah divalidasi dan disetujui
        </div>
        <div style="margin-bottom: 5px;">
            <span class="badge badge-danger">Ditolak</span> - Dokumen ditolak dan perlu diperbaiki
        </div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }} WIB</p>
        <p>Sistem Informasi Dokumen Kebijakan Rektorat</p>
    </div>
</body>

</html>

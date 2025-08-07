@extends('layout/app')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">
            <i class="fas fa-book mr-2 text-primary"></i> {{ $title }}
        </h4>

        {{-- Statistik --}}
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body">
                        <h6 class="text-muted">TOTAL DOKUMEN</h6>
                        <h4>{{ $total }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-success">
                    <div class="card-body">
                        <h6 class="text-muted">DOKUMEN PDF</h6>
                        <h4>{{ $pdf }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <h6 class="text-muted">DOKUMEN WORD</h6>
                        <h4>{{ $word }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-body">
                        <h6 class="text-muted">DOKUMEN TERBARU</h6>
                        <h4>{{ $terbaru->nomor ?? '-' }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Dokumen --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>Daftar Master Dokumen</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="text-white" style="background-color: #3c8dbc;">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 15%;">Nomor</th>
                                <th style="width: 40%;">Nama Dokumen</th>
                                <th style="width: 20%;">File</th>
                                <th style="width: 20%;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dokumens as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span
                                            class="badge badge-pill badge-info px-3 py-2">{{ strtoupper($item->nomor) }}</span>
                                    </td>
                                    <td class="text-left">
                                        @php
                                            $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                                            $icon =
                                                $ext === 'pdf'
                                                    ? 'fa-file-pdf text-danger'
                                                    : 'fa-file-word text-primary';
                                        @endphp
                                        <i class="fas {{ $icon }} mr-2 fa-lg"></i>
                                        <strong>{{ $item->nama }}</strong><br>
                                        <small class="text-muted">{{ $item->keterangan ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if ($item->file_path)
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ url($item->file_path) }}" target="_blank"
                                                    class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                                </a>

                                                <a href="{{ route('master-dokumen-buku.download', $item->id) }}"
                                                    class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ \Carbon\Carbon::parse($item->created_at)->setTimezone('Asia/Jakarta')->format('d/m/Y') }}
                                        <br>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($item->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $dokumens->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

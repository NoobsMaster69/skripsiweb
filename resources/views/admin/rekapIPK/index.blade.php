@extends('layout.app')

@section('content')
    <!-- Judul -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-chart-bar text-primary me-2"></i> {{ $title }}
        </h1>
    </div>

    <!-- Statistik IPK -->
    {{-- <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Rata-Rata IPK
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ number_format($averageIpk, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Form Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('rekapIPK.index') }}">
                <input type="hidden" name="submit_filter" value="1">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tahun Lulus</label>
                        <select name="tahun_lulus" class="form-control form-control-sm">
                            <option value="">-- Semua Tahun --</option>
                            @foreach ($tahunOptions as $tahun)
                                <option value="{{ $tahun }}"
                                    {{ request('tahun_lulus') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Program Studi</label>
                        <select name="prodi" class="form-control form-control-sm">
                            <option value="">-- Semua Prodi --</option>
                            @foreach ($prodiOptions as $prodi)
                                <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                    {{ $prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapIPK.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    @if (request()->has('submit_filter') && $dataIpk->count())
        <div class="card shadow-sm">
            <!-- Header Judul dan Tombol Ekspor -->
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Rekap IPK</h6>

                <div>
                    <button type="button" class="btn btn-success btn-sm" onclick="exportData('excel')">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="exportData('pdf')">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>

                <form id="exportForm" action="#" method="GET" target="_blank" class="d-none">
                    @foreach (request()->all() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>

                <form id="pdfForm" action="#" method="GET" target="_blank" class="d-none">
                    @foreach (request()->all() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
            </div>


            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Tahun Lulus</th>
                            <th>Tanggal Lulus</th>
                            <th>IPK</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataIpk as $i => $row)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $row->nim }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->prodi }}</td>
                                <td class="text-center">{{ $row->tahun_lulus }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal_lulus)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">{{ number_format($row->ipk, 2) }}</td>
                                <td class="text-center">{{ $row->predikat }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(request()->has('submit_filter'))
        <div class="alert alert-warning text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data ditemukan.
        </div>
    @endif

    <script>
        function exportData(type) {
            const form = type === 'excel' ?
                document.getElementById('exportForm') :
                document.getElementById('pdfForm');

            form.action = type === 'excel' ?
                "{{ route('rekapIPK.export.excel') }}" :
                "{{ route('rekapIPK.export.pdf') }}";

            form.submit();
        }
    </script>

@endsection

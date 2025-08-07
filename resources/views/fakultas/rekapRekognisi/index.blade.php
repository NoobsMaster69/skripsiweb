@extends('layout.app')

@section('content')
    <!-- Judul -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-award text-primary me-2"></i> {{ $title }}
        </h1>
    </div>
    <a href="{{ route('rekapRekognisiFakultas.grafik') }}" class="btn btn-primary mb-3">
        📊 Lihat Grafik
    </a>


    <!-- Form Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('rekapRekognisiFakul.index') }}">
                <input type="hidden" name="submit_filter" value="1">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="tahun" class="form-label fw-bold">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control form-control-sm">
                            <option value="">-- Semua Tahun --</option>
                            @foreach ($listTahun as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Program Studi</label>
                        <select name="prodi" class="form-control form-control-sm">
                            <option value="">-- Semua Prodi --</option>
                            @foreach ($listProdi as $prodi)
                                <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                    {{ $prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Bidang Rekognisi</label>
                        <select name="bidang" class="form-control form-control-sm">
                            <option value="">-- Semua Bidang --</option>
                            @foreach ($listBidang as $bidang)
                                <option value="{{ $bidang }}" {{ request('bidang') == $bidang ? 'selected' : '' }}>
                                    {{ $bidang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapRekognisiFakul.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    @if (request()->has('submit_filter') && $rekognisiDosens->count())
        <div class="card shadow-sm">
            <!-- Header atas: Judul & Export -->
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Rekap Rekognisi Dosen</h6>

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

            <!-- Tabel -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Dosen</th>
                                <th>Prodi</th>
                                <th>Bidang</th>
                                <th>Tahun</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                                <th>Lampiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekognisiDosens as $i => $rekog)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $rekog->nama_dosen }}</td>
                                    <td>{{ $rekog->prodi }}</td>
                                    <td class="text-center text-white">
                                        @php
                                            $badgeClass = match (strtolower($rekog->bidang_rekognisi)) {
                                                'pendidikan' => 'primary',
                                                'penelitian' => 'success',
                                                'pengabdian masyarakat' => 'warning',
                                                'profesional' => 'info',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ ucwords($rekog->bidang_rekognisi) }}
                                        </span>
                                    </td>

                                    <td class="text-center">{{ $rekog->tahun_akademik }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($rekog->tanggal_rekognisi)->format('d-m-Y') }}</td>
                                    <td class="text-center text-white">{!! status_prestasi($rekog->status) !!}</td>
                                    <td>{{ $rekog->deskripsi }}</td>
                                    <td class="text-center">
                                        @if ($rekog->file_bukti)
                                            <a href="{{ asset('storage/' . $rekog->file_bukti) }}" target="_blank"
                                                class="btn btn-outline-info btn-sm">Lihat</a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif(request()->has('submit_filter'))
        <div class="alert alert-warning text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data ditemukan.
        </div>
    @endif

    <!-- JS Ekspor -->
    <script>
        function exportData(type) {
            const form = type === 'excel' ?
                document.getElementById('exportForm') :
                document.getElementById('pdfForm');

            form.action = type === 'excel' ?
                "{{ route('rekapRekognisiFakul.export') }}" :
                "{{ route('rekapRekognisiFakul.export.pdf') }}";

            form.submit();
        }
    </script>
@endsection

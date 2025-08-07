@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-bullseye text-primary me-2"></i>
            {{ $title }}
        </h1>
    </div>
    <a href="{{ route('rekapCpl.grafik') }}" class="btn btn-primary mb-3">
    📊 Lihat Grafik
</a>


    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('rekapCPL.admin') }}" method="GET">
                <input type="hidden" name="submit_filter" value="1">
                <div class="row">
                    <!-- Tahun -->
                    <!-- Tahun -->
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

                    <!-- Program Studi -->
                   <div class="col-md-3 mb-3">
                        <label for="prodi" class="form-label fw-bold">Program Studi</label>
                        <select name="program_studi" id="prodi" class="form-control form-control-sm">
                            <option value="">-- Semua Prodi --</option>
                            @foreach ($listProdi as $prodi)
                                <option value="{{ $prodi }}"
                                    {{ request('program_studi') == $prodi ? 'selected' : '' }}>
                                    {{ $prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Mata Kuliah -->
                    <div class="col-md-3 mb-3">
                        <label for="mata_kuliah" class="form-label fw-bold">Mata Kuliah</label>
                        <select name="mata_kuliah" id="mata_kuliah" class="form-control form-control-sm">
                            <option value="">-- Semua Mata Kuliah --</option>
                            @foreach ($listMatkul as $mk)
                                <option value="{{ $mk }}" {{ request('mata_kuliah') == $mk ? 'selected' : '' }}>
                                    {{ $mk }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Tombol -->
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan Data
                            </button>
                            <a href="{{ route('rekapCPL.admin') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Hasil Rekap -->
    @if (request()->has('submit_filter') && $targets->count())
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 text-primary">Data Rekap CPL</h6>
                <form id="exportForm" method="GET" target="_blank">
                    <!-- Kirimkan filter sebagai input hidden -->
                    @foreach (request()->all() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div class="btn-group" style="gap: 10px;">
                        <button type="button" onclick="exportData('excel')" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" onclick="exportData('pdf')" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Program Studi</th>
                            <th>Mata Kuliah</th>
                            <th>Target</th>
                            <th>Ketercapaian</th>
                            <th>Dokumen</th>
                            <th>Link</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($targets as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $item->tahun_akademik }}</td>
                                <td>{{ $item->program_studi }}</td>
                                <td>{{ $item->mata_kuliah }}</td>
                                <td class="text-center">
                                    {{ $item->target_pencapaian ? $item->target_pencapaian . '%' : '-' }}
                                </td>

                                <td class="text-center">
                                    {{ optional($item->cplDosen)->ketercapaian !== null
                                        ? number_format($item->cplDosen->ketercapaian, 1) . '%'
                                        : '-' }}
                                </td>
                                <td class="text-center">
                                    @if (optional($item->cplDosen)->dokumen_pendukung)
                                        <a href="{{ asset('storage/' . $item->cplDosen->dokumen_pendukung) }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (optional($item->cplDosen)->link)
                                        <a href="{{ $item->cplDosen->link }}" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-link-45deg"></i> Tautan
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ optional($item->cplDosen)->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Rata-rata -->
                @php
                    $jumlahTargetValid = $targets->filter(fn($item) => is_numeric($item->target_pencapaian))->count();

                    $totalTarget = $targets->sum(function ($item) {
                        return is_numeric($item->target_pencapaian) ? (float) $item->target_pencapaian : 0;
                    });

                    $jumlahKetercapaianValid = $targets
                        ->filter(fn($item) => is_numeric(optional($item->cplDosen)->ketercapaian))
                        ->count();

                    $totalKetercapaian = $targets->sum(function ($item) {
                        return is_numeric(optional($item->cplDosen)->ketercapaian)
                            ? (float) optional($item->cplDosen)->ketercapaian
                            : 0;
                    });

                    $rataTarget = $jumlahTargetValid ? round($totalTarget / $jumlahTargetValid, 1) : 0;
                    $rataKetercapaian = $jumlahKetercapaianValid
                        ? round($totalKetercapaian / $jumlahKetercapaianValid, 1)
                        : 0;
                @endphp



                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="bg-light border p-2 text-center fw-bold rounded shadow-sm">
                            Total Target
                            <span class="badge bg-primary ms-2 text-white">{{ $rataTarget }}%</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light border p-2 text-center fw-bold rounded shadow-sm">
                            Total Ketercapaian
                            <span class="badge bg-success ms-2 text-white">{{ $rataKetercapaian }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(request()->has('submit_filter'))
        <div class="alert alert-warning text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data ditemukan untuk filter yang dipilih.
        </div>
    @endif
    <script>
        function exportData(type) {
            const form = document.getElementById('exportForm');
            if (type === 'excel') {
                form.action = "{{ route ('rekapCPL.admin.exportExcel') }}";
            } else {
                form.action = "{{ route ('rekapCPL.admin.exportPdf') }}";
            }
            form.submit();
        }
    </script>
@endsection

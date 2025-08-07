@extends('layout/app')

@section('content')
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-certificate text-primary me-2"></i>
            {{ $title }}
        </h1>
    </div>

    <a href="{{ route('rekapRektorat.serkom.grafik') }}" class="btn btn-primary mb-3">
        <i class="fas fa-chart-bar"></i> Lihat Grafik Sertifikasi
    </a>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('rekapRektorat.serkom') }}" method="GET">
                <div class="row">
                    <!-- Tahun -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Tahun</label>
                        <select name="tahun" class="form-control form-control-sm">
                            <option value="">-- Semua Tahun --</option>
                            @foreach ($listTahun as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fakultas -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Fakultas</label>
                        <select name="fakultas" class="form-control form-control-sm">
                            <option value="">-- Semua Fakultas --</option>
                            <option value="FTI" {{ request('fakultas') == 'FTI' ? 'selected' : '' }}>FTI</option>
                            <option value="FEB" {{ request('fakultas') == 'FEB' ? 'selected' : '' }}>FEB</option>
                        </select>
                    </div>

                    <!-- Prodi -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Program Studi</label>
                        <select name="prodi" class="form-control form-control-sm">
                            <option value="">-- Semua Prodi --</option>
                            @foreach ($listProdi as $prodi)
                                <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                    {{ $prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tingkatan -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Tingkatan</label>
                        <select name="tingkatan" class="form-control form-control-sm">
                            <option value="">-- Semua Tingkat --</option>
                            <option value="internasional" {{ request('tingkatan') == 'internasional' ? 'selected' : '' }}>
                                Internasional</option>
                            <option value="nasional" {{ request('tingkatan') == 'nasional' ? 'selected' : '' }}>Nasional
                            </option>
                            <option value="lokal" {{ request('tingkatan') == 'lokal' ? 'selected' : '' }}>Lokal</option>
                        </select>
                    </div>

                    <!-- Kegiatan -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Kegiatan</label>
                        <input type="text" class="form-control form-control-sm bg-light" value="Sertifikasi Kompetensi"
                            readonly>
                        <input type="hidden" name="kegiatan" value="Sertifikasi Kompetensi">
                    </div>

                    <!-- Tombol -->
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" name="submit_filter" value="1" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan Data
                            </button>
                            <a href="{{ route('rekapRektorat.serkom') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (request()->has('submit_filter') && $sertifikasi && $sertifikasi->count())
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 text-primary">Data Sertifikasi / Pelatihan Mahasiswa</h6>
                <div>
                    <form id="exportForm" method="GET" target="_blank">
                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                        <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                        <input type="hidden" name="tingkatan" value="{{ request('tingkatan') }}">
                        <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                        <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                        <input type="hidden" name="kegiatan" value="{{ request('kegiatan') }}">
                        <button type="button" onclick="exportData('excel')" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" onclick="exportData('pdf')" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover table-sm" id="dataTable">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Judul sertifikasi kompetensi</th>
                            <th>Kegiatan</th>
                            <th>Tahun</th>
                            <th>Tingkatan</th>
                            <th>Tanggal</th>
                            <th>Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sertifikasi as $item)
                            <tr>
                                <td class="text-center"></td> {{-- No diisi oleh DataTables --}}
                                <td>
                                    <strong>{{ $item->nm_mhs }}</strong><br>
                                    <small>{{ $item->nim }}<br>{{ $item->prodi }}</small>
                                </td>
                                <td>{{ $item->judul_karya }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info text-white">{{ $item->kegiatan }}</span>
                                </td>
                                <td class="text-center">{{ $item->tahun }}</td>
                                <td class="text-center">
                                    @if ($item->tingkatan == 'internasional')
                                        <span class="badge bg-success text-white">Internasional</span>
                                    @elseif ($item->tingkatan == 'nasional')
                                        <span class="badge bg-warning text-white">Nasional</span>
                                    @else
                                        <span class="badge bg-secondary text-white">Lokal</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($item->file_upload)
                                        <a href="{{ asset('storage/' . $item->file_upload) }}"
                                            class="btn btn-outline-success btn-sm" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
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
@endsection

@section('scripts')
    <script>
        function exportData(type) {
            const form = document.getElementById('exportForm');
            form.action = type === 'excel' ?
                "{{ route('rekapRektorat.serkom.export.excel') }}" :
                "{{ route('rekapRektorat.serkom.export.pdf') }}";
            form.submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().clear().destroy();
            }

            $('#dataTable').DataTable({
                language: {
                    search: "Cari:",
                    zeroRecords: "Tidak ada data ditemukan",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "›",
                        previous: "‹"
                    }
                },
                pageLength: 10,
                order: [
                    [5, 'desc']
                ],
                columnDefs: [{
                    targets: 0,
                    orderable: false
                }],
                drawCallback: function(settings) {
                    let api = this.api();
                    let startIndex = api.page.info().start;

                    api.column(0, {
                        page: 'current'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = startIndex + i + 1;
                    });
                }
            });

        });
    </script>
@endsection

@extends('layout/app')

@section('content')
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-certificate text-primary me-2"></i>
            {{ $title }}
        </h1>
    </div>
    <a href="{{ route('rekapFakul.hki.grafik') }}" class="btn btn-primary mb-3">
        <i class="fas fa-chart-bar"></i> Lihat Grafik HKI Mahasiswa
    </a>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('rekapFakul.mhsHki') }}" method="GET">
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
                        <label class="form-label fw-bold">Fakultas</label>
                        <select name="fakultas" class="form-control form-control-sm">
                            <option value="">-- Semua Fakultas --</option>
                            <option value="FTI" {{ request('fakultas') == 'FTI' ? 'selected' : '' }}>FTI</option>
                            <option value="FEB" {{ request('fakultas') == 'FEB' ? 'selected' : '' }}>FEB</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="prodi" class="form-label fw-bold">Program Studi</label>
                        <select name="prodi" id="prodi" class="form-control form-control-sm">
                            <option value="">-- Semua Prodi --</option>
                            @foreach ($listProdi as $prodi)
                                <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                    {{ $prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    {{-- <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control form-control-sm"
                            value="{{ request('tanggal_awal') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control form-control-sm"
                            value="{{ request('tanggal_akhir') }}">
                    </div> --}}

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" name="submit_filter" value="1" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan Data
                            </button>
                            <a href="{{ route('rekapFakul.mhsHki') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Kegiatan</label>
                        <input type="text" class="form-control form-control-sm" value="HKI" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (request()->has('submit_filter') && $data && $data->count())
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 text-primary">Data Mahasiswa yang Mendapatkan HKI</h6>
                <div>
                    <form id="exportForm" method="GET" target="_blank">
                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                        <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                        <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                        <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">

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
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Judul HKI</th>
                            <th>Program Studi</th>
                            <th>Fakultas</th>
                            <th>Kegiatan</th>
                            <th>Tahun</th>
                            <th>Tanggal</th>
                            <th>Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $item->nm_mhs }}</strong><br>
                                    <small>{{ $item->nim }}</small>
                                </td>
                                <td>{{ $item->judul_karya }}</td>
                                <td>{{ $item->prodi }}</td>
                                <td>{{ $item->fakultas }}</td>
                                <td class="text-center"><span class="badge bg-primary text-white">HKI</span></td>
                                <td class="text-center">{{ $item->tahun }}</td>
                                <td class="text-center">
                                    {{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($item->file_upload)
                                        <a href="{{ asset('storage/' . $item->file_upload) }}"
                                            class="btn btn-outline-success btn-sm" target="_blank" title="Download File">
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
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
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
                    [6, 'desc']
                ]
            });
        });
    </script>
    <script>
        function exportData(type) {
            const form = document.getElementById('exportForm');
            if (type === 'excel') {
                form.action = "{{ route('rekapFakul.mhsHki.export.excel') }}";
            } else {
                form.action = "{{ route('rekapFakul.mhsHki.export.pdf') }}";
            }
            form.submit();
        }
    </script>
@endsection

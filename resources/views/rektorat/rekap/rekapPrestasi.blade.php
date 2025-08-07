@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-bullseye text-primary me-2"></i> {{ $title }}
        </h1>
    </div>

    <!-- Tombol Grafik -->
    <a href="{{ route('rekapRektorat.prestasi.grafik') }}" class="btn btn-primary mb-3">
        <i class="fas fa-chart-bar"></i> Lihat Grafik Prestasi
    </a>



    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('rekapRektorat.prestasi') }}" method="GET">
                <div class="row">
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


                    <!-- Fakultas -->
                    <div class="col-md-3 mb-3">
                        <label for="fakultas" class="form-label fw-bold">Fakultas</label>
                        <select name="fakultas" id="fakultas" class="form-control form-control-sm">
                            <option value="">-- Semua Fakultas --</option>
                            <option value="FTI" {{ request('fakultas') == 'FTI' ? 'selected' : '' }}>FTI</option>
                            <option value="FEB" {{ request('fakultas') == 'FEB' ? 'selected' : '' }}>FEB</option>
                        </select>
                    </div>

                    <!-- Program Studi -->
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


                    <!-- Tingkat -->
                    <div class="col-md-3 mb-3">
                        <label for="tingkat" class="form-label fw-bold">Tingkat</label>
                        <select name="tingkat" id="tingkat" class="form-control form-control-sm">
                            <option value="">-- Semua Tingkat --</option>
                            <option value="1" {{ request('tingkat') == '1' ? 'selected' : '' }}>Local/Wilayah</option>
                            <option value="2" {{ request('tingkat') == '2' ? 'selected' : '' }}>Nasional</option>
                            <option value="3" {{ request('tingkat') == '3' ? 'selected' : '' }}>Internasional</option>
                        </select>
                    </div>

                    <!-- Jenis Prestasi -->
                    <div class="col-md-3 mb-3">
                        <label for="tingkat" class="form-label fw-bold">Prestasi</label>
                        <select name="prestasi" class="form-control">
                            <option value="">-- Jenis Prestasi --</option>
                            <option value="prestasi-akademik"
                                {{ request('prestasi') == 'prestasi-akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="prestasi-non-akademik"
                                {{ request('prestasi') == 'prestasi-non-akademik' ? 'selected' : '' }}>Non Akademik
                            </option>
                        </select>
                    </div>

                    <!-- Tanggal Awal -->
                    {{-- <div class="col-md-3 mb-3">
                        <label for="tanggal_awal" class="form-label fw-bold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm"
                            value="{{ request('tanggal_awal') }}">
                    </div> --}}

                    <!-- Tanggal Akhir -->
                    {{-- <div class="col-md-3 mb-3">
                        <label for="tanggal_akhir" class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-sm"
                            value="{{ request('tanggal_akhir') }}">
                    </div> --}}

                    <!-- Tombol Filter -->
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" name="submit_filter" value="1" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan Data
                            </button>
                            <a href="{{ route('rekapRektorat.prestasi') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    @if (isset($prestasi) && request()->has('submit_filter'))
        <!-- Data Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Prestasi Mahasiswa</h6>
                <!-- Tombol Export -->
                <div>
                    <button class="btn btn-success btn-sm" onclick="document.getElementById('exportForm').submit();">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="document.getElementById('pdfForm').submit();">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>

                <!-- Form Export Excel -->
                <form id="exportForm" action="{{ route('rekapRektorat.prestasi.export') }}" method="GET" target="_blank"
                    class="d-none">
                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                    <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                    <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                    <input type="hidden" name="tingkat" value="{{ request('tingkat') }}">
                    <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                </form>

                <!-- Form Export PDF -->
                <form id="pdfForm" action="{{ route('rekapRektorat.prestasi.export.pdf') }}" method="GET" target="_blank"
                    class="d-none">
                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                    <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                    <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                    <input type="hidden" name="tingkat" value="{{ request('tingkat') }}">
                    <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                </form>

            </div>
            <div class="card-body">
                @if ($prestasi->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Mahasiswa</th>
                                    <th width="25%">Judul Karya</th>
                                    <th width="10%">Prestasi</th>
                                    <th width="12%">Tingkat</th>
                                    <th width="12%">Tanggal</th>
                                    <th width="14%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prestasi as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="text-primary">{{ $item->nm_mhs }}</strong>
                                                <small class="text-muted">{{ $item->nim }}</small>
                                                <small class="text-muted">{{ $item->prodi }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="font-weight-bold">{{ Str::limit($item->judul_karya, 60) }}</span>
                                                <small class="text-muted"><i class="fas fa-calendar-alt"></i>
                                                    {{ $item->tahun }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->prestasi === 'prestasi-akademik')
                                                <span class="badge badge-info">Akademik</span>
                                            @elseif ($item->prestasi === 'prestasi-non-akademik')
                                                <span class="badge badge-dark">Non Akademik</span>
                                            @else
                                                <span class="badge badge-secondary">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-pill
                @if ($item->tingkat == 'internasional') badge-success
                @elseif($item->tingkat == 'nasional') badge-warning
                @else badge-secondary @endif">
                                                @if ($item->tingkat == 'internasional')
                                                    <i class="fas fa-globe"></i> Internasional
                                                @elseif($item->tingkat == 'nasional')
                                                    <i class="fas fa-flag"></i> Nasional
                                                @else
                                                    <i class="fas fa-map-marker-alt"></i> Lokal
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if ($item->file_upload)
                                                    <a href="{{ $item->file_url }}" target="_blank"
                                                        class="btn btn-outline-success" data-toggle="tooltip"
                                                        title="Download Berkas">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                <button class="btn btn-outline-secondary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#"
                                                        onclick="copyLink({{ $item->id }})">
                                                        <i class="fas fa-link"></i> Copy Link
                                                    </a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="exportSingle({{ $item->id }})">
                                                        <i class="fas fa-file-export"></i> Export Data
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <!-- Summary Info -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Menampilkan {{ $prestasi->count() }} data prestasi
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge badge-success"><i class="fas fa-globe"></i>
                                {{ $prestasi->where('tingkat', 'internasional')->count() }} Internasional</span>
                            <span class="badge badge-warning"><i class="fas fa-flag"></i>
                                {{ $prestasi->where('tingkat', 'nasional')->count() }} Nasional</span>
                            <span class="badge badge-secondary"><i class="fas fa-map-marker-alt"></i>
                                {{ $prestasi->where('tingkat', 'local-wilayah')->count() }} Lokal</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Tidak ada data prestasi yang ditemukan dengan filter yang dipilih.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },
                "pageLength": 25,
                "order": [
                    [5, "desc"]
                ], // Sort by tanggal
                "columnDefs": [{
                        "orderable": false,
                        "targets": [6]
                    } // Disable sorting on action column
                ]
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });

        // View Detail Function
        function viewDetail(id) {
            // Ajax call to get detail data
            $.ajax({
                url: `/admin/prestasi/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#detailContent').html(response);
                    $('#detailModal').modal('show');
                },
                error: function() {
                    alert('Gagal memuat detail prestasi');
                }
            });
        }

        function exportToExcel() {
            const params = new URLSearchParams(window.location.search);
            params.append('export', 'excel');
            window.location.href = `{{ route('rekapRektorat.prestasi') }}?${params.toString()}`;
        }

        function exportToPDF() {
            const params = new URLSearchParams(window.location.search);
            params.append('export', 'pdf');
            window.location.href = `{{ route('rekapRektorat.prestasi') }}?${params.toString()}`;
        }

        // Copy Link Function
        function copyLink(id) {
            const link = `${window.location.origin}/admin/prestasi/${id}`;
            navigator.clipboard.writeText(link).then(function() {
                // Show toast notification
                showToast('Link berhasil disalin!', 'success');
            });
        }

        // Export Single Record
        function exportSingle(id) {
            window.open(`/admin/prestasi/${id}/export`, '_blank');
        }

        // Toast Notification
        function showToast(message, type = 'info') {
            const toast = `
            <div class="toast" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                <div class="toast-header">
                    <i class="fas fa-${type === 'success' ? 'check-circle text-success' : 'info-circle text-info'}"></i>
                    <strong class="mr-auto ml-2">Notifikasi</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        `;
            $('body').append(toast);
            $('.toast').toast({
                delay: 3000
            }).toast('show');

            setTimeout(() => {
                $('.toast').remove();
            }, 3500);
        }
    </script>
@endpush

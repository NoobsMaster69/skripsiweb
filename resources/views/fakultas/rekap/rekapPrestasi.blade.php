@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-bullseye text-primary mr-2"></i>
            {{ $title }}
        </h1>
    </div>
     <a href="{{ route('rekapFakul.prestasi.grafik') }}" class="btn btn-primary mb-3">
        <i class="fas fa-chart-bar"></i> Lihat Grafik Prestasi
    </a>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('rekapFakul.prestasi') }}" method="GET">
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
                        <label for="fakultas" class="form-label fw-bold">Fakultas</label>
                        <select name="fakultas" id="fakultas" class="form-control form-control-sm">
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

                    <div class="col-md-3 mb-3">
                        <label for="tingkat" class="form-label fw-bold">Tingkat</label>
                        <select name="tingkat" id="tingkat" class="form-control form-control-sm">
                            <option value="">-- Semua Tingkat --</option>
                            <option value="1" {{ request('tingkat') == '1' ? 'selected' : '' }}>Local/Wilayah</option>
                            <option value="2" {{ request('tingkat') == '2' ? 'selected' : '' }}>Nasional</option>
                            <option value="3" {{ request('tingkat') == '3' ? 'selected' : '' }}>Internasional</option>
                        </select>
                    </div>

                    {{-- <div class="col-md-3 mb-3">
                        <label for="tanggal_awal" class="form-label fw-bold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm"
                            value="{{ request('tanggal_awal') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="tanggal_akhir" class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-sm"
                            value="{{ request('tanggal_akhir') }}">
                    </div> --}}

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" name="submit_filter" value="1" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Tampilkan Data
                        </button>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <a href="{{ route('rekapFakul.prestasi') }}" class="btn btn-sm btn-secondary w-100">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if (isset($publikasi) && request()->has('submit_filter'))
        <!-- Data Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Prestasi Mahasiswa</h6>
                <div>
                    <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if ($publikasi->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Mahasiswa</th>
                                    <th width="25%">Judul Prestasi</th>
                                    <th width="12%">Kegiatan</th>
                                    <th width="12%">Tingkat</th>
                                    <th width="12%">Tanggal</th>
                                    <th width="14%">Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($publikasi as $index => $item)
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
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt"></i> {{ $item->tahun }} •
                                                    <span
                                                        class="badge badge-sm
                                                        @if ($item->prestasi == 'prestasi-akademik') badge-info
                                                        @else badge-dark @endif">
                                                        {{ $item->prestasi == 'prestasi-akademik' ? 'Akademik' : 'Non-Akademik' }}
                                                    </span>
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary badge-pill">{{ $item->kegiatan }}</span>
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
                                            @if ($item->tanggal_perolehan)
                                                <span
                                                    class="d-block">{{ $item->tanggal_perolehan->format('d/m/Y') }}</span>
                                                <small
                                                    class="text-muted">{{ $item->tanggal_perolehan->diffForHumans() }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
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
                            Menampilkan {{ $publikasi->count() }} data publikasi
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge badge-success"><i class="fas fa-globe"></i>
                                {{ $publikasi->where('tingkat', 'internasional')->count() }} Internasional</span>
                            <span class="badge badge-warning"><i class="fas fa-flag"></i>
                                {{ $publikasi->where('tingkat', 'nasional')->count() }} Nasional</span>
                            <span class="badge badge-secondary"><i class="fas fa-map-marker-alt"></i>
                                {{ $publikasi->where('tingkat', 'local-wilayah')->count() }} Lokal</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Tidak ada data publikasi yang ditemukan dengan filter yang dipilih.</p>
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
                    <h5 class="modal-title">Detail Publikasi</h5>
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

@section('scripts')
    <script>
        // Pastikan tidak ada konflik dengan DataTable yang sudah ada
        // Pastikan tidak ada konflik dengan DataTable yang sudah ada
        $(document).ready(function() {
            console.log('Document ready - Starting initialization');

            // Destroy existing DataTable if exists
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }

            // Initialize DataTable jika ada data
            if ($('#dataTable').length > 0) {
                try {
                    $('#dataTable').DataTable({
                        "language": {
                            "sProcessing": "Sedang memproses...",
                            "sLengthMenu": "Tampilkan _MENU_ entri",
                            "sZeroRecords": "Tidak ada data yang sesuai",
                            "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                            "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                            "sInfoPostFix": "",
                            "sSearch": "Cari:",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "Pertama",
                                "sPrevious": "Sebelumnya",
                                "sNext": "Selanjutnya",
                                "sLast": "Terakhir"
                            }
                        },
                        "pageLength": 25,
                        "order": [
                            [5, "desc"]
                        ], // Sort by tanggal
                        "columnDefs": [{
                                "orderable": false,
                                "targets": [6]
                            } // Disable sorting on action column
                        ],
                        "responsive": true,
                        "drawCallback": function() {
                            // Re-initialize tooltips and dropdowns after table redraw
                            initializeTooltipsAndDropdowns();
                        }
                    });
                    console.log('DataTable initialized successfully');
                } catch (e) {
                    console.error('DataTable error:', e);
                }
            }

            // Initialize tooltips and dropdowns
            initializeTooltipsAndDropdowns();
        });

        // Function to initialize tooltips and dropdowns
        function initializeTooltipsAndDropdowns() {
            // Initialize tooltips
            if (typeof $('[data-toggle="tooltip"]').tooltip === 'function') {
                $('[data-toggle="tooltip"]').tooltip();
                console.log('Tooltips initialized');
            }

            // Fix dropdown functionality
            $('.dropdown-toggle').off('click.dropdown').on('click.dropdown', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Close other dropdowns
                $('.dropdown-menu').removeClass('show');

                // Toggle current dropdown
                const $dropdown = $(this).next('.dropdown-menu');
                $dropdown.toggleClass('show');

                // Position dropdown
                const rect = this.getBoundingClientRect();
                const dropdownRect = $dropdown[0].getBoundingClientRect();

                // Check if dropdown goes off screen and adjust position
                if (rect.left + dropdownRect.width > window.innerWidth) {
                    $dropdown.addClass('dropdown-menu-right');
                }
            });

            // Close dropdown when clicking outside
            $(document).off('click.dropdown').on('click.dropdown', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // Handle dropdown item clicks
            $('.dropdown-item').off('click.dropdown').on('click.dropdown', function(e) {
                e.preventDefault();
                $(this).closest('.dropdown-menu').removeClass('show');
            });
        }

        // View Detail Function - URL disesuaikan dengan route struktur Anda
        function viewDetail(id) {
            console.log('View detail for ID:', id);

            // Show loading
            $('#detailContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Memuat detail...</p>
        </div>
    `);
            $('#detailModal').modal('show');

            // Ajax call to get detail data - URL disesuaikan dengan route Anda
            $.ajax({
                url: `/fakultas/rekap/prestasi/${id}`, // Sesuaikan dengan route struktur Anda
                type: 'GET',
                timeout: 10000,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
                },
                success: function(response) {
                    $('#detailContent').html(response);
                    console.log('Detail loaded successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Ajax error:', xhr.responseText);
                    let errorMessage = 'Gagal memuat detail publikasi.';

                    if (xhr.status === 404) {
                        errorMessage = 'Data publikasi tidak ditemukan.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Terjadi kesalahan server.';
                    }

                    $('#detailContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Error!</strong> ${errorMessage}
                    <br><small>Status: ${xhr.status}, Error: ${error}</small>
                    <br><small>URL: /fakultas/rekap/publikasi/${id}</small>
                </div>
            `);
                }
            });
        }

        // Copy Link Function - URL disesuaikan
        function copyLink(id) {
            console.log('Copy link for ID:', id);
            const link = `${window.location.origin}/fakultas/rekap/publikasi/${id}`;

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(link).then(function() {
                    showToast('Link berhasil disalin!', 'success');
                    console.log('Link copied via Clipboard API');
                }).catch(function(err) {
                    console.error('Clipboard API error:', err);
                    fallbackCopyTextToClipboard(link);
                });
            } else {
                fallbackCopyTextToClipboard(link);
            }
        }

        // Fallback copy function
        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            textArea.style.opacity = "0";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showToast('Link berhasil disalin!', 'success');
                    console.log('Link copied via fallback method');
                } else {
                    showToast('Gagal menyalin link', 'error');
                }
            } catch (err) {
                console.error('Fallback copy error:', err);
                showToast('Gagal menyalin link', 'error');
            }

            document.body.removeChild(textArea);
        }

        // Export Single Record - URL disesuaikan
        function exportSingle(id) {
            console.log('Export single record for ID:', id);
            const url = `/fakultas/rekap/publikasi/${id}/export`; // Sesuaikan dengan route Anda
            console.log('Opening export URL:', url);
            window.open(url, '_blank');
        }

        // Toast Notification
        function showToast(message, type = 'info') {
            console.log('Showing toast:', message, type);

            const iconMap = {
                'success': 'success',
                'error': 'error',
                'info': 'info',
                'warning': 'warning'
            };

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: iconMap[type] || 'info',
                    title: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                // Fallback to alert if SweetAlert2 not available
                alert(message);
            }
        }

        // Export Functions - Fixed
        function exportToExcel() {
            console.log('Export to Excel');
            showToast('Memulai export Excel...', 'info');

            const params = new URLSearchParams(window.location.search);
            params.set('export', 'excel'); // Use set instead of append to avoid duplicates
            const url = `${window.location.pathname}?${params.toString()}`;

            console.log('Excel export URL:', url);

            // Create a temporary link and trigger download
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', '');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            setTimeout(() => {
                showToast('Export Excel dimulai!', 'success');
            }, 1000);
        }

        function exportToPDF() {
            console.log('Export to PDF');
            showToast('Memulai export PDF...', 'info');

            const params = new URLSearchParams(window.location.search);
            params.set('export', 'pdf'); // Use set instead of append
            const url = `${window.location.pathname}?${params.toString()}`;

            console.log('PDF export URL:', url);

            // Open in new window for PDF
            const newWindow = window.open(url, '_blank');
            if (newWindow) {
                setTimeout(() => {
                    showToast('Export PDF dimulai!', 'success');
                }, 1000);
            } else {
                showToast('Gagal membuka PDF. Periksa popup blocker.', 'error');
            }
        }

        $(document).ready(function() {
            debugInfo();
        });
    </script>
@endsection

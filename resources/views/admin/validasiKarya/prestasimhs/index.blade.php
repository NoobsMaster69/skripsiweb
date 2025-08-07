@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i>
                        Daftar Validasi Dokumen
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-success btn-sm mr-2">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Refresh
                        </button>
                        {{-- <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-download mr-1"></i>
                            Export
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-file-excel mr-2"></i>Excel
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-file-pdf mr-2"></i>PDF
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Prodi</th> <!-- baru -->
                            <th>Fakultas</th> <!-- baru -->
                            <th>Tahun</th>
                            <th>Judul Karya</th>
                            <th>Tingkat</th>
                            <th>Prestasi</th>
                            <th>Tanggal Perolehan</th>
                            <th>Status</th>
                            <th>Lampiran</th>
                            <th>Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasiMahasiswa as $index => $karya)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $karya->nm_mhs }}</td>
                                <td class="text-center">{{ $karya->nim }}</td> <!-- Tambahan NIM -->
                                <td class="text-center">{{ $karya->prodi ?? '-' }}</td> <!-- prodi -->
                                <td class="text-center">{{ $karya->fakultas ?? '-' }}</td> <!-- fakultas -->
                                <td class="text-center">{{ $karya->tahun }}</td>
                                <td>{{ $karya->judul_karya }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $karya->tingkat == 'internasional' ? 'danger' : ($karya->tingkat == 'nasional' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($karya->tingkat) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $karya->prestasi == 'prestasi-akademik' ? 'danger' : ($karya->prestasi == 'prestasi-non-akademik' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($karya->prestasi) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($karya->tanggal_perolehan)->format('d-m-Y') }}
                                </td>

                                <td class="text-center text-white">
                                    @php
                                        echo status_prestasi($karya->status);
                                    @endphp
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info btn-sm px-2 py-1"
                                            style="font-size: 0.75rem;"
                                            onclick="window.open('{{ Storage::url($karya->file_upload) }}', '_blank')">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('validasi-prestasimhs', $karya->id) }}"
                                        class="btn btn-success btn-sm px-2 py-1" style="font-size: 0.75rem;">
                                        <i class="fas fa-check-circle mr-1"></i> Validasi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data karya mahasiswa</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Validasi 1 -->
    {{-- <div class="modal fade" id="validasiModal1" tabindex="-1" role="dialog" aria-labelledby="validasiModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="validasiModalLabel1">
                        <i class="fas fa-check-circle text-success mr-2"></i>
                        Konfirmasi Validasi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                    <p>Yakin ingin memvalidasi dokumen <strong>STATUTA UCIC</strong>?</p>
                    <p class="text-muted small">Setelah divalidasi, status dokumen akan berubah menjadi "Sudah Divalidasi"
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Tidak
                    </button>
                    <a href="{{ route('validasi-prestasimhs') }}" class="btn btn-success"
                        onclick="validasiDokumen(1, 'STATUTA UCIC')">
                        <i class="fas fa-check mr-1"></i> Ya, Validasi
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script>
        function validasiDokumen(id, namaDokumen) {
            // Simulasi proses validasi
            // Dalam implementasi nyata, ini akan mengirim request AJAX ke server

            // Tutup modal
            $(`#validasiModal${id}`).modal('hide');

            // Tampilkan alert sukses
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Dokumen "${namaDokumen}" berhasil divalidasi`,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Reload halaman atau update tampilan
                    location.reload();
                });
            } else {
                // Fallback jika SweetAlert tidak tersedia
                alert(`Dokumen "${namaDokumen}" berhasil divalidasi`);
                location.reload();
            }
        }

        // Fungsi untuk melihat dokumen
        function lihatDokumen(url) {
            window.open(url, '_blank');
        }

        $(document).ready(function() {
            // Initialize DataTable jika diperlukan
            if ($.fn.DataTable) {
                $('#dataTable').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "language": {
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                        "infoFiltered": "(difilter dari _MAX_ total data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            }

            // Refresh button functionality
            $('.btn-success').on('click', function() {
                if ($(this).find('.fa-sync-alt').length > 0) {
                    // Tampilkan loading state
                    const originalHtml = $(this).html();
                    $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> Refreshing...');
                    $(this).prop('disabled', true);

                    // Simulasi delay refresh
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });

            // Hover effects untuk tombol
            $('.btn').hover(
                function() {
                    $(this).addClass('shadow-sm');
                },
                function() {
                    $(this).removeClass('shadow-sm');
                }
            );
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Hindari isi kolom memecah ke bawah */
        .table td,
        .table th {
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }


        /* Agar isi kolom tidak terpotong ke bawah */
        .table th,
        .table td {
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Pastikan scroll horizontal bisa muncul */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 1rem 0.75rem;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
            padding: 1rem 0.75rem;
        }

        .table-bordered {
            border: 1px solid #e3e6f0;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #e3e6f0;
        }

        .badge {
            font-weight: 500;
            border-radius: 4px;
        }

        .badge-pill {
            border-radius: 10rem;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.375rem 0.75rem;
            border-radius: 4px;
        }

        .btn:hover {
            transform: translateY(-1px);
            transition: all 0.15s ease-in-out;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        .modal-header {
            border-bottom: 1px solid #e3e6f0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-header .modal-title {
            font-weight: 600;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
        }

        .modal-header .close:hover {
            opacity: 1;
            color: white;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid #e3e6f0;
            padding: 1rem 2rem;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }

        .btn-info {
            background-color: #36b9cc;
            border-color: #36b9cc;
        }

        .btn-info:hover {
            background-color: #2c9faf;
            border-color: #2c9faf;
        }

        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }

        .btn-secondary:hover {
            background-color: #717384;
            border-color: #717384;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .dropdown-item:hover {
            background-color: #eaecf4;
            color: #3a3b45;
        }

        .text-primary {
            color: #5a5c69 !important;
        }

        .bg-primary {
            background-color: #4e73df !important;
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                margin-bottom: 0.5rem;
                width: 100%;
            }

            .float-right {
                float: none !important;
            }

            .table-responsive {
                font-size: 0.8rem;
            }

            .modal-dialog {
                margin: 1rem;
            }

            .modal-body {
                padding: 1rem;
            }

            .card-header .row {
                flex-direction: column;
            }

            .card-header .col-md-6 {
                margin-bottom: 1rem;
            }
        }

        /* Loading state */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Smooth transitions */
        .btn,
        .badge,
        .modal-content {
            transition: all 0.15s ease-in-out;
        }

        /* Enhanced focus states */
        .btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endpush

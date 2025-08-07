@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user mr-2"></i> {{ $title }}
    </h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table mr-2"></i> Daftar Validasi Buku Kurikulum Prodi
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nomor Dokumen</th>
                        <th>Nama Dokumen</th>
                        <th>Di Upload</th>
                        <th>Tanggal Upload</th>
                        <th>Tanggal Pengesahan</th>
                        <th>Status</th>
                        <th>Lampiran</th>
                        <th>Validasi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($BukuKurikulums as $i => $BukuKurikulum)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>{{ $BukuKurikulum->nomor_dokumen }}</td>
                        <td>{{ $BukuKurikulum->nama_dokumen }}</td>
                        <td class="text-center"> {!! $BukuKurikulum->di_upload !!}</td>
                        <td class="text-center">{{ $BukuKurikulum->tanggal_upload_formatted }}</td>
                        <td class="text-center">{{ $BukuKurikulum->tanggal_pengesahan_formatted ?? '-' }}</td>
                        <td class="text-center text-white">
                                    @php
                                        echo status_prestasi($BukuKurikulum->status);
                                    @endphp
                                </td>
                        <td class="text-center">
                            <a href="{{ $BukuKurikulum->getFileUrl() }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('validasi-bukuKurikulumValid', $BukuKurikulum) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-check-circle"></i> Validasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada dokumen yang perlu divalidasi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
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


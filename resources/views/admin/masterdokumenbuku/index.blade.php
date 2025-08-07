@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Dokumen
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $dokumens->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dokumen PDF
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $dokumens->filter(function ($doc) {return pathinfo($doc->file_path, PATHINFO_EXTENSION) === 'pdf';})->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Dokumen Word
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $dokumens->filter(function ($doc) {
                                        $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                        return in_array($ext, ['doc', 'docx']);
                                    })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-word fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Dokumen Terbaru
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $dokumens->where('created_at', '>=', now()->subDays(30))->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-3">
        <a href="{{ route('master-dokumen-bukuCreate') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Tambah Data
        </a>
    </div>


    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i>
                        Daftar Master Dokumen Buku Kurikulum
                    </h6>
                </div>
                {{-- <div class="col-md-6">
                    <div class="float-right">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Cari dokumen...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="searchBtn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th width="5%">No.</th>
                            <th width="15%">Nomor</th>
                            <th width="30%">Nama Dokumen</th>
                            <th width="20%">File</th>
                            <th width="15%">Tanggal</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumens as $key => $dokumen)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $dokumen->nomor }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            @php
                                                $extension = pathinfo($dokumen->file_path, PATHINFO_EXTENSION);
                                                $iconClass = 'fas fa-file';
                                                $iconColor = 'text-secondary';

                                                if ($extension === 'pdf') {
                                                    $iconClass = 'fas fa-file-pdf';
                                                    $iconColor = 'text-danger';
                                                } elseif (in_array($extension, ['doc', 'docx'])) {
                                                    $iconClass = 'fas fa-file-word';
                                                    $iconColor = 'text-primary';
                                                }
                                            @endphp
                                            <i class="{{ $iconClass }} fa-2x {{ $iconColor }}"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-center">{{ $dokumen->nama }}</div>
                                            @if ($dokumen->keterangan)
                                                <small
                                                    class="text-muted">{{ Str::limit($dokumen->keterangan, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group-vertical">
                                        @if ($dokumen->fileExists())
                                            <a href="{{ route('master-dokumen-buku-kurikulum.view', $dokumen->id) }}"
                                                class="btn btn-outline-info btn-sm mb-1" target="_blank">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>

                                            <a href="{{ route('master-dokumen-buku-kurikulum.download', $dokumen->id) }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-download mr-1"></i> Download
                                            </a>
                                        @else
                                            <span class="badge badge-danger">File tidak ditemukan</span>
                                        @endif
                                    </div>
                                </td>


                                <td class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $dokumen->created_at->timezone('Asia/Jakarta')->format('d/m/Y') }}
                                        <br>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $dokumen->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm"
                                            onclick="showDetail({{ $dokumen->id }})" title="Detail">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <a href="{{ route('master-dokumen-buku.edit', $dokumen->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteDocument({{ $dokumen->id }}, '{{ $dokumen->nama }}')"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data rekognisi dosen</span>
                                    <p class="text-muted">Silakan tambah data karya dosen dengan mengklik tombol "Tambah
                                        Data" di atas.</p>
                                    <a href="{{ route('master-dokumen-bukuCreate') }}"
                                        class="btn btn-sm btn-primary shadow-sm">
                                        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Data Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <!-- Enhanced Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Detail Dokumen
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus dokumen ini?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
                    </div>
                    <div id="deleteDocumentName" class="font-weight-bold"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Search functionality
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#dataTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        // Show detail function with enhanced UI
        function showDetail(id) {
            $('#detailContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat detail dokumen...</p>
        </div>
    `);

            $('#detailModal').modal('show');

            // Load detail via AJAX
            $.ajax({
                url: '{{ route('master-dokumen-buku') }}/' + id + '/detail',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#detailContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.error}
                    </div>
                `);
                        return;
                    }

                    // Get file icon and color based on extension
                    let fileIcon = 'fas fa-file';
                    let fileColor = 'text-secondary';

                    if (response.file_extension === 'pdf') {
                        fileIcon = 'fas fa-file-pdf';
                        fileColor = 'text-danger';
                    } else if (['doc', 'docx'].includes(response.file_extension)) {
                        fileIcon = 'fas fa-file-word';
                        fileColor = 'text-primary';
                    }

                    $('#detailContent').html(`
                <div class="row">
                    <!-- File Preview -->
                    <div class="col-md-4 text-center mb-3">
                        <div class="card bg-light h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <i class="${fileIcon} fa-4x ${fileColor} mb-3"></i>
                                <h6 class="font-weight-bold">${response.nama}</h6>
                                <p class="text-muted small mb-3">
                                    ${response.file_extension.toUpperCase()} Document
                                </p>
                                <div class="btn-group-vertical">
                                    ${response.file_exists ? `
                                                                    <a href="/master-dokumen-buku/${id}/view"
                                                                       target="_blank"
                                                                       class="btn btn-primary btn-sm mb-2">
                                                                        <i class="fas fa-eye mr-1"></i>Lihat
                                                                    </a>
                                                                    <a href="/master-dokumen-buku/${id}/download"
                                                                       class="btn btn-success btn-sm">
                                                                        <i class="fas fa-download mr-1"></i>Download
                                                                    </a>
                                                                ` : `
                                                                    <span class="badge badge-danger">File tidak ditemukan</span>
                                                                `}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Informasi Dokumen
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%" class="font-weight-bold">Nomor:</td>
                                        <td><span class="badge badge-info">${response.nomor}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Nama:</td>
                                        <td>${response.nama}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Format:</td>
                                        <td><span class="badge badge-secondary">${response.file_extension.toUpperCase()}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Ukuran:</td>
                                        <td>${response.formatted_file_size}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%" class="font-weight-bold">Dibuat:</td>
                                        <td><small>${response.created_at}</small></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Diperbarui:</td>
                                        <td><small>${response.updated_at}</small></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Status File:</td>
                                        <td>
                                            ${response.file_exists ?
                                                '<span class="badge badge-success"><i class="fas fa-check mr-1"></i>Tersedia</span>' :
                                                '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Tidak Ada</span>'
                                            }
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        ${response.keterangan ? `
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <h6 class="text-primary border-bottom pb-2 mb-2">
                                                                    <i class="fas fa-comment mr-2"></i>
                                                                    Keterangan
                                                                </h6>
                                                                <p class="text-muted">${response.keterangan}</p>
                                                            </div>
                                                        </div>
                                                    ` : ''}
                    </div>
                </div>
            `);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('#detailContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat detail dokumen. Silakan coba lagi.
                </div>
            `);
                }
            });
        }

        // Delete document function
        function deleteDocument(id, name) {
            $('#deleteDocumentName').text(name);
            $('#deleteForm').attr('action', '{{ route('master-dokumen-buku') }}/' + id);
            $('#deleteModal').modal('show');
        }

        // Show notification function
        function showNotification(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : type === 'info' ? 'alert-info' : 'alert-warning';
            const iconClass = type === 'success' ? 'fa-check-circle' : type === 'info' ? 'fa-info-circle' :
                'fa-exclamation-triangle';

            const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show notification" role="alert">
            <i class="fas ${iconClass} mr-2"></i>
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;

            // Remove existing notifications
            $('.notification').remove();

            // Add new notification
            $('h1.h3').after(notification);

            // Auto-hide after 3 seconds
            setTimeout(function() {
                $('.notification').fadeOut('slow');
            }, 3000);
        }
    </script>
@endsection

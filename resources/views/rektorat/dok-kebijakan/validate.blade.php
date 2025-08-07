@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-clipboard-check mr-2"></i>
            {{ $title }}
        </h1>
        <div>
            <a href="{{ route('dok-rek') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-list mr-1"></i> Lihat Semua Dokumen
            </a>
            <button class="btn btn-success btn-sm" onclick="location.reload()">
                <i class="fas fa-sync mr-1"></i> Refresh
            </button>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Validasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingCount ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                Disetujui Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $approvedToday ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $rejectedToday ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
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
                                Total Dokumen
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalCount ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Validation Card --}}
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-tasks mr-2"></i>
                Dokumen Menunggu Validasi ({{ $pendingCount ?? 0 }})
            </h6>
        </div>

        <div class="card-body">
            @if(isset($pendingDokuments) && $pendingDokuments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nomor Dokumen</th>
                                <th>Nama Dokumen</th>
                                <th>Unit Upload</th>
                                <th>Tanggal Upload</th>
                                <th>Lampiran</th>
                                <th>Aksi Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingDokuments as $index => $dokRek)
                                <tr id="validation-row-{{ $dokRek->id }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center font-weight-bold">{{ $dokRek->nomor_dokumen }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $dokRek->nama_dokumen }}</div>
                                        <small class="text-muted">{{ Str::limit($dokRek->nama_dokumen, 60) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $dokRek->di_upload == 'Rektorat' ? 'primary' : ($dokRek->di_upload == 'Fakultas' ? 'success' : 'info') }}">
                                            {{ $dokRek->di_upload }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($dokRek->tanggal_upload)->format('d/m/Y') }}
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($dokRek->tanggal_upload)->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if ($dokRek->file_path)
                                            <button class="btn btn-info btn-sm"
                                                onclick="window.open('{{ asset($dokRek->file_path) }}', '_blank')">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </button>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button onclick="validateApprove({{ $dokRek->id }}, '{{ $dokRek->nomor_dokumen }}')"
                                                    class="btn btn-success btn-sm" title="Setujui Dokumen">
                                                <i class="fas fa-check mr-1"></i> Setujui
                                            </button>
                                            <button onclick="validateReject({{ $dokRek->id }}, '{{ $dokRek->nomor_dokumen }}')"
                                                    class="btn btn-danger btn-sm" title="Tolak Dokumen">
                                                <i class="fas fa-times mr-1"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($pendingDokuments, 'links'))
                    <div class="d-flex justify-content-center">
                        {{ $pendingDokuments->links() }}
                    </div>
                @endif

            @else
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <h5>Tidak Ada Dokumen yang Perlu Divalidasi</h5>
                        <p>Semua dokumen telah divalidasi atau belum ada dokumen yang diupload.</p>
                        <a href="{{ route('dok-rek') }}" class="btn btn-primary">
                            <i class="fas fa-eye mr-2"></i> Lihat Semua Dokumen
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Rejection Modal --}}
    <div class="modal fade" id="validationRejectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle text-danger mr-2"></i>
                        Tolak Dokumen
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="validationRejectForm">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Dokumen yang akan ditolak:</strong> <span id="validation-reject-doc-number"></span>
                        </div>

                        <div class="form-group">
                            <label for="validation-reason" class="font-weight-bold">
                                <i class="fas fa-comment mr-1"></i> Alasan Penolakan <span class="text-danger">*</span>
                            </label>
                            <textarea name="reason" id="validation-reason" class="form-control" rows="4"
                                      placeholder="Berikan alasan detail mengapa dokumen ditolak..." required></textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Alasan ini akan dilihat oleh unit yang mengupload dokumen untuk perbaikan.
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-lightbulb mr-1"></i> Saran Perbaikan (Opsional)
                            </label>
                            <textarea name="suggestion" class="form-control" rows="3"
                                      placeholder="Berikan saran untuk perbaikan dokumen..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger" id="validationRejectBtn">
                            <i class="fas fa-times mr-1"></i> Tolak Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentValidationId = null;

        // Approve function for validation page
        function validateApprove(id, docNumber) {
            Swal.fire({
                title: 'Setujui Dokumen?',
                html: `
                    <div class="text-center">
                        <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                        <p class="mt-3">Dokumen <strong class="text-primary">${docNumber}</strong> akan disetujui.</p>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check mr-1"></i> Ya, Setujui',
                cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses Persetujuan...',
                        html: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.post(`/dok-rek/${id}/approve`, {
                        _token: '{{ csrf_token() }}'
                    }).done(function(response) {
                        if (response.success) {
                            // Remove row from table
                            $(`#validation-row-${id}`).fadeOut(300, function() {
                                $(this).remove();
                                updateValidationCounts();
                            });

                            Swal.fire({
                                title: 'Berhasil Disetujui!',
                                text: response.message,
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        }
                    }).fail(function(xhr) {
                        let message = 'Terjadi kesalahan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire('Error!', message, 'error');
                    });
                }
            });
        }

        // Reject function for validation page
        function validateReject(id, docNumber) {
            currentValidationId = id;
            $('#validation-reject-doc-number').text(docNumber);
            $('#validationRejectForm')[0].reset();
            $('#validationRejectModal').modal('show');
        }

        // Handle validation reject form submission
        $('#validationRejectForm').submit(function(e) {
            e.preventDefault();

            if (!currentValidationId) return;

            const reason = $(this).find('[name="reason"]').val();
            const suggestion = $(this).find('[name="suggestion"]').val();
            const submitBtn = $('#validationRejectBtn');
            const originalText = submitBtn.html();

            // Combine reason and suggestion
            let fullReason = reason;
            if (suggestion.trim()) {
                fullReason += '\n\nSaran Perbaikan:\n' + suggestion;
            }

            // Disable submit button
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menolak...');

            $.post(`/dok-rek/${currentValidationId}/reject`, {
                _token: '{{ csrf_token() }}',
                reason: fullReason
            }).done(function(response) {
                if (response.success) {
                    $('#validationRejectModal').modal('hide');

                    // Remove row from table
                    $(`#validation-row-${currentValidationId}`).fadeOut(300, function() {
                        $(this).remove();
                        updateValidationCounts();
                    });

                    Swal.fire({
                        title: 'Dokumen Ditolak!',
                        text: response.message,
                        icon: 'success',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                }
            }).fail(function(xhr) {
                let message = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire('Error!', message, 'error');
            }).always(function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(originalText);
            });
        });

        // Update validation counts after approve/reject
        function updateValidationCounts() {
            const remainingRows = $('[id^="validation-row-"]').length;

            // Update counter in header
            $('h6:contains("Dokumen Menunggu Validasi")').html(`
                <i class="fas fa-tasks mr-2"></i>
                Dokumen Menunggu Validasi (${remainingRows})
            `);

            // Show empty state if no more documents
            if (remainingRows === 0) {
                $('.table-responsive').html(`
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                            <h5>Semua Dokumen Sudah Divalidasi!</h5>
                            <p>Tidak ada dokumen yang perlu divalidasi saat ini.</p>
                            <a href="{{ route('dok-rek') }}" class="btn btn-primary">
                                <i class="fas fa-eye mr-2"></i> Lihat Semua Dokumen
                            </a>
                        </div>
                    </div>
                `);
            }
        }

        // Auto-refresh every 2 minutes to check for new documents
        setInterval(function() {
            if ($('[id^="validation-row-"]').length === 0) {
                location.reload();
            }
        }, 120000); // 2 minutes
    </script>
@endsection

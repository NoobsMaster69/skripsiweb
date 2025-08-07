@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i>
            {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('master-dokumen-buku') }}">Master Dokumen</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Master Dokumen Buku Kurikulum</h6>
                    {{-- <a href="{{ route('master-dokumen-buku') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
                    </a> --}}
                </div>

                <div class="card-body">
                    {{-- Alert untuk menampilkan pesan sukses atau error --}}
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

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terdapat kesalahan pada input:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('master-dokumen-buku.store') }}" method="POST" enctype="multipart/form-data"
                        id="masterDokumenForm" novalidate>
                        @csrf

                        <div class="row">
                            {{-- Field Nomor Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nomor" class="form-label">
                                    Nomor Dokumen <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nomor" id="nomor"
                                    class="form-control @error('nomor') is-invalid @enderror" value="{{ old('nomor') }}"
                                    placeholder="Contoh: DOK-001" autocomplete="off" required>
                                @error('nomor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-hashtag mr-1"></i>
                                    Masukkan nomor dokumen yang unik
                                </small>
                            </div>

                            {{-- Field Nama Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">
                                    Nama Dokumen <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                    placeholder="Masukkan nama dokumen" autocomplete="off" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-file-alt mr-1"></i>
                                    Masukkan nama dokumen yang jelas dan deskriptif
                                </small>
                            </div>
                        </div>

                        {{-- Field File Dokumen --}}
                        <div class="form-group mb-3">
                            <label for="file" class="form-label">
                                File Dokumen <span class="text-danger">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" name="file" id="file"
                                    class="custom-file-input @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx"
                                    required>
                                <label class="custom-file-label" for="file">Pilih file...</label>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Format yang diizinkan: PDF, DOC, DOCX. Maksimal 10MB.
                            </small>
                            <div id="file-info" class="mt-2" style="display: none;">
                                <div class="alert alert-info py-2">
                                    <i class="fas fa-file mr-2"></i>
                                    <span id="file-name"></span>
                                    <br>
                                    <small>
                                        <i class="fas fa-weight mr-1"></i>
                                        Ukuran: <span id="file-size"></span>
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Field Keterangan --}}
                        <div class="form-group mb-4">
                            <label for="keterangan" class="form-label">
                                Keterangan <span class="text-muted">(Opsional)</span>
                            </label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                rows="4" placeholder="Masukkan keterangan dokumen (opsional)">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-sticky-note mr-1"></i>
                                Maksimal 1000 karakter
                            </small>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                        <i class="fas fa-save mr-1"></i> <span id="submitText">Simpan</span>
                                    </button>
                                    <a href="{{ route('master-dokumen-buku') }}" class="btn btn-secondary btn-sm ml-2">
                                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                                    </a>
                                </div>
                                <small class="text-muted mt-2 mt-sm-0">
                                    <span class="text-danger">*</span> Field wajib diisi
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar dengan informasi bantuan --}}
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i>
                        Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Nomor Dokumen</h6>
                        <p class="small text-muted mb-2">
                            Masukkan nomor dokumen yang unik. Contoh: DOK-001, REG-2024-001, dst.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Nama Dokumen</h6>
                        <p class="small text-muted mb-2">
                            Berikan nama yang jelas dan deskriptif untuk memudahkan pencarian dokumen.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">File Dokumen</h6>
                        <p class="small text-muted mb-2">
                            Upload file dalam format PDF, DOC, atau DOCX dengan ukuran maksimal 10MB.
                        </p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Pastikan file yang diupload sudah final dan sesuai dengan kebutuhan.
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian:</strong> File yang sudah diupload tidak dapat diubah, hanya bisa diganti dengan
                        file baru.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Custom file input handling
            $('#file').on('change', function() {
                const fileName = this.files[0]?.name || 'Pilih file...';
                const fileSize = this.files[0]?.size || 0;

                $(this).next('.custom-file-label').html(fileName);

                if (this.files[0]) {
                    const fileSizeFormatted = formatFileSize(fileSize);
                    $('#file-name').text(fileName);
                    $('#file-size').text(fileSizeFormatted);
                    $('#file-info').show();

                    // Validate file size
                    if (fileSize > 10 * 1024 * 1024) {
                        showAlert('danger', 'Ukuran file tidak boleh lebih dari 10MB!');
                        $(this).val('');
                        $(this).next('.custom-file-label').html('Pilih file...');
                        $('#file-info').hide();
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }

                    // Validate file type
                    const allowedExtensions = ['pdf', 'doc', 'docx'];
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    if (!allowedExtensions.includes(fileExtension)) {
                        showAlert('danger', 'Format file harus PDF, DOC, atau DOCX!');
                        $(this).val('');
                        $(this).next('.custom-file-label').html('Pilih file...');
                        $('#file-info').hide();
                        $(this).addClass('is-invalid');
                    }
                } else {
                    $('#file-info').hide();
                }
            });

            // Form validation
            $('#masterDokumenForm').on('submit', function(e) {
                let isValid = true;

                // Validate required fields
                $(this).find('[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Additional file validation
                const file = $('#file')[0].files[0];
                if (!file) {
                    $('#file').addClass('is-invalid');
                    showAlert('warning', 'File dokumen wajib dipilih!');
                    isValid = false;
                } else {
                    // Validate file size
                    if (file.size > 10 * 1024 * 1024) {
                        $('#file').addClass('is-invalid');
                        showAlert('danger', 'Ukuran file tidak boleh lebih dari 10MB!');
                        isValid = false;
                    }

                    // Validate file type
                    const allowedTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];
                    if (!allowedTypes.includes(file.type)) {
                        const allowedExtensions = ['pdf', 'doc', 'docx'];
                        const fileExtension = file.name.split('.').pop().toLowerCase();
                        if (!allowedExtensions.includes(fileExtension)) {
                            $('#file').addClass('is-invalid');
                            showAlert('danger', 'Format file harus PDF, DOC, atau DOCX!');
                            isValid = false;
                        }
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                    return false;
                }

                // Show loading state
                $('#submitBtn').prop('disabled', true);
                $('#submitText').text('Menyimpan...');
                $('#submitBtn').find('.fas').removeClass('fa-save').addClass('fa-spinner fa-spin');
            });

            // Reset form
            $('#resetBtn').on('click', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin mereset form?')) {
                    $('#masterDokumenForm')[0].reset();
                    $('#file-info').hide();
                    $('.custom-file-label').html('Pilih file...');
                    $('.alert').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    $('#char-counter').remove();
                }
            });

            // Character counter for keterangan
            $('#keterangan').on('input', function() {
                const maxLength = 1000;
                const currentLength = $(this).val().length;

                if (!$('#char-counter').length) {
                    $(this).siblings('.form-text').after(
                        '<small id="char-counter" class="form-text text-muted mt-1"></small>');
                }

                $('#char-counter').text(`${currentLength}/${maxLength} karakter`);

                if (currentLength > maxLength) {
                    $(this).addClass('is-invalid');
                    $('#char-counter').addClass('text-danger').removeClass('text-muted');
                } else {
                    $(this).removeClass('is-invalid');
                    $('#char-counter').addClass('text-muted').removeClass('text-danger');
                }
            });

            // Remove invalid class when user starts typing
            $('input, textarea').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('is-invalid');
                }
            });

            // Helper function to format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Helper function to show alert
            function showAlert(type, message) {
                const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

                // Remove existing alerts
                $('.alert').remove();

                // Add new alert at the top of card body
                $('.card-body').prepend(alertHtml);

                // Scroll to top
                $('html, body').animate({
                    scrollTop: $('.card').offset().top - 100
                }, 500);

                // Auto-hide after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 5000);
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .form-label {
            color: #5a5c69;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.35rem;
            border: 1px solid #d1d3e2;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .custom-file-label {
            border-radius: 0.35rem;
            border: 1px solid #d1d3e2;
            padding: 0.75rem 1rem;
        }

        .custom-file-input:focus~.custom-file-label {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            border-radius: 0.35rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-warning {
            border-color: #f6c23e;
            color: #f6c23e;
        }

        .btn-outline-warning:hover {
            background-color: #f6c23e;
            border-color: #f6c23e;
            color: #3a3b45;
        }

        .btn-outline-secondary {
            border-color: #858796;
            color: #858796;
        }

        .btn-outline-secondary:hover {
            background-color: #858796;
            border-color: #858796;
        }

        .alert {
            border-radius: 0.35rem;
            border: none;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item a {
            color: #5a5c69;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: #3a3b45;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .text-danger {
            color: #e74a3b !important;
        }

        .text-primary {
            color: #4e73df !important;
        }

        .text-info {
            color: #36b9cc !important;
        }

        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .d-sm-flex {
                flex-direction: column !important;
            }

            .d-sm-flex .breadcrumb {
                margin-top: 1rem;
            }

            .col-lg-4 {
                margin-top: 1rem;
            }
        }
    </style>
@endpush

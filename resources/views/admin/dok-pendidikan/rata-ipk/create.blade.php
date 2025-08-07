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
                <li class="breadcrumb-item"><a href="{{ route('RataIpk') }}">Data Rata-Rata IPK</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Input Data Mahasiswa</h6>
                    {{-- <a href="{{ route('RataIpk') }}" class="btn btn-sm btn-outline-secondary">
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

                    <form action="{{ route('RataIpk.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Field NIM --}}
                            <div class="col-md-6 mb-4">
                                <label for="nim" class="form-label font-weight-bold">
                                    NIM <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nim" id="nim"
                                    class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}"
                                    placeholder="Contoh: 20210120029" maxlength="15" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-id-card mr-1"></i>
                                    Masukkan Nomor Induk Mahasiswa
                                </small>
                            </div>

                            {{-- Field Nama --}}
                            <div class="col-md-6 mb-4">
                                <label for="nama" class="form-label font-weight-bold">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                    placeholder="Contoh: Anisya Hamidah" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-user mr-1"></i>
                                    Masukkan nama lengkap mahasiswa
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Field Prodi --}}
                            <div class="col-md-6 mb-4">
                                <label for="prodi" class="form-label font-weight-bold">
                                    Program Studi <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="prodi" id="prodi"
                                    class="form-control @error('prodi') is-invalid @enderror" value="{{ old('prodi') }}"
                                    placeholder="Masukkan Program Studi" required>
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-keyboard mr-1"></i>
                                    Masukkan nama program studi secara manual
                                </small>
                            </div>


                            {{-- Field Tahun Lulus --}}
                            <div class="col-md-6 mb-4">
                                <label for="tahun_lulus" class="form-label font-weight-bold">
                                    Tahun Lulus <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tahun_lulus" id="tahun_lulus"
                                    class="form-control @error('tahun_lulus') is-invalid @enderror"
                                    value="{{ old('tahun_lulus') }}" placeholder="Contoh: 2022-2023" maxlength="9"
                                    required>
                                @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Format: YYYY-YYYY (contoh: 2022-2023)
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Field Tanggal Lulus --}}
                            <div class="col-md-6 mb-4">
                                <label for="tanggal_lulus" class="form-label font-weight-bold">
                                    Tanggal Lulus <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_lulus" id="tanggal_lulus"
                                    class="form-control @error('tanggal_lulus') is-invalid @enderror"
                                    value="{{ old('tanggal_lulus') }}" required>
                                @error('tanggal_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-calendar-check mr-1"></i>
                                    Pilih tanggal kelulusan mahasiswa
                                </small>
                            </div>

                            {{-- Field IPK --}}
                            <div class="col-md-6 mb-4">
                                <label for="ipk" class="form-label font-weight-bold">
                                    IPK <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="ipk" id="ipk"
                                        class="form-control @error('ipk') is-invalid @enderror"
                                        value="{{ old('ipk') }}" required min="0" max="4"
                                        step="0.01" placeholder="Contoh: 3.98">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-chart-line"></i>
                                        </span>
                                    </div>
                                    @error('ipk')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-star mr-1"></i>
                                    Masukkan nilai IPK (0.00 - 4.00)
                                </small>
                            </div>
                        </div>

                        {{-- Field Predikat --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="predikat" class="form-label font-weight-bold">
                                    Predikat <span class="text-danger">*</span>
                                </label>
                                <select name="predikat" id="predikat"
                                    class="form-control @error('predikat') is-invalid @enderror" required>
                                    <option value="Cum Laude"
                                        {{ old('predikat', $rataIpk->predikat) == 'Cum Laude' ? 'selected' : '' }}>Cum
                                        Laude</option>
                                    <option value="Sangat Memuaskan"
                                        {{ old('predikat', $rataIpk->predikat) == 'Sangat Memuaskan' ? 'selected' : '' }}>
                                        Sangat Memuaskan</option>
                                    <option value="Memuaskan"
                                        {{ old('predikat', $rataIpk->predikat) == 'Memuaskan' ? 'selected' : '' }}>
                                        Memuaskan</option>
                                    <option value="Cukup"
                                        {{ old('predikat', $rataIpk->predikat) == 'Cukup' ? 'selected' : '' }}>Cukup
                                    </option>

                                </select>
                                @error('predikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-award mr-1"></i>
                                    Predikat akan otomatis terisi berdasarkan IPK
                                </small>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm"
                                            style="background-color: #4e73df; color: white;">
                                            <i class="fas fa-save mr-1"></i> Simpan
                                        </button>
                                        <a href="{{ route('RataIpk') }}" class="btn btn-sm ml-2"
                                            style="background-color: #6c757d; color: white;">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                                        </a>
                                    </div>


                                    <div class="text-muted">
                                        <small>
                                            <span class="text-danger">*</span> Field wajib diisi
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar dengan informasi bantuan --}}
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i>
                        Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">NIM</h6>
                        <p class="small text-muted mb-2">
                            Masukkan Nomor Induk Mahasiswa yang terdaftar di sistem akademik.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Program Studi</h6>
                        <p class="small text-muted mb-2">
                            Pilih program studi sesuai dengan yang diambil mahasiswa.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">IPK</h6>
                        <p class="small text-muted mb-2">
                            Masukkan nilai IPK dengan rentang 0.00 - 4.00.
                            Gunakan desimal jika diperlukan (contoh: 3.98).
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Predikat Kelulusan</h6>
                        <ul class="small text-muted mb-2">
                            <li><strong>A (Sangat Memuaskan):</strong> IPK ≥ 3.5</li>
                            <li><strong>B (Memuaskan):</strong> IPK 3.0 - 3.49</li>
                            <li><strong>C (Cukup):</strong> IPK < 3.0</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Predikat akan otomatis disesuaikan ketika Anda mengisi IPK.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-set predikat based on IPK
            $('#ipk').on('input', function() {
                const ipk = parseFloat($(this).val());
                const predikatSelect = $('#predikat');

                if (!isNaN(ipk)) {
                    if (ipk >= 3.5) {
                        predikatSelect.val('A');
                    } else if (ipk >= 3.0) {
                        predikatSelect.val('B');
                    } else if (ipk >= 0) {
                        predikatSelect.val('C');
                    }
                }

                // Validate IPK range
                if (isNaN(ipk) || ipk < 0 || ipk > 4) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Form validation
            $('#mahasiswaForm').on('submit', function(e) {
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

                // Validate NIM format (should be numeric)
                const nim = $('#nim').val();
                if (nim && !/^\d+$/.test(nim)) {
                    $('#nim').addClass('is-invalid');
                    isValid = false;
                }

                // Validate tahun lulus format
                const tahunLulus = $('#tahun_lulus').val();
                const yearPattern = /^\d{4}-\d{4}$/;
                if (tahunLulus && !yearPattern.test(tahunLulus)) {
                    $('#tahun_lulus').addClass('is-invalid');
                    isValid = false;
                }

                // Validate IPK
                const ipk = parseFloat($('#ipk').val());
                if (isNaN(ipk) || ipk < 0 || ipk > 4) {
                    $('#ipk').addClass('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                }
            });

            // Auto-format tahun lulus
            $('#tahun_lulus').on('input', function(e) {
                let value = $(this).val().replace(/\D/g, ''); // Remove non-digits

                // Limit to 8 digits
                if (value.length > 8) {
                    value = value.substring(0, 8);
                }

                // Add dash after 4 digits
                if (value.length >= 4) {
                    value = value.substring(0, 4) + '-' + value.substring(4);
                }

                $(this).val(value);

                // Validation
                const pattern = /^\d{4}-\d{4}$/;
                if (value && !pattern.test(value)) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // NIM validation (numeric only)
            $('#nim').on('input', function() {
                const value = $(this).val();
                if (value && !/^\d+$/.test(value)) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Remove invalid class when user starts typing
            $('input, select, textarea').on('input change', function() {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            border: none;
            border-radius: 10px;
        }

        .form-label {
            color: #5a5c69;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #224abe, #4e73df);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .input-group-text {
            background-color: #f8f9fc;
            border-color: #d1d3e2;
        }

        .text-danger {
            color: #e74a3b !important;
        }

        @media (max-width: 768px) {
            .d-sm-flex {
                flex-direction: column !important;
            }

            .breadcrumb {
                margin-top: 1rem;
            }
        }
    </style>
@endpush

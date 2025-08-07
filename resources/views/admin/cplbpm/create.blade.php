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
                <li class="breadcrumb-item"><a href="{{ route('cpl-bpm') }}">Target Rekognisi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Input Data Target CPL BPM</h6>
                    <a href="{{ route('cpl-bpm') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
                    </a>
                </div>

                <div class="card-body">
                    {{-- Alert untuk menampilkan pesan sukses atau error --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terdapat kesalahan pada input:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('cpl-bpmStore') }}" method="post" id="targetForm" novalidate>
                        @csrf

                        <div class="row">
                            {{-- Field Tahun Akademik --}}
                            <div class="col-md-6 mb-4">
                                <label for="tahun_akademik" class="form-label font-weight-bold">
                                    Tahun Akademik <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="tahun_akademik"
                                       id="tahun_akademik"
                                       class="form-control @error('tahun_akademik') is-invalid @enderror"
                                       value="{{ old('tahun_akademik') }}"
                                       placeholder="Contoh: 2024/2025"
                                       maxlength="9"
                                       required>
                                @error('tahun_akademik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik 8 digit tahun, slash (/) akan ditambahkan otomatis
                                </small>
                            </div>

                            {{-- Field Program Studi --}}
                            <div class="col-md-6 mb-4">
                                <label for="program_studi" class="form-label font-weight-bold">
                                    Program Studi <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="program_studi"
                                       id="program_studi"
                                       class="form-control @error('program_studi') is-invalid @enderror"
                                       value="{{ old('program_studi') }}"
                                       placeholder="Contoh: Teknik Informatika"
                                       required>
                                @error('program_studi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-graduation-cap mr-1"></i>
                                    Masukkan nama program studi lengkap
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Field Mata Kuliah --}}
                            <div class="col-md-6 mb-4">
                                <label for="mata_kuliah" class="form-label font-weight-bold">
                                    Mata Kuliah <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="mata_kuliah"
                                       id="mata_kuliah"
                                       class="form-control @error('mata_kuliah') is-invalid @enderror"
                                       value="{{ old('mata_kuliah') }}"
                                       placeholder="Contoh: Algoritma dan Pemrograman"
                                       required>
                                @error('mata_kuliah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-book mr-1"></i>
                                    Masukkan nama mata kuliah lengkap
                                </small>
                            </div>

                            {{-- Field Target Pencapaian --}}
                            <div class="col-md-6 mb-4">
                                <label for="target_pencapaian" class="form-label font-weight-bold">
                                    Target Pencapaian <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                           name="target_pencapaian"
                                           id="target_pencapaian"
                                           class="form-control @error('target_pencapaian') is-invalid @enderror"
                                           value="{{ old('target_pencapaian') }}"
                                           required
                                           min="0"
                                           max="100"
                                           step="0.01"
                                           placeholder="Contoh: 85.50">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-percentage"></i>
                                        </span>
                                    </div>
                                    @error('target_pencapaian')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-target mr-1"></i>
                                    Masukkan persentase target (0-100)
                                </small>
                            </div>
                        </div>

                        {{-- Field Deskripsi/Keterangan (Opsional) --}}
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="keterangan" class="form-label font-weight-bold">
                                    Keterangan <span class="text-muted">(Opsional)</span>
                                </label>
                                <textarea name="keterangan"
                                          id="keterangan"
                                          class="form-control @error('keterangan') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Tambahkan keterangan atau catatan khusus untuk target ini...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-sticky-note mr-1"></i>
                                    Maksimal 500 karakter
                                </small>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save mr-2"></i>
                                            Simpan Data
                                        </button>
                                        {{-- <button type="reset" class="btn btn-outline-secondary btn-lg ml-2">
                                            <i class="fas fa-undo mr-2"></i>
                                            Reset Form
                                        </button> --}}
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
                        <h6 class="font-weight-bold text-primary">Program Studi</h6>
                        <p class="small text-muted mb-2">
                            Masukkan nama program studi lengkap sesuai dengan yang terdaftar di sistem akademik.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Mata Kuliah</h6>
                        <p class="small text-muted mb-2">
                            Masukkan nama mata kuliah lengkap sesuai dengan kurikulum program studi.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Target Pencapaian</h6>
                        <p class="small text-muted mb-2">
                            Masukkan nilai persentase target keberhasilan (0-100%).
                            Gunakan desimal jika diperlukan (contoh: 85.75%).
                        </p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Pastikan semua data terisi dengan benar sebelum menyimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#targetForm').on('submit', function(e) {
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

        // Validate academic year format
        const tahunAkademik = $('#tahun_akademik').val();
        const academicYearPattern = /^\d{4}\/\d{4}$/;
        if (tahunAkademik && !academicYearPattern.test(tahunAkademik)) {
            $('#tahun_akademik').addClass('is-invalid');
            isValid = false;
        }

        // Validate target percentage
        const targetValue = parseFloat($('#target_pencapaian').val());
        if (isNaN(targetValue) || targetValue < 0 || targetValue > 100) {
            $('#target_pencapaian').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });

    // Auto-format tahun akademik with slash
    $('#tahun_akademik').on('input', function(e) {
        let value = $(this).val().replace(/\D/g, ''); // Remove non-digits

        // Limit to 8 digits
        if (value.length > 8) {
            value = value.substring(0, 8);
        }

        // Add slash after 4 digits
        if (value.length >= 4) {
            value = value.substring(0, 4) + '/' + value.substring(4);
        }

        $(this).val(value);

        // Validation
        const pattern = /^\d{4}\/\d{4}$/;
        if (value && !pattern.test(value)) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Handle paste event for tahun akademik
    $('#tahun_akademik').on('paste', function(e) {
        setTimeout(() => {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length > 8) {
                value = value.substring(0, 8);
            }
            if (value.length >= 4) {
                value = value.substring(0, 4) + '/' + value.substring(4);
            }
            $(this).val(value);
        }, 1);
    });

    // Real-time validation for target percentage
    $('#target_pencapaian').on('input', function() {
        const value = parseFloat($(this).val());
        if (isNaN(value) || value < 0 || value > 100) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Character counter for keterangan
    $('#keterangan').on('input', function() {
        const maxLength = 500;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;

        $(this).next('.invalid-feedback').next('.form-text').html(
            `<i class="fas fa-sticky-note mr-1"></i>${remaining} karakter tersisa`
        );

        if (currentLength > maxLength) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Remove invalid class when user starts typing
    $('input, textarea').on('input', function() {
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
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

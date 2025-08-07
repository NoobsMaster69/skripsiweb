@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i>
            {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('master-cpl') }}">Target Master CPL</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data Target CPL BPM</h6>
                    {{-- <a href="{{ route('master-cpl') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a> --}}
                </div>

                <div class="card-body">
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

                    <form action="{{ route('master-cpl.update', $masterCpl->id) }}" method="POST" id="targetForm" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Tahun Akademik --}}
                            <div class="col-md-6 mb-4">
                                <label for="tahun_akademik" class="form-label font-weight-bold">
                                    Tahun <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tahun_akademik" id="tahun_akademik"
                                    class="form-control @error('tahun_akademik') is-invalid @enderror"
                                    value="{{ old('tahun_akademik', $masterCpl->tahun_akademik) }}"
                                    placeholder="Contoh: 2024/2025" maxlength="9" required>
                                @error('tahun_akademik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik 8 digit tahun, slash (/) akan ditambahkan otomatis
                                </small>
                            </div>

                            {{-- Program Studi --}}
                            <div class="col-md-6 mb-4">
                                <label for="program_studi" class="form-label font-weight-bold">
                                    Program Studi <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="program_studi" id="program_studi"
                                    class="form-control @error('program_studi') is-invalid @enderror"
                                    value="{{ old('program_studi', $masterCpl->program_studi) }}"
                                    placeholder="Contoh: Teknik Informatika" required>
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
                            {{-- Mata Kuliah --}}
                            <div class="col-md-6 mb-4">
                                <label for="mata_kuliah" class="form-label font-weight-bold">
                                    Mata Kuliah <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="mata_kuliah" id="mata_kuliah"
                                    class="form-control @error('mata_kuliah') is-invalid @enderror"
                                    value="{{ old('mata_kuliah', $masterCpl->mata_kuliah) }}"
                                    placeholder="Contoh: Algoritma dan Pemrograman" required>
                                @error('mata_kuliah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-book mr-1"></i>
                                    Masukkan nama mata kuliah lengkap
                                </small>
                            </div>

                            {{-- Target Pencapaian --}}
                            <div class="col-md-6 mb-4">
                                <label for="target_pencapaian" class="form-label font-weight-bold">
                                    Target Pencapaian <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="target_pencapaian" id="target_pencapaian"
                                        class="form-control @error('target_pencapaian') is-invalid @enderror"
                                        value="{{ old('target_pencapaian', $masterCpl->target_pencapaian) }}"
                                        required min="0" max="100" step="0.01" placeholder="Contoh: 85.50">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                    </div>
                                </div>
                                @error('target_pencapaian')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-target mr-1"></i>
                                    Masukkan persentase target (0-100)
                                </small>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="keterangan" class="form-label font-weight-bold">
                                    Keterangan <span class="text-muted">(Opsional)</span>
                                </label>
                                <textarea name="keterangan" id="keterangan"
                                    class="form-control @error('keterangan') is-invalid @enderror"
                                    rows="3" placeholder="Tambahkan keterangan atau catatan khusus untuk target ini...">{{ old('keterangan', $masterCpl->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-sticky-note mr-1"></i>
                                    Maksimal 500 karakter
                                </small>
                            </div>
                        </div>

                        {{-- Action --}}
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="mb-2">
                                <button type="submit" class="btn btn-sm btn-primary mr-2">
                                    <i class="fas fa-save mr-1"></i> Update Data
                                </button>
                                <a href="{{ route('master-cpl') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-times mr-1"></i> Batal
                                </a>
                            </div>
                            <div class="text-right mt-2">
                                <small class="text-muted">
                                    <span class="text-danger">*</span> Field wajib diisi
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Edit
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Program Studi</h6>
                        <p class="small text-muted">Masukkan nama program studi lengkap sesuai sistem.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Mata Kuliah</h6>
                        <p class="small text-muted">Masukkan nama mata kuliah sesuai kurikulum.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Target Pencapaian</h6>
                        <p class="small text-muted">Masukkan nilai dalam bentuk persentase (0–100%).</p>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Pastikan semua data sudah diperiksa sebelum menyimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-format tahun akademik
        $('#tahun_akademik').on('input paste', function(e) {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length > 8) value = value.substring(0, 8);
            if (value.length >= 4) value = value.substring(0, 4) + '/' + value.substring(4);
            $(this).val(value);
        });

        $('#target_pencapaian').on('input', function() {
            const val = parseFloat($(this).val());
            if (isNaN(val) || val < 0 || val > 100) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('#keterangan').on('input', function() {
            const max = 500;
            const len = $(this).val().length;
            if (len > max) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('input, textarea').on('input', function() {
            if ($(this).val().trim() !== '') {
                $(this).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush

@push('styles')
{{-- Styling sama seperti form tambah --}}
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

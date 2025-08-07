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
                <li class="breadcrumb-item"><a href="{{ route('cpl-bpm') }}">Target Rekognisi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data Target CPL BPM</h6>
                    <a href="{{ route('cpl-bpm') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terdapat kesalahan pada input:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cpl-bpm.update', $cplBpm->id) }}" method="POST" id="targetForm">
                        @csrf
                        @method('PUT')

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
                                       value="{{ old('tahun_akademik', $cplBpm->tahun_akademik) }}"
                                       placeholder="Contoh: 2024/2025"
                                       maxlength="9"
                                       required>
                                @error('tahun_akademik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('program_studi', $cplBpm->program_studi) }}"
                                       placeholder="Contoh: Teknik Informatika"
                                       required>
                                @error('program_studi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('mata_kuliah', $cplBpm->mata_kuliah) }}"
                                       placeholder="Contoh: Algoritma dan Pemrograman"
                                       required>
                                @error('mata_kuliah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                           value="{{ old('target_pencapaian', $cplBpm->target_pencapaian) }}"
                                           required
                                           min="0"
                                           max="100"
                                           step="0.01"
                                           placeholder="Contoh: 85.50">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('target_pencapaian')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                          placeholder="Tambahkan keterangan atau catatan khusus untuk target ini...">{{ old('keterangan', $cplBpm->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('cpl-bpm') }}" class="btn btn-outline-secondary mr-2">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar dengan informasi bantuan --}}
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-info">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-info-circle mr-2"></i>
                        Petunjuk Edit
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Silakan ubah data yang diperlukan pada formulir di samping. Pastikan semua kolom yang wajib diisi (<span class="text-danger">*</span>) tidak dikosongkan.
                    </p>
                    <div class="alert alert-light mt-3">
                        <i class="fas fa-lightbulb mr-2 text-warning"></i>
                        <strong>Tips:</strong> Setelah selesai, klik tombol "Update Data" untuk menyimpan perubahan atau "Batal" untuk kembali tanpa menyimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-format tahun akademik with slash
    $('#tahun_akademik').on('input', function(e) {
        let value = $(this).val().replace(/[^\d]/g, '');
        if (value.length > 8) {
            value = value.slice(0, 8);
        }
        if (value.length > 4) {
            value = value.slice(0, 4) + '/' + value.slice(4);
        }
        $(this).val(value);
    });
});
</script>
@endpush

@push('styles')
{{-- Styling dipertahankan dan tidak diubah --}}
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

@extends('layout/app')

@section('content')
<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit mr-2"></i> {{ $title }}
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('peninjauan-kurikulum.index') }}">Peninjauan Kurikulum</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
        </ol>
    </nav>
</div>

<div class="row">
    <!-- Form Edit -->
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header d-flex align-items-center justify-content-between bg-primary">
                <h6 class="m-0 text-white">
                    <i class="fas fa-file-alt mr-2"></i> Form Edit Peninjauan Kurikulum
                </h6>
            </div>
            <div class="card-body">
                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <form action="{{ route('peninjauan-kurikulum.update', $peninjauanKurikulum->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nomor dan Nama Dokumen --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_dokumen" class="font-weight-bold">Nomor Dokumen</label>
                            <input type="text" name="nomor_dokumen"
                                class="form-control @error('nomor_dokumen') is-invalid @enderror"
                                value="{{ old('nomor_dokumen', $peninjauanKurikulum->nomor_dokumen) }}" required>
                            @error('nomor_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_dokumen" class="font-weight-bold">Nama Dokumen</label>
                            <select name="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror" required>
                                <option disabled>-- Pilih Nama Dokumen --</option>
                                @foreach ($masterDokumen as $dokumen)
                                    <option value="{{ $dokumen->nama }}"
                                        {{ old('nama_dokumen', $peninjauanKurikulum->nama_dokumen) == $dokumen->nama ? 'selected' : '' }}>
                                        {{ $dokumen->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Hidden Upload Unit --}}
                    <input type="hidden" name="di_upload" value="Prodi">

                    {{-- Display Upload Unit --}}
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Unit Pengunggah</label>
                        <input type="text" class="form-control" value="Prodi" readonly disabled>
                        <small class="form-text text-muted"><i class="fas fa-university mr-1"></i> Hanya Prodi yang mengunggah</small>
                    </div>

                    {{-- Tanggal Upload & Pengesahan --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_upload" class="font-weight-bold">Tanggal Upload</label>
                            <input type="date" name="tanggal_upload"
                                class="form-control @error('tanggal_upload') is-invalid @enderror"
                                value="{{ old('tanggal_upload', $peninjauanKurikulum->tanggal_upload) }}" required>
                            @error('tanggal_upload')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pengesahan" class="font-weight-bold">Tanggal Pengesahan</label>
                            <input type="date" name="tanggal_pengesahan"
                                class="form-control @error('tanggal_pengesahan') is-invalid @enderror"
                                value="{{ old('tanggal_pengesahan', $peninjauanKurikulum->tanggal_pengesahan) }}">
                            @error('tanggal_pengesahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="form-group mb-4">
                        <label for="lampiran" class="font-weight-bold">
                            <i class="fas fa-paperclip text-primary me-1"></i> Upload Dokumen Pendukung
                        </label>
                        @if($peninjauanKurikulum->file_path)
                            <div class="mb-2">
                                <small class="text-muted">File saat ini: </small>
                                <a href="{{ asset($peninjauanKurikulum->file_path) }}" target="_blank" class="text-primary">
                                    <i class="fas fa-file mr-1"></i> {{ basename($peninjauanKurikulum->file_path) }}
                                </a>
                            </div>
                        @endif
                        <input type="file" name="lampiran" class="form-control @error('lampiran') is-invalid @enderror"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="form-text text-muted mt-1">
                            Format: PDF, DOC, DOCX, JPG, JPEG, PNG | Maks. 10MB
                            @if($peninjauanKurikulum->file_path)
                                <br><span class="text-warning">Kosongkan jika tidak ingin mengganti file</span>
                            @endif
                        </small>
                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="form-group d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update
                        </button>
                        <a href="{{ route('peninjauan-kurikulum.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Panduan -->
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-question-circle mr-2"></i> Panduan Pengisian
                </h6>
            </div>
            <div class="card-body small text-muted">
                <ul class="list-unstyled mb-3">
                    <li><strong>Nomor Dokumen:</strong> Contoh: DOK-PNJ-001</li>
                    <li><strong>Nama Dokumen:</strong> Pilih dari daftar yang tersedia</li>
                    <li><strong>Unit Pengunggah:</strong> Otomatis Prodi</li>
                    <li><strong>Tanggal Upload:</strong> Tanggal saat unggah</li>
                    <li><strong>Tanggal Pengesahan:</strong> Diisi jika tersedia</li>
                    <li><strong>Lampiran:</strong> Kosongkan jika tidak ingin mengubah file</li>
                </ul>
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb mr-1"></i> Pastikan semua data sudah benar sebelum menyimpan perubahan.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

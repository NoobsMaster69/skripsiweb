@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('peninjauan-kurikulum.index') }}">Peninjauan Kurikulum</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt mr-2"></i> Form Input Peninjauan Kurikulum
                    </h6>
                </div>
                <div class="card-body">
                    {{-- Alerts --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

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

                    <form action="{{ route('peninjauan-kurikulum.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Nomor Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nomor_dokumen" class="font-weight-bold">Nomor Dokumen</label>
                                <input type="text" name="nomor_dokumen"
                                    class="form-control @error('nomor_dokumen') is-invalid @enderror"
                                    value="{{ old('nomor_dokumen') }}" placeholder="Contoh: DOK-PNJ-001" required>
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nama_dokumen" class="font-weight-bold">Nama Dokumen</label>
                                <select name="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror"
                                    required>
                                    <option disabled selected>-- Pilih Nama Dokumen --</option>
                                    @foreach ($masterDokumen as $dokumen)
                                        <option value="{{ $dokumen->nama }}"
                                            {{ old('nama_dokumen') == $dokumen->nama ? 'selected' : '' }}>
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

                        {{-- Display Unit --}}
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Unit Pengunggah</label>
                            <input type="text" class="form-control" value="Prodi" readonly disabled>
                            <small class="form-text text-muted"><i class="fas fa-university mr-1"></i> Hanya Prodi yang
                                mengunggah</small>
                        </div>

                        <div class="row">
                            {{-- Tanggal Upload --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_upload" class="font-weight-bold">Tanggal Upload</label>
                                <input type="date" name="tanggal_upload"
                                    class="form-control @error('tanggal_upload') is-invalid @enderror"
                                    value="{{ old('tanggal_upload', date('Y-m-d')) }}" required>
                                @error('tanggal_upload')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Pengesahan --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengesahan" class="font-weight-bold">Tanggal Pengesahan</label>
                                <input type="date" name="tanggal_pengesahan"
                                    class="form-control @error('tanggal_pengesahan') is-invalid @enderror"
                                    value="{{ old('tanggal_pengesahan') }}">
                                @error('tanggal_pengesahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        {{-- <div class="form-group mb-3">
                        <label for="deskripsi" class="font-weight-bold">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" rows="4"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Keterangan isi dokumen">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                        {{-- Upload File --}}
                        <div class="form-group mb-4">
                            <label for="lampiran" class="font-weight-bold">
                                <i class="fas fa-paperclip text-primary me-1"></i> Upload Dokumen
                            </label>
                            <input type="file" name="lampiran"
                                class="form-control @error('lampiran') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">
                                Format file: PDF, DOC, DOCX, JPG, JPEG, PNG (maks. 10MB)
                            </small>
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="form-group d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm" style="background-color: #4e73df; color: white;">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('peninjauan-kurikulum.index') }}" class="btn btn-sm ml-2"
                                style="background-color: #6c757d; color: white;">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar bantuan --}}
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body small text-muted">
                    <ul class="list-unstyled mb-3">
                        <li><strong>Nomor Dokumen:</strong> Kode unik, misal DOK-PNJ-001</li>
                        <li><strong>Nama Dokumen:</strong> Pilih dari daftar master</li>
                        <li><strong>Unit Pengunggah:</strong> Otomatis Prodi</li>
                        <li><strong>Tanggal Upload:</strong> Wajib diisi</li>
                        <li><strong>Tanggal Pengesahan:</strong> Diisi jika ada</li>
                        <li><strong>Deskripsi:</strong> Opsional, penjelasan isi dokumen</li>
                        <li><strong>Lampiran:</strong> File maksimal 10MB</li>
                    </ul>
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-1"></i> Pastikan semua data sudah valid sebelum menyimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

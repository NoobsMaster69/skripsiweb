@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('buku-kurikulumfti') }}">Dokumen Buku Kurikulum</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Dokumen Kurikulum</h6>
                    {{-- <a href="{{ route('buku-kurikulumfti') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a> --}}
                </div>

                <div class="card-body">
                    {{-- Alert --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terdapat kesalahan:</strong>
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

                    <form action="{{ route('buku-kurikulumfti.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Nomor Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nomor_dokumen" class="font-weight-bold">Nomor Dokumen <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nomor_dokumen"
                                    class="form-control @error('nomor_dokumen') is-invalid @enderror"
                                    value="{{ old('nomor_dokumen') }}" placeholder="Contoh: DOK-001" required>
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted"><i class="fas fa-barcode mr-1"></i> Kode unik dokumen
                                    seperti DOK-001</small>
                            </div>

                            {{-- Nama Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nama_dokumen" class="font-weight-bold">Nama Dokumen <span
                                        class="text-danger">*</span></label>
                                <select name="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror"
                                    required>
                                    <option disabled selected>-- Pilih Nama Dokumen --</option>
                                    @foreach ($masterBuku as $dokumen)
                                        <option value="{{ $dokumen->nama }}"
                                            {{ old('nama_dokumen') == $dokumen->nama ? 'selected' : '' }}>
                                            {{ $dokumen->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted"><i class="fas fa-file-alt mr-1"></i> Pilih jenis dokumen
                                    dari daftar</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="di_upload" class="font-weight-bold">Unit Pengunggah <span
                                        class="text-danger">*</span></label>
                                <select name="di_upload" class="form-control" readonly>
                                    <option value="Prodi" selected>Prodi</option>
                                </select>
                                <small class="form-text text-muted"><i class="fas fa-university mr-1"></i> Hanya diisi oleh
                                    Prodi</small>
                            </div>
                        </div>



                        {{-- Tanggal Upload dan Pengesahan --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_upload" class="font-weight-bold">Tanggal Upload <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="tanggal_upload"
                                    class="form-control @error('tanggal_upload') is-invalid @enderror"
                                    value="{{ old('tanggal_upload', date('Y-m-d')) }}" required>
                                @error('tanggal_upload')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted"><i class="fas fa-calendar-alt mr-1"></i> Tanggal unggah
                                    ke sistem</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengesahan" class="font-weight-bold">Tanggal Pengesahan</label>
                                <input type="date" name="tanggal_pengesahan"
                                    class="form-control @error('tanggal_pengesahan') is-invalid @enderror"
                                    value="{{ old('tanggal_pengesahan') }}">
                                @error('tanggal_pengesahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted"><i class="fas fa-stamp mr-1"></i> Isi jika dokumen sudah
                                    disahkan</small>
                            </div>
                        </div>

                        {{-- Upload File --}}
                        <div class="mb-4">
                            <label for="lampiran" class="form-label font-weight-bold">
                                <i class="fas fa-paperclip text-primary mr-1"></i> Upload Dokumen
                            </label>
                            <input type="file" name="lampiran"
                                class="form-control @error('lampiran') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Format file: .pdf, .doc, .docx, .jpg, .jpeg, .png (maks. 10MB)
                            </small>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm" style="background-color: #4e73df; color: white;">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('buku-kurikulumfti') }}" class="btn btn-sm ml-2"
                                style="background-color: #6c757d; color: white;">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar Bantuan --}}
        <div class="col-lg-4">
            <div class="card shadow border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body small">
                    <p><strong>Nomor Dokumen</strong>: Kode dokumen sesuai format internal (contoh: DOK-001)</p>
                    <p><strong>Nama Dokumen</strong>: Pilih dari daftar nama dokumen yang tersedia</p>
                    <p><strong>Unit Pengunggah</strong>: Rektorat, Fakultas, atau Prodi</p>
                    <p><strong>Tanggal Upload</strong>: Tanggal saat dokumen diunggah</p>
                    <p><strong>Tanggal Pengesahan</strong>: Diisi jika dokumen sudah resmi disahkan</p>
                    <p><strong>Lampiran</strong>: File PDF/DOC/Gambar maksimal 10MB</p>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-lightbulb mr-1"></i> Pastikan semua data valid sebelum disimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

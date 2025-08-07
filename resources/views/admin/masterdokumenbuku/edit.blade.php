@extends('layout/app')

@section('content')
    <!-- Header & Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('master-dokumen-buku') }}">Master Dokumen</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Dokumen</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form Edit -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt mr-2"></i> Form Edit Master Dokumen
                    </h6>
                </div>
                <div class="card-body">

                    {{-- Alert Session --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('master-dokumen-buku.update', $dokumen->id) }}" method="POST"
                        enctype="multipart/form-data" id="masterDokumenForm">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nomor">Nomor Dokumen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                    id="nomor" name="nomor" value="{{ old('nomor', $dokumen->nomor) }}"
                                    placeholder="Contoh: DOK-001" required>
                                @error('nomor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nama">Nama Dokumen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama', $dokumen->nama) }}"
                                    placeholder="Masukkan nama dokumen" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if ($dokumen->file_path)
                            <div class="form-group">
                                <label>File Dokumen Saat Ini</label>
                                <div class="alert alert-info py-2">
                                    <i class="fas fa-file mr-2"></i> <strong>{{ basename($dokumen->file_path) }}</strong>
                                    <div class="mt-1">
                                        <a href="{{ asset($dokumen->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        <a href="{{ asset($dokumen->file_path) }}" download
                                            class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-download mr-1"></i> Unduh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="file">File Dokumen Baru (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                    id="file" name="file" accept=".pdf,.doc,.docx">
                                <label class="custom-file-label" for="file">Pilih file baru...</label>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Format: PDF, DOC, DOCX. Maks: 10MB.
                            </small>
                            <div id="file-info" class="mt-2" style="display: none;">
                                <div class="alert alert-warning py-2">
                                    <i class="fas fa-file mr-2"></i> <strong>File Baru:</strong> <span
                                        id="file-name"></span>
                                    <br>
                                    <small><i class="fas fa-weight mr-1"></i> Ukuran: <span id="file-size"></span></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan (Opsional)</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                rows="4" placeholder="Masukkan keterangan">{{ old('keterangan', $dokumen->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-primary btn-sm ml-2" id="submitBtn">
                                    <i class="fas fa-save mr-1"></i> <span id="submitText">Update</span>
                                </button>
                                <a href="{{ route('master-dokumen-buku') }}" class="btn btn-secondary btn-sm ml-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Bantuan -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary font-weight-bold">Nomor Dokumen</h6>
                        <p class="small text-muted">Gunakan format seperti <code>DOK-001</code>. Wajib diisi.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary font-weight-bold">Nama Dokumen</h6>
                        <p class="small text-muted">Contoh: <code>Kebijakan Akademik</code>. Wajib diisi.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary font-weight-bold">File Dokumen Baru</h6>
                        <p class="small text-muted">Kosongkan jika tidak ingin mengganti file yang lama.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary font-weight-bold">Keterangan</h6>
                        <p class="small text-muted">Opsional. Dapat diisi catatan versi atau deskripsi tambahan.</p>
                    </div>
                    <div class="alert alert-info small">
                        <i class="fas fa-lightbulb mr-2"></i> Pastikan semua kolom diisi dengan benar sebelum menyimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

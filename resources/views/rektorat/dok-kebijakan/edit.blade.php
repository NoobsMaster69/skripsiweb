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
                <li class="breadcrumb-item"><a href="{{ route('dok-rek.index') }}">Target Rekognisi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Target CPL BPM</h6>
                </div>

                <div class="card-body">
                    {{-- Alert untuk validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terjadi kesalahan:</strong>
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

                    <form action="{{ route('dok-rek.update', $dokRek->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomor_dokumen">Nomor Dokumen</label>
                                <input type="text" name="nomor_dokumen"
                                    class="form-control @error('nomor_dokumen') is-invalid @enderror"
                                    value="{{ old('nomor_dokumen', $dokRek->nomor_dokumen) }}" required>
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama_dokumen">Nama Dokumen</label>
                                <input type="text" name="nama_dokumen"
                                    class="form-control @error('nama_dokumen') is-invalid @enderror"
                                    value="{{ old('nama_dokumen', $dokRek->nama_dokumen) }}" required>
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="di_upload">Unit Pengunggah</label>
                                <input type="text" class="form-control" name="di_upload" value="Rektorat" readonly>
                                <input type="hidden" name="di_upload" value="Rektorat">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_upload">Tanggal Upload</label>
                                <input type="date" name="tanggal_upload"
                                    class="form-control @error('tanggal_upload') is-invalid @enderror"
                                    value="{{ old('tanggal_upload', optional($dokRek->tanggal_upload)->format('Y-m-d')) }}" required>
                                @error('tanggal_upload')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengesahan">Tanggal Pengesahan</label>
                                <input type="date" name="tanggal_pengesahan"
                                    class="form-control @error('tanggal_pengesahan') is-invalid @enderror"
                                    value="{{ old('tanggal_pengesahan', optional($dokRek->tanggal_pengesahan)->format('Y-m-d')) }}">
                                @error('tanggal_pengesahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                placeholder="Tulis deskripsi dokumen (opsional)">{{ old('deskripsi', $dokRek->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-4">
                            <label for="lampiran" class="form-label font-weight-bold">
                                <i class="fas fa-paperclip text-primary me-1"></i> Upload Dokumen
                            </label>

                            @if($dokRek->file_path)
                                <div class="mb-2">
                                    <small class="text-muted">File saat ini:</small>
                                    <a href="{{ asset($dokRek->file_path) }}" target="_blank" class="text-primary">
                                        <i class="fas fa-file mr-1"></i> {{ basename($dokRek->file_path) }}
                                    </a>
                                </div>
                            @endif

                            <input type="file" name="lampiran"
                                class="form-control @error('lampiran') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">
                                Format file: .pdf, .doc, .docx, .jpg, .jpeg, .png (maks. 10MB)
                                @if($dokRek->file_path)
                                    <br><span class="text-warning">Kosongkan jika tidak ingin mengubah file</span>
                                @endif
                            </small>
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm" style="background-color: #4e73df; color: white;">
                                <i class="fas fa-save mr-1"></i> Update
                            </button>
                            <a href="{{ route('dok-rek.index') }}" class="btn btn-sm ml-2"
                                style="background-color: #6c757d; color: white;">
                                <i class="fas fa-arrow-left mr-1"></i> Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar bantuan --}}
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i>
                        Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3"><strong class="text-primary">Nomor Dokumen</strong>
                        <p class="small text-muted mb-2">Gunakan format internal seperti DOK-001, DOK-002, dst.</p>
                    </div>

                    <div class="mb-3"><strong class="text-primary">Nama Dokumen</strong>
                        <p class="small text-muted mb-2">Diisi sesuai nama dokumen kebijakan yang valid.</p>
                    </div>

                    <div class="mb-3"><strong class="text-primary">Unit Pengunggah</strong>
                        <p class="small text-muted mb-2">Secara otomatis akan terisi sebagai Rektorat.</p>
                    </div>

                    <div class="mb-3"><strong class="text-primary">Tanggal Upload</strong>
                        <p class="small text-muted mb-2">Tanggal dokumen diunggah. Harus diisi.</p>
                    </div>

                    <div class="mb-3"><strong class="text-primary">Tanggal Pengesahan</strong>
                        <p class="small text-muted mb-2">Isi jika dokumen telah disahkan secara resmi.</p>
                    </div>

                    <div class="mb-3"><strong class="text-primary">Deskripsi</strong>
                        <p class="small text-muted mb-2">Opsional. Bisa diisi alasan penolakan atau catatan penting.</p>
                    </div>

                    <div class="mb-3"><strong class="text-primary">Upload Dokumen</strong>
                        <p class="small text-muted mb-2">Format yang diizinkan: PDF, DOC, DOCX, JPG, PNG (maks 10MB).</p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Periksa kembali dokumen sebelum memperbarui data.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

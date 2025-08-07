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
                <li class="breadcrumb-item"><a href="{{ route('dok-rek.index') }}  ">Target Rekognisi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Input Data Target CPL BPM</h6>
                    {{-- <a href="{{ route('dok-rek.index') }} " class="btn btn-sm btn-outline-secondary">
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

                    <form action="{{ route('dok-rek.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomor_dokumen">Nomor Dokumen</label>
                                <input type="text" name="nomor_dokumen"
                                    class="form-control @error('nomor_dokumen') is-invalid @enderror"
                                    value="{{ old('nomor_dokumen') }}" placeholder="Contoh: DOK-001" required>
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama_dokumen">Nama Dokumen</label>
                                <select name="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror"
                                    required>
                                    <option disabled selected>-- Pilih Nama Dokumen --</option>
                                    @foreach ($masterDokumens as $dokumen)
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
                                    value="{{ old('tanggal_upload', date('Y-m-d')) }}" required>
                                @error('tanggal_upload')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengesahan">Tanggal Pengesahan</label>
                                <input type="date" name="tanggal_pengesahan"
                                    class="form-control @error('tanggal_pengesahan') is-invalid @enderror"
                                    value="{{ old('tanggal_pengesahan') }}">
                                @error('tanggal_pengesahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                placeholder="Tulis deskripsi dokumen (opsional)">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-4">
                            <label for="lampiran" class="form-label font-weight-bold">
                                <i class="fas fa-paperclip text-primary me-1"></i> Upload Dokumen
                            </label>
                            <input type="file" name="lampiran"
                                class="form-control @error('lampiran') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">
                                Format file: .pdf, .doc, .docx, .jpg, .jpeg, .png (maks. 10MB)
                            </small>
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm" style="background-color: #4e73df; color: white;">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('dok-rek.index') }}  " class="btn btn-sm ml-2"
                                style="background-color: #6c757d; color: white;">
                                <i class="fas fa-arrow-left mr-1"></i> Batal
                            </a>
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
                        <h6 class="font-weight-bold text-primary">Nomor Dokumen</h6>
                        <p class="small text-muted mb-2">
                            Gunakan kode dokumen sesuai format internal, seperti DOK-001, DOK-002, dst.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Nama Dokumen</h6>
                        <p class="small text-muted mb-2">
                            Pilih dari daftar nama dokumen yang tersedia di sistem.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Unit Pengunggah</h6>
                        <p class="small text-muted mb-2">
                            Tentukan apakah dokumen diunggah oleh Rektorat, Fakultas, atau Prodi.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Tanggal Upload</h6>
                        <p class="small text-muted mb-2">
                            Diisi dengan tanggal dokumen diunggah. Otomatis terisi tanggal hari ini.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Tanggal Pengesahan</h6>
                        <p class="small text-muted mb-2">
                            Diisi jika dokumen sudah sah secara resmi. Bisa dikosongkan jika belum.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Deskripsi</h6>
                        <p class="small text-muted mb-2">
                            Opsional. Berisi informasi tambahan yang relevan dengan dokumen.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Upload Dokumen</h6>
                        <p class="small text-muted mb-2">
                            File maksimal 10MB. Format yang diperbolehkan: PDF, DOC, DOCX, JPG, JPEG, PNG.
                        </p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Pastikan semua data diisi dengan benar sebelum menyimpan.
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

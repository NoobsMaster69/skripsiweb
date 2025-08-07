@extends('layout/app')

@section('content')
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('buku-kurikulumfti') }}">Dokumen Buku Kurikulum</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt mr-2"></i> Form Edit Dokumen Kurikulum
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
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
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

                    <form action="{{ route('buku-kurikulumfti.update', $bukuKurikulum->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nomor Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nomor_dokumen" class="font-weight-bold">Nomor Dokumen <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nomor_dokumen"
                                    class="form-control @error('nomor_dokumen') is-invalid @enderror"
                                    value="{{ old('nomor_dokumen', $bukuKurikulum->nomor_dokumen) }}" required>
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted"><i class="fas fa-barcode mr-1"></i> Format seperti
                                    DOK-001</small>
                            </div>

                            {{-- Nama Dokumen --}}
                            <div class="col-md-6 mb-3">
                                <label for="nama_dokumen" class="font-weight-bold">Nama Dokumen <span
                                        class="text-danger">*</span></label>
                                <select name="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror"
                                    required>
                                    <option disabled>-- Pilih Nama Dokumen --</option>
                                    @foreach ($masterBuku as $dokumen)
                                        <option value="{{ $dokumen->nama }}"
                                            {{ old('nama_dokumen', $bukuKurikulum->nama_dokumen) == $dokumen->nama ? 'selected' : '' }}>
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

                        {{-- Unit Pengunggah --}}
                        <div class="form-group mb-3">
                            <label for="di_upload" class="font-weight-bold">Unit Pengunggah</label>
                            <input type="text" class="form-control" value="Prodi" readonly disabled>
                            <input type="hidden" name="di_upload" value="Prodi">
                        </div>

                        <div class="row">
                            {{-- Tanggal Upload --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_upload" class="font-weight-bold">Tanggal Upload <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="tanggal_upload"
                                    class="form-control @error('tanggal_upload') is-invalid @enderror"
                                    value="{{ old('tanggal_upload', $bukuKurikulum->tanggal_upload ? \Carbon\Carbon::parse($bukuKurikulum->tanggal_upload)->format('Y-m-d') : '') }}"
                                    required>
                                @error('tanggal_upload')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Pengesahan --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengesahan" class="font-weight-bold">Tanggal Pengesahan</label>
                                <input type="date" name="tanggal_pengesahan"
                                    class="form-control @error('tanggal_pengesahan') is-invalid @enderror"
                                    value="{{ old('tanggal_pengesahan', $bukuKurikulum->tanggal_pengesahan ? \Carbon\Carbon::parse($bukuKurikulum->tanggal_pengesahan)->format('Y-m-d') : '') }}">
                                @error('tanggal_pengesahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        {{-- <div class="form-group mb-3">
                        <label for="deskripsi" class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Masukkan deskripsi dokumen (opsional)">{{ old('deskripsi', $bukuKurikulum->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                        {{-- File Lama --}}
                        @if ($bukuKurikulum->file_path)
                            <div class="form-group">
                                <label class="font-weight-bold">File Saat Ini</label>
                                <div class="alert alert-info py-2">
                                    <i class="fas fa-file mr-2"></i>
                                    <strong>{{ basename($bukuKurikulum->file_path) }}</strong>
                                    <div class="mt-2">
                                        <a href="{{ asset($bukuKurikulum->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        <a href="{{ asset($bukuKurikulum->file_path) }}" download
                                            class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-download mr-1"></i> Unduh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Upload Baru --}}
                        <div class="form-group mb-4">
                            <label for="lampiran" class="font-weight-bold">File Dokumen Baru (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" name="lampiran"
                                    class="custom-file-input @error('lampiran') is-invalid @enderror" id="lampiran"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <label class="custom-file-label" for="lampiran">Pilih file baru...</label>
                                @error('lampiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Format: PDF, DOC, DOCX, JPG, PNG. Maks. 10MB.
                            </small>
                        </div>

                        {{-- Tombol --}}
                        <div class="form-group d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-1"></i> Update
                            </button>
                            <a href="{{ route('buku-kurikulumfti') }}" class="btn btn-sm btn-secondary ml-2">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body small">
                    <p><strong>Nomor Dokumen:</strong> Gunakan format seperti DOK-001</p>
                    <p><strong>Nama Dokumen:</strong> Sesuai dokumen kurikulum</p>
                    <p><strong>Tanggal Upload:</strong> Tanggal unggah ke sistem</p>
                    <p><strong>Tanggal Pengesahan:</strong> Isi jika sudah disahkan</p>
                    <p><strong>File Baru:</strong> Kosongkan jika tidak ingin mengganti</p>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-lightbulb mr-1"></i> Pastikan semua data valid sebelum klik
                        <strong>Update</strong>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

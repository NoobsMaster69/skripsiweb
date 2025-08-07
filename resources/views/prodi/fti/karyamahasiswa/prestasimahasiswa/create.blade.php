@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i>{{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('prestasi-mahasiswa-fti') }}">Prestasi Mahasiswa</a>
                </li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-plus mr-2"></i>Form Input Data Prestasi Mahasiswa
                    </h6>
                    {{-- <a href="{{ route('prestasi-mahasiswa-fti') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a> --}}
                </div>

                <div class="card-body">
                    <div class="alert alert-info border-left-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x text-info mr-3"></i>
                            <div>
                                <h6 class="font-weight-bold mb-1">Informasi Penting</h6>
                                <p class="mb-0">Data karya akan ditampilkan pada halaman publikasi setelah diverifikasi
                                    oleh admin.</p>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle mr-2"></i>Terdapat kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('prestasi-mahasiswa-fti.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="nm_mhs" class="font-weight-bold">Nama Lengkap Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nm_mhs" id="nm_mhs"
                                class="form-control @error('nm_mhs') is-invalid @enderror" value="{{ old('nm_mhs') }}"
                                placeholder="Masukkan Nama Lengkap Mahasiswa"required>
                            @error('nm_mhs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Masukan Nama Lengkap Mahasiswa
                            </small>
                        </div>

                        <!-- NIM -->
                        <div class="form-group">
                            <label for="nim" class="font-weight-bold">NIM Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nim" id="nim"
                                class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}"
                                placeholder="Masukkan NIM Mahasiswa" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Masukkan Nomor Induk Mahasiswa yang sesuai
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="prodi" class="font-weight-bold">Program Studi <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="prodi" id="prodi"
                                class="form-control @error('prodi') is-invalid @enderror" value="{{ old('prodi') }}"
                                placeholder="Masukkan Program Studi" required>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- FAKULTAS -->
                        <div class="form-group">
                            <label for="fakultas" class="font-weight-bold">Fakultas <span
                                    class="text-danger">*</span></label>
                            <select name="fakultas" id="fakultas"
                                class="form-control @error('fakultas') is-invalid @enderror" required>
                                <option disabled selected>-- Pilih Fakultas --</option>
                                <option value="FTI" {{ old('fakultas') == 'FTI' ? 'selected' : '' }}>FTI</option>
                                <option value="FEB" {{ old('fakultas') == 'FEB' ? 'selected' : '' }}>FEB</option>
                            </select>
                            @error('fakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun" class="font-weight-bold">Tahun <span class="text-danger">*</span></label>
                            <input type="text" name="tahun" id="tahun"
                                class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}"
                                placeholder="Masukkan Tahun" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Masukan Tahun
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="judul_karya" class="font-weight-bold">Judul Prestasi Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul_karya" id="judul_karya"
                                class="form-control @error('judul_karya') is-invalid @enderror"
                                value="{{ old('judul_karya') }}" placeholder="Masukkan Judul Prestasi Mahasiswa"required>
                            @error('judul_karya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Masukkan judul yang jelas dan spesifik
                            </small>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="tingkat" class="font-weight-bold">Tingkat <span
                                        class="text-danger">*</span></label>
                                <select name="tingkat" id="tingkat"
                                    class="form-control @error('tingkat') is-invalid @enderror"
                                    placeholder="Pilih Tingkatan"required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="local-wilayah"
                                        {{ old('tingkat') == 'local-wilayah' ? 'selected' : '' }}>🏘️ Local/Wilayah
                                    </option>
                                    <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}> 🇮🇩
                                        Nasional</option>
                                    <option value="internasional"
                                        {{ old('tingkat') == 'internasional' ? 'selected' : '' }}> 🌍 Internasional
                                    </option>
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Pilih Tingkatan
                                </small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="prestasi" class="font-weight-bold">Prestasi <span
                                        class="text-danger">*</span></label>
                                <select name="prestasi" id="prestasi"
                                    class="form-control @error('prestasi') is-invalid @enderror"
                                    placeholder="Pilih Prestasi"required>
                                    <option value="">-- Pilih Prestasi --</option>
                                    <option value="prestasi-akademik"
                                        {{ old('prestasi') == 'prestasi-akademik' ? 'selected' : '' }}>🏘️ Prestasi
                                        Akademik
                                    </option>
                                    <option value="prestasi-non-akademik"
                                        {{ old('prestasi') == 'prestasi-non-akademik' ? 'selected' : '' }}> 🌍 Prestasi Non
                                        Akademik
                                    </option>
                                </select>
                                @error('prestasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Pilih Prestasi
                                </small>
                            </div>
                        </div>

                        <!-- TANGGAL PEROLEHAN -->
                        <div class="form-group">
                            <label for="tanggal_perolehan" class="font-weight-bold">Tanggal Perolehan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan"
                                class="form-control @error('tanggal_perolehan') is-invalid @enderror"
                                value="{{ old('tanggal_perolehan') }}" required>
                            @error('tanggal_perolehan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file_upload" class="font-weight-bold">Upload File Prestasi mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="file_upload" id="file_upload"
                                class="form-control-file @error('file_upload') is-invalid @enderror"
                                accept=".pdf,.docx,.jpg,.jpeg" required>
                            <small class="form-text text-muted">
                                Format yang diperbolehkan: PDF, DOCX, JPG, JPEG, PNG (maks 2MB)
                            </small>
                            @error('file_upload')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm" style="background-color: #4e73df; color: white;">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('prestasi-mahasiswa-fti') }}" class="btn btn-sm ml-2"
                                style="background-color: #6c757d; color: white;">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-lightbulb mr-2"></i>Panduan Pengisian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">👨‍🎓 Nama Mahasiswa</h6>
                        <p class="small text-muted">Isi dengan nama lengkap mahasiswa sesuai data akademik kampus.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🆔 NIM</h6>
                        <p class="small text-muted">Masukkan Nomor Induk Mahasiswa yang aktif dan sesuai dengan sistem
                            kampus.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🏫 Program Studi & Fakultas</h6>
                        <p class="small text-muted">Tuliskan nama program studi dan fakultas secara lengkap, contoh: Teknik
                            Informatika, Fakultas Teknologi Informasi.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📅 Tahun</h6>
                        <p class="small text-muted">Masukkan tahun kegiatan atau prestasi diperoleh. Contoh: 2025.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🏆 Judul Prestasi</h6>
                        <p class="small text-muted">Tuliskan judul atau nama prestasi secara jelas dan ringkas.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📌 Tingkat & Jenis Prestasi</h6>
                        <p class="small text-muted">Pilih kategori tingkat (Wilayah/Nasional/Internasional) dan jenis
                            prestasi (Akademik / Non Akademik) yang sesuai.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📆 Tanggal Perolehan</h6>
                        <p class="small text-muted">Tanggal resmi prestasi diperoleh oleh mahasiswa. Format: YYYY-MM-DD.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📎 Lampiran File Prestasi</h6>
                        <p class="small text-muted">Unggah file pendukung seperti sertifikat, surat keterangan,
                            dokumentasi. Format PDF/DOCX/JPG/JPEG maksimal 2MB.</p>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Catatan Penting!</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Pastikan semua data diisi dengan benar sebelum disimpan.</li>
                            <li>File yang tidak sesuai format akan ditolak saat validasi.</li>
                            <li>Data akan ditampilkan setelah diverifikasi oleh admin.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i>{{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('publikasi-mahasiswa-fti') }}">Publikasi Mahasiswa</a>
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
                        <i class="fas fa-file-plus mr-2"></i>Form Input Data Karya Mahasiswa
                    </h6>
                    {{-- <a href="{{ route('publikasi-mahasiswa-fti') }}" class="btn btn-sm btn-outline-secondary">
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

                    <form action="{{ route('publikasi-mahasiswa-fti.store') }}" method="POST"
                        enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label for="nim" class="font-weight-bold">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" id="nim"
                                class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}"
                                placeholder="Masukkan NIM Mahasiswa" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Masukkan NIM sesuai dengan yang terdaftar di kampus
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="prodi" class="font-weight-bold">Program Studi <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="prodi" id="prodi"
                                class="form-control @error('prodi') is-invalid @enderror" value="{{ old('prodi') }}"
                                placeholder="Contoh: Teknik Informatika" required>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Masukan Program Studi yang diinginkan
                            </small>
                        </div>

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
                            <small class="form-text text-muted">
                                Masukan fakultas yang diinginkan
                            </small>
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
                            <label for="judul_karya" class="font-weight-bold">Judul Karya Publikasi <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul_karya" id="judul_karya"
                                class="form-control @error('judul_karya') is-invalid @enderror"
                                value="{{ old('judul_karya') }}" placeholder="Masukkan Judul Karya Publikasi"required>
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
                                <label for="kegiatan" class="font-weight-bold">Jenis Kegiatan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="kegiatan" id="kegiatan" class="form-control"
                                    value="Publikasi Mahasiswa" readonly>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Kegiatan ini bersifat tetap.
                                </small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="jenis_publikasi" class="font-weight-bold">Jenis Publikasi <span
                                        class="text-danger">*</span></label>
                                <select name="jenis_publikasi" id="jenis_publikasi"
                                    class="form-control @error('jenis_publikasi') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Publikasi --</option>
                                    <option value="buku" {{ old('jenis_publikasi') == 'buku' ? 'selected' : '' }}>📘
                                        Buku
                                    </option>
                                    <option value="jurnal_artikel"
                                        {{ old('jenis_publikasi') == 'jurnal_artikel' ? 'selected' : '' }}>📄 Jurnal /
                                        Artikel</option>
                                    <option value="media_massa"
                                        {{ old('jenis_publikasi') == 'media_massa' ? 'selected' : '' }}>📰 Media Massa
                                    </option>
                                </select>
                                @error('jenis_publikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Pilih jenis publikasi karya
                                </small>
                            </div>
                        </div>
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
                            <label for="file_upload" class="font-weight-bold">Upload File Karya Publikasi <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="file_upload" id="file_upload"
                                class="form-control-file @error('file_upload') is-invalid @enderror"
                                accept=".pdf,.docx,.jpg,.jpeg" required>
                            <small class="form-text text-muted">
                                Format yang diperbolehkan: PDF, DOCX, JPG, JPEG (maks 2MB)
                            </small>
                            @error('file_upload')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm" style="background-color: #4e73df; color: white;">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('publikasi-mahasiswa-fti') }}" class="btn btn-sm ml-2"
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
                        <p class="small text-muted">Masukkan nama lengkap mahasiswa sesuai data akademik kampus.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🆔 NIM</h6>
                        <p class="small text-muted">Nomor Induk Mahasiswa yang valid dan terdaftar aktif.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🏫 Program Studi</h6>
                        <p class="small text-muted">Tuliskan nama program studi tempat mahasiswa terdaftar, contoh: Teknik
                            Informatika.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🏢 Fakultas</h6>
                        <p class="small text-muted">Isikan nama fakultas terkait, contoh: Teknologi Informasi.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📅 Tahun</h6>
                        <p class="small text-muted">Tahun kegiatan atau publikasi dilakukan, misal: 2025.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📝 Judul Karya</h6>
                        <p class="small text-muted">Tuliskan judul karya atau publikasi secara lengkap dan spesifik.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📚 Jenis Publikasi</h6>
                        <p class="small text-muted">Pilih jenis publikasi sesuai: Buku, Jurnal/Artikel, atau Media Massa.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📅 Tanggal Perolehan</h6>
                        <p class="small text-muted">Tanggal saat karya dipublikasikan atau disahkan secara resmi.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📁 Upload File</h6>
                        <p class="small text-muted">Unggah file pendukung karya (PDF, DOCX, JPG, JPEG). Maksimum ukuran
                            file 2MB.</p>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Catatan!</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Pastikan semua data sudah diisi dengan benar sebelum menyimpan.</li>
                            <li>Format file: PDF, DOCX, JPG, JPEG</li>
                            <li>Ukuran maksimum file: 2MB</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

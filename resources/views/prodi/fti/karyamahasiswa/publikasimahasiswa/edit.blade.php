@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-warning mr-2"></i>
            Edit {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('publikasi-mahasiswa-fti') }}">Publikasi Mahasiswa</a>
                </li>
                <li class="breadcrumb-item active">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit mr-2"></i>Form Edit Data Publikasi Karya Mahasiswa
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
                                <p class="mb-0">Data publikasi akan ditampilkan setelah diverifikasi oleh admin.</p>
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

                    <form action="{{ route('publikasi-mahasiswa-fti.update', $karya->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="form-group">
                            <label for="nm_mhs" class="font-weight-bold">Nama Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nm_mhs" id="nm_mhs"
                                class="form-control @error('nm_mhs') is-invalid @enderror"
                                value="{{ old('nm_mhs', $karya->nm_mhs) }}" placeholder="Masukkan Nama Mahasiswa" required>
                            @error('nm_mhs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIM -->
                        <div class="form-group">
                            <label for="nim" class="font-weight-bold">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" id="nim"
                                class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim', $karya->nim) }}" placeholder="Masukkan NIM Mahasiswa" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Prodi -->
                        <div class="form-group">
                            <label for="prodi" class="font-weight-bold">Program Studi <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="prodi" id="prodi"
                                class="form-control @error('prodi') is-invalid @enderror"
                                value="{{ old('prodi', $karya->prodi) }}" placeholder="Contoh: Teknik Informatika" required>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fakultas -->
                        <div class="form-group">
                            <label for="fakultas" class="font-weight-bold">Fakultas <span
                                    class="text-danger">*</span></label>
                            <select name="fakultas" id="fakultas"
                                class="form-control @error('fakultas') is-invalid @enderror" required>
                                <option disabled selected>-- Pilih Fakultas --</option>
                                <option value="FTI" {{ old('fakultas', $karya->fakultas) == 'FTI' ? 'selected' : '' }}>
                                    FTI</option>
                                <option value="FEB" {{ old('fakultas', $karya->fakultas) == 'FEB' ? 'selected' : '' }}>
                                    FEB</option>
                            </select>
                            @error('fakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div class="form-group">
                            <label for="tahun" class="font-weight-bold">Tahun <span class="text-danger">*</span></label>
                            <input type="text" name="tahun" id="tahun"
                                class="form-control @error('tahun') is-invalid @enderror"
                                value="{{ old('tahun', $karya->tahun) }}" placeholder="Contoh: 2025" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Judul Karya -->
                        <div class="form-group">
                            <label for="judul_karya" class="font-weight-bold">Judul Karya Publikasi <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul_karya" id="judul_karya"
                                class="form-control @error('judul_karya') is-invalid @enderror"
                                value="{{ old('judul_karya', $karya->judul_karya) }}" placeholder="Masukkan Judul Karya"
                                required>
                            @error('judul_karya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Kegiatan -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="kegiatan" class="font-weight-bold">Jenis Kegiatan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="kegiatan" id="kegiatan" class="form-control"
                                    value="Publikasi Mahasiswa" readonly>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>Kegiatan ini bersifat tetap.
                                </small>
                            </div>

                            <!-- Jenis Publikasi -->
                            <div class="form-group col-md-6">
                                <label for="jenis_publikasi" class="font-weight-bold">Jenis Publikasi <span
                                        class="text-danger">*</span></label>
                                <select name="jenis_publikasi" id="jenis_publikasi"
                                    class="form-control @error('jenis_publikasi') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Publikasi --</option>
                                    <option value="buku"
                                        {{ old('jenis_publikasi', $karya->jenis_publikasi) == 'buku' ? 'selected' : '' }}>
                                        📘 Buku</option>
                                    <option value="jurnal_artikel"
                                        {{ old('jenis_publikasi', $karya->jenis_publikasi) == 'jurnal_artikel' ? 'selected' : '' }}>
                                        📄 Jurnal / Artikel</option>
                                    <option value="media_massa"
                                        {{ old('jenis_publikasi', $karya->jenis_publikasi) == 'media_massa' ? 'selected' : '' }}>
                                        📰 Media Massa</option>
                                </select>
                                @error('jenis_publikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Perolehan -->
                        <div class="form-group">
                            <label for="tanggal_perolehan" class="font-weight-bold">Tanggal Perolehan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan"
                                class="form-control @error('tanggal_perolehan') is-invalid @enderror"
                                value="{{ old('tanggal_perolehan', optional($karya->tanggal_perolehan)->format('Y-m-d')) }}"
                                required>
                            @error('tanggal_perolehan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="form-group">
                            <label for="file_upload" class="font-weight-bold">Upload File Karya</label>
                            <input type="file" name="file_upload" id="file_upload"
                                class="form-control-file @error('file_upload') is-invalid @enderror"
                                accept=".pdf,.docx,.jpg,.jpeg,.png">
                            @error('file_upload')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @if ($karya->file_upload)
                                <small class="form-text text-muted mt-2">
                                    File saat ini:
                                    <a href="{{ Storage::url($karya->file_upload) }}" target="_blank">
                                        {{ Str::after($karya->file_upload, 'karya-mahasiswa/') }}
                                    </a> – Kosongkan jika tidak ingin mengubah file.
                                </small>
                            @endif
                        </div>

                        <!-- Tombol -->
                        <div class="form-group text-left">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('publikasi-mahasiswa-fti') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>Batal
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Panduan -->
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
                        <h6 class="font-weight-bold text-primary">🆔 NIM Mahasiswa</h6>
                        <p class="small text-muted">Masukkan Nomor Induk Mahasiswa aktif yang terdaftar secara resmi.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🏫 Program Studi & Fakultas</h6>
                        <p class="small text-muted">Isi nama program studi dan fakultas sesuai data akademik mahasiswa.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📅 Tahun</h6>
                        <p class="small text-muted">Masukkan tahun pelaksanaan publikasi. Contoh: 2025.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📝 Judul Karya</h6>
                        <p class="small text-muted">Judul karya publikasi harus lengkap dan jelas.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📚 Jenis Publikasi</h6>
                        <p class="small text-muted">Pilih antara Buku, Jurnal/Artikel, atau Media Massa.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📅 Tanggal Perolehan</h6>
                        <p class="small text-muted">Tanggal saat publikasi diperoleh atau diumumkan.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📁 Upload File</h6>
                        <p class="small text-muted">Unggah dokumen karya (PDF, DOCX, JPG, JPEG). Maks: 2MB.</p>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Catatan!</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Pastikan semua data sudah diisi dengan benar.</li>
                            <li>Ukuran file maksimal 2MB.</li>
                            <li>Hanya file: PDF, DOCX, JPG, JPEG, PNG.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

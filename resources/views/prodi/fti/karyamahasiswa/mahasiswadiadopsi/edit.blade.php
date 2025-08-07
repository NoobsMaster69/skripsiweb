@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i>{{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('mahasiswa-diadopsi-fti') }}">Mahasiswa yg diadopsi</a>
                </li>
                <li class="breadcrumb-item active">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form Utama -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit mr-2"></i>Form Edit Data Karya Mahasiswa
                    </h6>
                    {{-- <a href="{{ route('mahasiswa-diadopsi-fti') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a> --}}
                </div>

                <div class="card-body">
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

                    <form action="{{ route('mahasiswa-diadopsi-fti.update', $karya->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="form-group">
                            <label for="nm_mhs" class="font-weight-bold">Nama Lengkap Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nm_mhs" id="nm_mhs"
                                class="form-control @error('nm_mhs') is-invalid @enderror"
                                value="{{ old('nm_mhs', $karya->nm_mhs) }}" placeholder="Masukkan Nama Lengkap Mahasiswa"
                                required>
                            @error('nm_mhs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIM -->
                        <div class="form-group">
                            <label for="nim" class="font-weight-bold">NIM Mahasiswa <span
                                    class="text-danger">*</span></label>
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
                                <option disabled>-- Pilih Fakultas --</option>
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
                                value="{{ old('tahun', $karya->tahun) }}" placeholder="Masukkan Tahun" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Judul Karya -->
                        <div class="form-group">
                            <label for="judul_karya" class="font-weight-bold">Judul Karya Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul_karya" id="judul_karya"
                                class="form-control @error('judul_karya') is-invalid @enderror"
                                value="{{ old('judul_karya', $karya->judul_karya) }}"
                                placeholder="Masukkan Judul Karya Mahasiswa yang diadopsi oleh Masyarakat" required>
                            @error('judul_karya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kegiatan -->
                        <div class="form-group">
                            <label for="kegiatan" class="font-weight-bold">Jenis Kegiatan <span
                                    class="text-danger">*</span></label>
                            <select name="kegiatan" id="kegiatan"
                                class="form-control @error('kegiatan') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Kegiatan --</option>
                                <option value="Produk"
                                    {{ old('kegiatan', $karya->kegiatan) == 'Produk' ? 'selected' : '' }}>📝 Produk
                                </option>
                                <option value="Jasa" {{ old('kegiatan', $karya->kegiatan) == 'Jasa' ? 'selected' : '' }}>
                                    🛠️ Jasa</option>
                            </select>
                            @error('kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                accept=".pdf,.docx,.jpg,.jpeg">
                            @if ($karya->file_upload)
                                <small class="form-text text-muted mt-2">
                                    File saat ini:
                                    <a href="{{ Storage::url($karya->file_upload) }}" target="_blank">
                                        {{ Str::after($karya->file_upload, 'karya-mahasiswa/') }}
                                    </a> – Kosongkan jika tidak ingin mengubah file.
                                </small>
                            @endif
                            @error('file_upload')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="form-group text-left">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('mahasiswa-diadopsi-fti') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Panduan -->
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
                        <p class="small text-muted">Isi dengan nama lengkap mahasiswa sesuai data akademik kampus.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🔢 NIM</h6>
                        <p class="small text-muted">Nomor Induk Mahasiswa aktif dan sesuai kartu mahasiswa kampus.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🏫 Program Studi & Fakultas</h6>
                        <p class="small text-muted">Isi program studi dan fakultas tempat mahasiswa terdaftar. Contoh:
                            Teknik Informatika - FTI.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📅 Tahun</h6>
                        <p class="small text-muted">Masukkan tahun kegiatan dilakukan atau karya diadopsi. Contoh: 2025.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🎯 Judul Karya</h6>
                        <p class="small text-muted">Masukkan judul karya secara lengkap dan jelas yang telah diadopsi
                            masyarakat.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">🔧 Jenis Kegiatan</h6>
                        <p class="small text-muted">Pilih antara <strong>Produk</strong> atau <strong>Jasa</strong> sesuai
                            bentuk karya.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📆 Tanggal Perolehan</h6>
                        <p class="small text-muted">Tanggal resmi saat karya mahasiswa mulai digunakan atau diadopsi oleh
                            masyarakat.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📎 Upload File Karya</h6>
                        <p class="small text-muted">Unggah bukti karya atau dokumen pendukung (PDF, DOCX, JPG, JPEG).
                            Maksimal 2MB.</p>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Catatan Penting:</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Pastikan seluruh data diisi dengan benar dan sesuai dokumen pendukung.</li>
                            <li>File wajib dalam format yang diperbolehkan dan ukuran maksimal 2MB.</li>
                            <li>Data akan ditampilkan di sistem hanya setelah diverifikasi oleh admin.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection

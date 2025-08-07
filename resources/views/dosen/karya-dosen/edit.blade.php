@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i>{{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('karya-dosen.index') }}">Karya Dosen</a></li>
                <li class="breadcrumb-item active">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit mr-2"></i>Form Edit Karya Dosen
                    </h6>
                    {{-- <a href="{{ route('karya-dosen.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a> --}}
                </div>

                <div class="card-body">
                    {{-- Flash Message --}}
                    @if (session('message'))
                        <div class="alert alert-{{ session('message_type', 'success') }} alert-dismissible fade show">
                            <i
                                class="fas fa-{{ session('message_type') == 'success' ? 'check-circle' : 'exclamation-circle' }} mr-2"></i>
                            {!! session('message') !!}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi Kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('karya-dosen.update', $karyaDosen->id) }}" method="POST"
                        enctype="multipart/form-data" id="karyaDosenEditForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nama Dosen -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_dosen" class="font-weight-bold">Nama Dosen <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nama_dosen" id="nama_dosen"
                                        class="form-control @error('nama_dosen') is-invalid @enderror"
                                        value="{{ old('nama_dosen', $karyaDosen->nama_dosen) }}"
                                        placeholder="Masukkan Nama Lengkap Dosen" required>
                                    @error('nama_dosen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-user mr-1"></i>
                                        Masukkan nama lengkap dosen
                                    </small>
                                </div>
                            </div>

                            <!-- Judul Publikasi/Karya -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul_karya" class="font-weight-bold">Judul Publikasi/Karya <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="judul_karya" id="judul_karya"
                                        class="form-control @error('judul_karya') is-invalid @enderror"
                                        value="{{ old('judul_karya', $karyaDosen->judul_karya) }}"
                                        placeholder="Masukkan judul karya/publikasi" required>
                                    @error('judul_karya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-book mr-1"></i>
                                        Masukkan judul karya atau publikasi
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prodi" class="font-weight-bold">Program Studi <span
                                            class="text-danger">*</span></label>
                                    <select name="prodi" id="prodi"
                                        class="form-control @error('prodi') is-invalid @enderror" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        <option value="Teknik Informatika"
                                            {{ old('prodi', $karyaDosen->prodi) == 'Teknik Informatika' ? 'selected' : '' }}>
                                            Teknik
                                            Informatika</option>
                                        <option value="Sistem Informasi"
                                            {{ old('prodi', $karyaDosen->prodi) == 'Sistem Informasi' ? 'selected' : '' }}>
                                            Sistem
                                            Informasi</option>
                                        <option value="DKV"
                                            {{ old('prodi', $karyaDosen->prodi) == 'DKV' ? 'selected' : '' }}>
                                            DKV</option>
                                    </select>
                                    @error('prodi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-graduation-cap mr-1"></i>
                                        Pilih program studi dosen
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fakultas" class="font-weight-bold">Fakultas <span
                                            class="text-danger">*</span></label>
                                    <select name="fakultas" id="fakultas"
                                        class="form-control @error('fakultas') is-invalid @enderror" required>
                                        <option value="">-- Pilih Fakultas --</option>
                                        <option value="FTI"
                                            {{ old('fakultas', $karyaDosen->fakultas) == 'FTI' ? 'selected' : '' }}>FTI
                                        </option>
                                        <option value="FEB"
                                            {{ old('fakultas', $karyaDosen->fakultas) == 'FEB' ? 'selected' : '' }}>FEB
                                        </option>
                                    </select>
                                    @error('fakultas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <!-- Jenis Karya -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_karya" class="font-weight-bold">Jenis Karya <span
                                            class="text-danger">*</span></label>
                                    <select name="jenis_karya" id="jenis_karya"
                                        class="form-control @error('jenis_karya') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis Karya --</option>
                                        <option value="Aplikasi"
                                            {{ old('jenis_karya', $karyaDosen->jenis_karya) == 'Aplikasi' ? 'selected' : '' }}>
                                            💻 Aplikasi</option>
                                        <option value="Publikasi"
                                            {{ old('jenis_karya', $karyaDosen->jenis_karya) == 'Publikasi' ? 'selected' : '' }}>
                                            📚 Publikasi</option>
                                        <option value="Buku"
                                            {{ old('jenis_karya', $karyaDosen->jenis_karya) == 'Buku' ? 'selected' : '' }}>
                                            📖 Buku</option>
                                        <option value="Lainnya"
                                            {{ old('jenis_karya', $karyaDosen->jenis_karya) == 'Lainnya' ? 'selected' : '' }}>
                                            📝 Lainnya</option>
                                    </select>
                                    @error('jenis_karya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-award mr-1"></i>
                                        Pilih kategori jenis karya
                                    </small>
                                </div>
                            </div>

                            <!-- Tahun Pembuatan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_pembuatan" class="font-weight-bold">Tahun Pembuatan <span
                                            class="text-danger">*</span></label>
                                    <select name="tahun_pembuatan" id="tahun_pembuatan"
                                        class="form-control @error('tahun_pembuatan') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach (range(2021, 2025) as $tahun)
                                            <option value="{{ $tahun }}"
                                                {{ old('tahun_pembuatan', $karyaDosen->tahun_pembuatan) == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun_pembuatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Pilih tahun pembuatan karya
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Perolehan -->
                        <div class="form-group">
                            <label for="tanggal_perolehan" class="font-weight-bold">Tanggal Perolehan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan"
                                class="form-control @error('tanggal_perolehan') is-invalid @enderror"
                                value="{{ old('tanggal_perolehan', $karyaDosen->tanggal_perolehan ? \Carbon\Carbon::parse($karyaDosen->tanggal_perolehan)->format('Y-m-d') : '') }}"
                                required>
                            @error('tanggal_perolehan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Karya -->
                        <div class="form-group">
                            <label for="file_karya" class="font-weight-bold">Upload File Karya</label>

                            @if ($karyaDosen->file_karya)
                                <div class="mb-2">
                                    <div class="alert alert-info">
                                        <i class="fas fa-file mr-1"></i>
                                        <strong>File saat ini:</strong> {{ basename($karyaDosen->file_karya) }}
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $karyaDosen->file_karya) }}" target="_blank"
                                                class="btn btn-sm btn-outline-info mr-2">
                                                <i class="fas fa-eye mr-1"></i> Lihat File
                                            </a>
                                            <a href="{{ route('karya-dosen.download', $karyaDosen->id) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-download mr-1"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <input type="file" name="file_karya" id="file_karya"
                                class="form-control-file @error('file_karya') is-invalid @enderror"
                                accept=".pdf,.docx,.jpg,.jpeg,.png,.zip,.rar">
                            <small class="form-text text-muted">
                                <i class="fas fa-file-upload mr-1"></i>
                                Format: PDF, DOCX, JPG, PNG, ZIP, RAR (maksimal 5MB)
                                @if ($karyaDosen->file_karya)
                                    <br><strong>Note:</strong> Kosongkan jika tidak ingin mengubah file
                                @endif
                            </small>
                            @error('file_karya')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        {{-- <div class="form-group">
                            <label for="deskripsi" class="font-weight-bold">Deskripsi Karya</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                rows="3" placeholder="Masukkan deskripsi karya (opsional)">{{ old('deskripsi', $karyaDosen->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-sticky-note mr-1"></i>
                                Deskripsi singkat tentang karya yang dibuat
                            </small>
                        </div> --}}

                        <div class="form-group text-left">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-1"></i>Update Data
                            </button>
                            <a href="{{ route('karya-dosen.index') }}" class="btn btn-sm btn-outline-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>Batal
                            </a>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Panduan Pengisian -->
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-lightbulb mr-2"></i>Panduan Edit
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-user mr-1"></i>
                            Nama Dosen
                        </h6>
                        <p class="small text-muted mb-2">
                            Edit nama lengkap dosen sesuai dengan yang terdaftar di sistem akademik.
                            Pastikan ejaan nama sudah benar.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-book mr-1"></i>
                            Judul Publikasi/Karya
                        </h6>
                        <p class="small text-muted mb-2">
                            Perbarui judul lengkap dari karya, publikasi, aplikasi, atau buku yang dibuat.
                            Contoh: "Sistem Informasi Manajemen Perpustakaan", "Aplikasi Mobile Learning", dll.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-graduation-cap mr-1"></i>
                            Program Studi
                        </h6>
                        <p class="small text-muted mb-2">
                            Pilih program studi tempat dosen mengajar sesuai dengan yang terdaftar di sistem akademik.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-award mr-1"></i>
                            Jenis Karya
                        </h6>
                        <p class="small text-muted mb-2">
                            Pilih kategori jenis karya yang sesuai:
                        </p>
                        <ul class="small text-muted mb-2">
                            <li><strong>Aplikasi:</strong> Software, sistem, mobile app</li>
                            <li><strong>Publikasi:</strong> Jurnal, paper, artikel ilmiah</li>
                            <li><strong>Buku:</strong> Textbook, modul, panduan</li>
                            <li><strong>Lainnya:</strong> Karya kreatif lainnya</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Tahun Pembuatan
                        </h6>
                        <p class="small text-muted mb-2">
                            Pilih tahun saat karya dibuat atau diselesaikan.
                            Rentang tahun yang tersedia: 2021-2025.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-file-upload mr-1"></i>
                            File Karya
                        </h6>
                        <p class="small text-muted mb-2">
                            Upload file karya atau dokumentasi karya yang dibuat.
                            Format yang diterima: PDF, DOCX, JPG, PNG, ZIP, RAR dengan ukuran maksimal 5MB.
                            <strong>Kosongkan jika tidak ingin mengubah file.</strong>
                        </p>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Catatan Edit!</strong>
                        <ul class="mt-2 small mb-0">
                            <li>Pastikan semua data yang wajib (*) telah diisi dengan benar</li>
                            <li>File lama akan terhapus jika upload file baru</li>
                            <li>Ukuran file karya tidak boleh lebih dari 5MB</li>
                            <li>Periksa kembali data sebelum menyimpan</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Tips:</strong>
                        <p class="small mb-0 mt-2">
                            Untuk mengganti file, pilih file baru. Untuk mempertahankan file lama, kosongkan field upload
                            file.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview file name when selected
        document.getElementById('file_karya').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
            console.log('File selected:', fileName);

            // Optional: Show file name preview
            let preview = document.getElementById('file-preview');
            if (!preview) {
                preview = document.createElement('small');
                preview.id = 'file-preview';
                preview.className = 'form-text text-success mt-1';
                e.target.parentNode.appendChild(preview);
            }
            preview.innerHTML = '<i class="fas fa-check mr-1"></i>File baru dipilih: ' + fileName;
        });

        // Form validation
        document.getElementById('karyaDosenEditForm').addEventListener('submit', function(e) {
            const requiredFields = ['nama_dosen', 'judul_karya', 'prodi', 'jenis_karya', 'tahun_pembuatan'];
            let isValid = true;

            requiredFields.forEach(function(fieldName) {
                const field = document.querySelector('[name="' + fieldName + '"]');
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi (*)');
            }
        });
    </script>
@endpush

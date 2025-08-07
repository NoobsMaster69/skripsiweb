@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2"></i>{{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('karya-dosen.index') }}">Karya Dosen</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form Karya Dosen -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-plus mr-2"></i>Form Tambah Karya Dosen
                    </h6>
                    {{-- <a href="{{ route('karya-dosen.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a> --}}
                </div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-{{ session('message_type', 'success') }} alert-dismissible fade show">
                            <i
                                class="fas fa-{{ session('message_type') == 'success' ? 'check-circle' : 'exclamation-circle' }} mr-2"></i>
                            {!! session('message') !!}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

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

                    <form action="{{ route('karya-dosen.store') }}" method="POST" enctype="multipart/form-data"
                        id="karyaDosenForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_dosen" class="font-weight-bold">Nama Dosen <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nama_dosen" id="nama_dosen"
                                        class="form-control @error('nama_dosen') is-invalid @enderror"
                                        value="{{ old('nama_dosen') }}" placeholder="Masukkan Nama Lengkap Dosen" required>
                                    @error('nama_dosen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul_karya" class="font-weight-bold">Judul Publikasi/Karya <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="judul_karya" id="judul_karya"
                                        class="form-control @error('judul_karya') is-invalid @enderror"
                                        value="{{ old('judul_karya') }}" placeholder="Masukkan judul karya/publikasi"
                                        required>
                                    @error('judul_karya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                            <label for="jenis_karya" class="font-weight-bold">Jenis Karya <span
                                    class="text-danger">*</span></label>
                            <select name="jenis_karya" id="jenis_karya"
                                class="form-control @error('jenis_karya') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Karya --</option>
                                <option value="Aplikasi" {{ old('jenis_karya') == 'Aplikasi' ? 'selected' : '' }}>Aplikasi
                                </option>
                                <option value="Publikasi" {{ old('jenis_karya') == 'Publikasi' ? 'selected' : '' }}>
                                    Publikasi</option>
                                <option value="Buku" {{ old('jenis_karya') == 'Buku' ? 'selected' : '' }}>Buku</option>
                                <option value="Lainnya" {{ old('jenis_karya') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            @error('jenis_karya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun_pembuatan" class="font-weight-bold">Tahun <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="tahun_pembuatan" id="tahun_pembuatan"
                                class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                                value="{{ old('tahun_pembuatan') }}" placeholder="Masukkan tahun pembuatan (misal: 2024)"
                                min="2000" max="2100" required>
                            @error('tahun_pembuatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <label for="file_karya" class="font-weight-bold">Upload File Karya</label>
                            <input type="file" name="file_karya" id="file_karya"
                                class="form-control-file @error('file_karya') is-invalid @enderror"
                                accept=".pdf,.docx,.jpg,.jpeg,.png,.zip,.rar">
                            @error('file_karya')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-left">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-1"></i>Simpan Data
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
                        <h6 class="font-weight-bold text-primary">Nama Dosen</h6>
                        <p class="small text-muted mb-2">Masukkan nama lengkap dosen yang memiliki karya atau publikasi.
                        </p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Judul Karya</h6>
                        <p class="small text-muted mb-2">Tulis judul lengkap karya, publikasi, atau aplikasi dengan jelas
                            dan sesuai.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Program Studi & Fakultas</h6>
                        <p class="small text-muted mb-2">Pilih program studi dan isi fakultas sesuai dengan unit akademik
                            dosen.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Jenis Karya</h6>
                        <p class="small text-muted mb-2">Pilih kategori yang sesuai: Aplikasi, Publikasi, Buku, atau
                            Lainnya.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Tahun & Tanggal Perolehan</h6>
                        <p class="small text-muted mb-2">Tahun saat karya dibuat/publikasi terbit, dan tanggal diperolehnya
                            pengakuan.</p>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Unggah file pendukung jika tersedia. Format: .pdf, .docx, .jpg, .zip, .rar.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('file_karya').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
            let preview = document.getElementById('file-preview');
            if (!preview) {
                preview = document.createElement('small');
                preview.id = 'file-preview';
                preview.className = 'form-text text-success mt-1';
                e.target.parentNode.appendChild(preview);
            }
            preview.innerHTML = '<i class="fas fa-check mr-1"></i>File dipilih: ' + fileName;
        });

        document.getElementById('karyaDosenForm').addEventListener('submit', function(e) {
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

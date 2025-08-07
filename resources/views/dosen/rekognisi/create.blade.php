@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2"></i>{{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dosen.rekognisi.index') }}">Rekognisi Dosen</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-plus mr-2"></i>Form Tambah Rekognisi Dosen
                    </h6>
                    {{-- <a href="{{ route('dosen.rekognisi.index') }}" class="btn btn-sm btn-outline-secondary">
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

                    <form action="{{ route('dosen.rekognisi.store') }}" method="POST" enctype="multipart/form-data"
                        id="rekognisiForm">
                        @csrf

                        <div class="form-group">
                            <label for="nama_dosen" class="font-weight-bold">Nama Dosen <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_dosen" id="nama_dosen"
                                class="form-control @error('nama_dosen') is-invalid @enderror"
                                value="{{ old('nama_dosen') }}" placeholder="Masukkan Nama Lengkap Dosen" required>
                            @error('nama_dosen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-graduation-cap mr-1"></i>Masukan Nama
                                Lengkap Dosen</small>
                        </div>

                        <div class="form-group">
                            <label for="nuptk" class="font-weight-bold">NUPTK</label>
                            <input type="text" name="nuptk" id="nuptk"
                                class="form-control @error('nuptk') is-invalid @enderror" value="{{ old('nuptk') }}"
                                placeholder="Masukkan NUPTK (opsional)">
                            @error('nuptk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-graduation-cap mr-1"></i>Masukan NUPTK
                                (opsional)</small>
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
                            <small class="form-text text-muted"><i class="fas fa-info-circle mr-1"></i> Ketik nama program
                                studi dosen</small>
                        </div>


                        <div class="form-group">
                            <label for="bidang_rekognisi" class="font-weight-bold">Bidang Rekognisi <span
                                    class="text-danger">*</span></label>
                            <select name="bidang_rekognisi" id="bidang_rekognisi"
                                class="form-control @error('bidang_rekognisi') is-invalid @enderror" required>
                                <option value="">-- Pilih Bidang Rekognisi --</option>
                                <option value="Pendidikan" {{ old('bidang_rekognisi') == 'Pendidikan' ? 'selected' : '' }}>
                                    🎓 Pendidikan </option>
                                <option value="Pengabdian Masyarakat"
                                    {{ old('bidang_rekognisi') == 'Pengabdian Masyarakat' ? 'selected' : '' }}>🤝
                                    Pengabdian Masyarakat</option>
                                <option value="Penelitian" {{ old('bidang_rekognisi') == 'Penelitian' ? 'selected' : '' }}>
                                    📚 Penelitian</option>
                                <option value="Profesional"
                                    {{ old('bidang_rekognisi') == 'Profesional' ? 'selected' : '' }}>
                                    📚 Profesional</option>
                            </select>
                            @error('bidang_rekognisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun_akademik" class="font-weight-bold">Tahun <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="tahun_akademik" id="tahun_akademik"
                                class="form-control @error('tahun_akademik') is-invalid @enderror"
                                value="{{ old('tahun_akademik') }}" placeholder="Masukkan tahun akademik (misal: 2024)"
                                min="2000" max="2100" required>
                            @error('tahun_akademik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-info-circle mr-1"></i> Tahun akademik dalam
                                format 4 digit, misal: 2024</small>
                        </div>


                        <div class="form-group">
                            <label for="tanggal_rekognisi" class="font-weight-bold">Tanggal Kegiatan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_rekognisi" id="tanggal_rekognisi"
                                class="form-control @error('tanggal_rekognisi') is-invalid @enderror"
                                value="{{ old('tanggal_rekognisi') }}" required>
                            @error('tanggal_rekognisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-calendar-alt mr-1"></i> Pilih Tanggal
                                pelaksanaan kegiatan rekognisi.</small>
                        </div>

                        <div class="form-group">
                            <label for="file_bukti" class="font-weight-bold">Upload File Bukti</label>
                            <input type="file" name="file_bukti" id="file_bukti"
                                class="form-control-file @error('file_bukti') is-invalid @enderror"
                                accept=".pdf,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Format: PDF, DOCX, JPG, PNG (maks 2MB)</small>
                            @error('file_bukti')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-left">
                            <button type="submit" class="btn btn-sm btn-primary mr-2">
                                <i class="fas fa-save mr-1"></i> Simpan Data
                            </button>
                            <a href="{{ route('dosen.rekognisi.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Panduan -->
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-lightbulb mr-2"></i>Panduan Pengisian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">👨‍🏫 Nama Dosen</h6>
                        <p class="small text-muted">Isi sesuai nama lengkap dosen yang terdaftar.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📌 Program Studi</h6>
                        <p class="small text-muted">Pastikan program studi dosen diisi dengan benar.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📂 File Bukti</h6>
                        <p class="small text-muted">Unggah file pendukung kegiatan rekognisi (maksimal 2MB).</p>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i><strong>Catatan!</strong>
                        <ul class="mt-2 small mb-0">
                            <li>Pastikan semua data telah diisi dengan benar</li>
                            <li>Ukuran file tidak boleh lebih dari 2MB</li>
                            <li>Gunakan format file yang diizinkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

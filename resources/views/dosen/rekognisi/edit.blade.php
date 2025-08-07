@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2"></i>{{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dosen.rekognisi.index') }}">Rekognisi Dosen</a></li>
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
                        <i class="fas fa-edit mr-2"></i>Form Edit Rekognisi Dosen
                    </h6>
                    {{-- <a href="{{ route('dosen.rekognisi.index') }}" class="btn btn-sm btn-outline-secondary">
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

                    <form action="{{ route('dosen.rekognisi.update', $rekognisi->id) }}" method="POST"
                        enctype="multipart/form-data" id="rekognisiForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_dosen" class="form-label font-weight-bold">
                                        <i class="fas fa-user mr-1"></i>
                                        Nama Dosen <span class="text-danger">*</span>
                                    </label>
                                    {{-- 2. Value diisi dengan data lama dari database --}}
                                    <input type="text" class="form-control @error('nama_dosen') is-invalid @enderror"
                                        id="nama_dosen" name="nama_dosen"
                                        value="{{ old('nama_dosen', $rekognisi->nama_dosen) }}" required>
                                    @error('nama_dosen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Masukkan nama lengkap dosen
                                    </small>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nuptk" class="form-label font-weight-bold">
                                        <i class="fas fa-id-card mr-1"></i> NUPTK
                                    </label>
                                    <input type="text" class="form-control @error('nuptk') is-invalid @enderror"
                                        id="nuptk" name="nuptk" value="{{ old('nuptk', $rekognisi->nuptk) }}">
                                    @error('nuptk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Boleh dikosongkan jika tidak memiliki NUPTK.
                                    </small>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prodi" class="form-label font-weight-bold">
                                        <i class="fas fa-graduation-cap mr-1"></i> Program Studi <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('prodi') is-invalid @enderror"
                                        id="prodi" name="prodi" value="{{ old('prodi', $rekognisi->prodi) }}"
                                        placeholder="Masukkan Program Studi" required>
                                    @error('prodi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Masukan Program Studi
                                    </small>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bidang_rekognisi" class="font-weight-bold">
                                        <i class="fas fa-award mr-1"></i> Bidang Rekognisi <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="bidang_rekognisi" id="bidang_rekognisi"
                                        class="form-control @error('bidang_rekognisi') is-invalid @enderror" required>
                                        <option value="">-- Pilih Bidang Rekognisi --</option>
                                        <option value="Pendidikan"
                                            {{ old('bidang_rekognisi', $rekognisi->bidang_rekognisi) == 'Pendidikan' ? 'selected' : '' }}>
                                            🎓 Pendidikan</option>
                                        <option value="Pengabdian"
                                            {{ old('bidang_rekognisi', $rekognisi->bidang_rekognisi) == 'Pengabdian' ? 'selected' : '' }}>
                                            🤝 Pengabdian</option>
                                        <option value="Penelitian"
                                            {{ old('bidang_rekognisi', $rekognisi->bidang_rekognisi) == 'Penelitian' ? 'selected' : '' }}>
                                            📚 Penelitian</option>

                                    </select>
                                    @error('bidang_rekognisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Pilih bidang sesuai dengan jenis rekognisi yang diberikan.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_akademik" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar-alt mr-1"></i> Tahun <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control @error('tahun_akademik') is-invalid @enderror"
                                        id="tahun_akademik" name="tahun_akademik"
                                        value="{{ old('tahun_akademik', $rekognisi->tahun_akademik) }}"
                                        placeholder="Masukkan Tahun Akademik" min="2000" max="2100" required>
                                    @error('tahun_akademik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Masukan Tahun Peolehann
                                    </small>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_rekognisi" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar-day mr-1"></i> Tanggal Rekognisi <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" id="tanggal_rekognisi" name="tanggal_rekognisi"
                                        class="form-control @error('tanggal_rekognisi') is-invalid @enderror"
                                        value="{{ old('tanggal_rekognisi', \Carbon\Carbon::parse($rekognisi->tanggal_rekognisi)->format('Y-m-d')) }}"
                                        required>
                                    @error('tanggal_rekognisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="file_bukti" class="form-label font-weight-bold">
                                        <i class="fas fa-file-upload mr-1"></i> Ganti File Bukti
                                    </label>
                                    <div class="custom-file">
                                        {{-- 3. File input tidak lagi 'required' --}}
                                        <input type="file"
                                            class="custom-file-input @error('file_bukti') is-invalid @enderror"
                                            id="file_bukti" name="file_bukti" accept=".pdf,.jpg,.jpeg,.png,.docx">
                                        <label class="custom-file-label" for="file_bukti">Pilih file baru...</label>
                                        @error('file_bukti')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- 3. Menampilkan file yang sudah ada --}}
                                    @if ($rekognisi->file_bukti)
                                        <div class="mt-2">
                                            <p class="mb-0 small text-muted">File saat ini:
                                                <a href="{{ Storage::url($rekognisi->file_bukti) }}" target="_blank">
                                                    <i class="fas fa-file-alt"></i> {{ basename($rekognisi->file_bukti) }}
                                                </a>
                                            </p>
                                        </div>
                                    @endif
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Kosongkan jika tidak ingin mengubah file bukti.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-start">
                                    <button type="submit" class="btn btn-sm btn-primary mr-2">
                                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('dosen.rekognisi.index') }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-times mr-1"></i> Batal
                                    </a>
                                </div>
                            </div>
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
                        <h6 class="font-weight-bold text-primary">📌 Jabatan & Prodi</h6>
                        <p class="small text-muted">Pastikan jabatan dan program studi dosen diisi dengan benar.</p>
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

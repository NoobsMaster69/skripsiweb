@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cpl-dosen') }}">CPL Dosen</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data Target CPL BPM</h6>
                    {{-- <a href="{{ route('cpl-dosen') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a> --}}
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terdapat kesalahan pada input:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cpl-dosen.update', $cplDosen->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold">Tahun Akademik</label>
                            <input type="text" class="form-control" value="{{ $cplDosen->masterCpl->tahun_akademik }}"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Program Studi</label>
                            <input type="text" class="form-control" value="{{ $cplDosen->masterCpl->program_studi }}"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Mata Kuliah</label>
                            <input type="text" class="form-control" value="{{ $cplDosen->masterCpl->mata_kuliah }}"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Target Pencapaian</label>
                            <input type="text" class="form-control"
                                value="{{ $cplDosen->masterCpl->target_pencapaian }}%" readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Ketercapaian (%)</label>
                            <input type="number" name="ketercapaian" min="0" max="100" step="0.1"
                                class="form-control @error('ketercapaian') is-invalid @enderror" placeholder="Contoh: 85.50"
                                value="{{ old('ketercapaian', $cplDosen->ketercapaian) }}">
                            @error('ketercapaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Dokumen Pendukung</label>
                            <input type="file" name="dokumen_pendukung" id="dokumen_pendukung"
                                class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            @error('dokumen_pendukung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Link (Opsional)</label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                                placeholder="Contoh: https://drive.google.com/..."
                                value="{{ old('link', $cplDosen->link) }}">
                            @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan', $cplDosen->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-1"></i>Update Data
                            </button>
                            <a href="{{ route('cpl-dosen') }}" class="btn btn-sm btn-outline-secondary mr-2">
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
                        <i class="fas fa-lightbulb mr-2"></i>Panduan Edit CPL
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-calendar-alt mr-1"></i> Tahun Akademik
                        </h6>
                        <p class="small text-muted mb-2">
                            Ditampilkan otomatis dari data master CPL. Tidak dapat diedit.
                            Contoh format: <code>2024/2025</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-graduation-cap mr-1"></i> Program Studi
                        </h6>
                        <p class="small text-muted mb-2">
                            Nama program studi diambil dari data master. Tidak bisa diubah manual.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-book mr-1"></i> Mata Kuliah
                        </h6>
                        <p class="small text-muted mb-2">
                            Nama mata kuliah yang terhubung dengan CPL. Ditampilkan otomatis dan bersifat readonly.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-bullseye mr-1"></i> Target Pencapaian
                        </h6>
                        <p class="small text-muted mb-2">
                            Target CPL yang ditetapkan oleh institusi. Anda tidak perlu mengubahnya.
                            Contoh: <code>85%</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-chart-line mr-1"></i> Ketercapaian
                        </h6>
                        <p class="small text-muted mb-2">
                            Masukkan capaian aktual dalam persen (0–100). Boleh desimal. Contoh: <code>87.5</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-file-upload mr-1"></i> Dokumen Pendukung
                        </h6>
                        <p class="small text-muted mb-2">
                            Upload dokumen bukti seperti rekap nilai atau berita acara. File yang didukung:
                            PDF, DOC, XLS, JPG, PNG. Ukuran maksimal 5MB. <strong>Kosongkan jika tidak ingin mengubah
                                file.</strong>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-link mr-1"></i> Link Tautan
                        </h6>
                        <p class="small text-muted mb-2">
                            Link opsional ke Google Drive, YouTube, atau sistem lain. Harus diawali dengan
                            <code>https://</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-sticky-note mr-1"></i> Keterangan
                        </h6>
                        <p class="small text-muted mb-2">
                            Masukkan catatan tambahan jika ada (opsional). Maksimal 500 karakter.
                        </p>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Catatan Edit:</strong>
                        <ul class="mt-2 small mb-0">
                            <li>Kolom <code>Ketercapaian</code> disarankan diisi berdasarkan hasil rekapitulasi nilai.</li>
                            <li>File yang baru akan <strong>mengganti file lama</strong>.</li>
                            <li>Periksa kembali data sebelum klik tombol <strong>Update Data</strong>.</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Tips:</strong>
                        <p class="small mb-0 mt-2">
                            Jika tidak ada perubahan file, Anda boleh membiarkan field upload tetap kosong.
                            Sistem akan tetap menyimpan file sebelumnya.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

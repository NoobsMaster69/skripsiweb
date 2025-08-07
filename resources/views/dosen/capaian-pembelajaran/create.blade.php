@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-plus text-primary mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    <div class="row">
        <!-- Form Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data CPL</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('cpl-dosen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="master_cpl_id" value="{{ $masterCpl->id }}">

                        <!-- Master CPL Info -->
                        <div class="form-group">
                            <label class="font-weight-bold">Tahun</label>
                            <input type="text" class="form-control" value="{{ $masterCpl->tahun_akademik }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Program Studi</label>
                            <input type="text" class="form-control" value="{{ $masterCpl->program_studi }}" readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Mata Kuliah</label>
                            <input type="text" class="form-control" value="{{ $masterCpl->mata_kuliah }}" readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Target Pencapaian</label>
                            <input type="text" class="form-control" value="{{ $masterCpl->target_pencapaian }}%"
                                readonly>
                        </div>


                        <!-- Inputan Dosen -->
                        <div class="form-group">
                            <label class="font-weight-bold">Ketercapaian (%)</label>
                            <input type="number" name="ketercapaian" min="0" max="100" step="0.1"
                                class="form-control @error('ketercapaian') is-invalid @enderror" placeholder="Contoh: 85.50"
                                value="{{ old('ketercapaian') }}">
                            <small class="form-text text-muted">Masukkan persentase ketercapaian aktual (0–100%)</small>
                            @error('ketercapaian')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Dokumen Pendukung</label>
                            <input type="file" name="dokumen_pendukung" id="dokumen_pendukung"
                                class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">File PDF/DOC/XLS/JPG maksimal 5MB</small>
                            @error('dokumen_pendukung')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Link (Opsional)</label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                                placeholder="Contoh: https://drive.google.com/..." value="{{ old('link') }}">
                            <small class="form-text text-muted">Link ke file eksternal seperti Google Drive, YouTube,
                                dll</small>
                            @error('link')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan') }}</textarea>
                            <small class="form-text text-muted">Maksimal 500 karakter</small>
                            @error('keterangan')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-1"></i>Simpan Data
                            </button>
                            <a href="{{ route('cpl-dosen') }}" class="btn btn-sm btn-outline-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Bantuan -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-calendar-alt mr-1"></i> Tahun Akademik
                        </h6>
                        <p class="small text-muted">Ditampilkan otomatis dari data master. Format: 2023/2024. Tidak dapat
                            diedit.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-graduation-cap mr-1"></i> Program Studi & Mata Kuliah
                        </h6>
                        <p class="small text-muted">Diambil dari data master CPL. Pastikan sesuai mata kuliah yang Anda
                            ampu.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-bullseye mr-1"></i> Target Pencapaian
                        </h6>
                        <p class="small text-muted">Target yang ditetapkan oleh institusi untuk CPL tersebut. Ditampilkan
                            otomatis.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-chart-line mr-1"></i> Ketercapaian (%)
                        </h6>
                        <p class="small text-muted">
                            Masukkan nilai ketercapaian aktual (dalam persen), berdasarkan evaluasi akhir. Nilai antara
                            0–100. Contoh: <code>85.50</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-file-upload mr-1"></i> Dokumen Pendukung
                        </h6>
                        <p class="small text-muted">
                            Upload bukti seperti rekap nilai, laporan evaluasi, berita acara, dsb.<br>
                            Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG.<br>
                            Ukuran maksimal: 5 MB.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-link mr-1"></i> Link (Opsional)
                        </h6>
                        <p class="small text-muted">
                            Gunakan untuk menyertakan link ke dokumen di Google Drive, YouTube, dsb. Format URL harus valid
                            (diawali dengan <code>https://</code>).
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-sticky-note mr-1"></i> Keterangan (Opsional)
                        </h6>
                        <p class="small text-muted">
                            Berikan catatan tambahan bila perlu, seperti metode evaluasi yang digunakan atau penjelasan
                            khusus lainnya.<br>
                            Maksimal 500 karakter.
                        </p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i> <strong>Tips:</strong> Periksa kembali isian sebelum klik
                        Simpan. Pastikan semua data benar dan lengkap.
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            // Preview file name
            document.getElementById('dokumen_pendukung')?.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
                console.log('File selected:', fileName);
            });

            // Auto format tahun akademik (jika editable)
            const tahunField = document.getElementById('tahun_akademik');
            if (tahunField && !tahunField.readOnly) {
                tahunField.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 4) {
                        value = value.slice(0, 4) + '/' + value.slice(4, 8);
                    }
                    e.target.value = value;
                });
            }
        </script>
    @endpush

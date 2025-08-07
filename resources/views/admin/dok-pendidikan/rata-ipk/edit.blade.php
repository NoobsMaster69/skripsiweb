@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i>
            Edit Data Rata-Rata IPK
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('RataIpk') }}">Data Rata-Rata IPK</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data IPK Mahasiswa</h6>
                    {{-- <a href="{{ route('RataIpk') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
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

                    <form action="{{ route('RataIpk.update', $rataIpk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">NIM <span class="text-danger">*</span></label>
                                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                    value="{{ old('nim', $rataIpk->nim) }}" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $rataIpk->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">Program Studi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="prodi"
                                    class="form-control @error('prodi') is-invalid @enderror"
                                    value="{{ old('prodi', $rataIpk->prodi) }}" required>
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">Tahun Lulus <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="tahun_lulus"
                                    class="form-control @error('tahun_lulus') is-invalid @enderror"
                                    value="{{ old('tahun_lulus', $rataIpk->tahun_lulus) }}" required>
                                @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">Tanggal Lulus <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lulus"
                                    class="form-control @error('tanggal_lulus') is-invalid @enderror"
                                    value="{{ old('tanggal_lulus', optional($rataIpk->tanggal_lulus)->format('Y-m-d')) }}"
                                    required>
                                @error('tanggal_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label font-weight-bold">IPK <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="4" name="ipk"
                                    class="form-control @error('ipk') is-invalid @enderror"
                                    value="{{ old('ipk', $rataIpk->ipk) }}" required>
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label font-weight-bold">Predikat <span
                                        class="text-danger">*</span></label>
                                <select name="predikat" class="form-control @error('predikat') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Predikat --</option>
                                    <option value="A"
                                        {{ old('predikat', $rataIpk->predikat) == 'A' ? 'selected' : '' }}>Sangat Memuaskan
                                        (A)</option>
                                    <option value="B"
                                        {{ old('predikat', $rataIpk->predikat) == 'B' ? 'selected' : '' }}>Memuaskan (B)
                                    </option>
                                    <option value="C"
                                        {{ old('predikat', $rataIpk->predikat) == 'C' ? 'selected' : '' }}>Cukup (C)
                                    </option>
                                </select>

                                @error('predikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-start">
                            <button type="submit" class="btn btn-sm btn-primary mr-2">
                                <i class="fas fa-save mr-1"></i> Update
                            </button>
                            <a href="{{ route('RataIpk') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-info">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-info-circle mr-2"></i>
                        Panduan Edit Data
                    </h6>
                </div>
                <div class="card-body small text-muted">
                    <p><strong>NIM:</strong> Masukkan NIM sesuai data akademik. Contoh: <code>20210120029</code></p>
                    <p><strong>Nama:</strong> Gunakan huruf kapital di awal nama. Contoh: <code>Anisya Hamidah</code></p>
                    <p><strong>Program Studi:</strong> Contoh: <code>Teknik Informatika</code></p>
                    <p><strong>Tahun Lulus:</strong> Format: <code>2024</code></p>
                    <p><strong>Tanggal Lulus:</strong> Pilih tanggal dari kalender</p>
                    <p><strong>IPK:</strong> Nilai antara 0.00 sampai 4.00. Contoh: <code>3.85</code></p>
                    <p><strong>Predikat:</strong></p>
                    <ul class="mb-0">
                        <li><strong>A</strong> – Sangat Memuaskan (≥ 3.5)</li>
                        <li><strong>B</strong> – Memuaskan (3.0 – 3.49)</li>
                        <li><strong>C</strong> – Cukup (&lt; 3.0)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

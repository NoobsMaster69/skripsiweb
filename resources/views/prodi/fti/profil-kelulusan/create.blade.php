@extends('layout/app')

@section('content')
    <!-- Page Heading + Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('prodi-fti') }}">Profil Lulusan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- FORM UTAMA -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Profil Lulusan</h6>
                    {{-- <a href="{{ route('prodi-fti') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('prodi-plStore') }}" method="POST" id="profilForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_pl" class="form-label font-weight-bold">Kode PL <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="kode_pl" id="kode_pl" class="form-control"
                                    placeholder="Contoh: PL01" required>
                                <small class="form-text text-muted">
                                    <i class="fas fa-barcode mr-1"></i> Kode unik, misal: PL01, PL02
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="level_kkni" class="form-label font-weight-bold">Level KKNI <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="level_kkni" id="level_kkni" class="form-control"
                                    placeholder="Contoh: 6" required>
                                <small class="form-text text-muted">
                                    <i class="fas fa-layer-group mr-1"></i> Contoh: 6 (S1), 7 (S2)
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profil_lulusan" class="form-label font-weight-bold">Profil Lulusan (PL) <span
                                    class="text-danger">*</span></label>
                            <textarea name="profil_lulusan" id="profil_lulusan" rows="3" class="form-control"
                                placeholder="Contoh: Lulusan mampu merancang sistem..." required></textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-user-graduate mr-1"></i> Capaian utama lulusan dari program studi.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="aspek" class="form-label font-weight-bold">Aspek <span
                                        class="text-danger">*</span></label>
                                <select name="aspek" id="aspek" class="form-control" required>
                                    <option disabled selected>-- Pilih Aspek --</option>
                                    <option value="Pengetahuan">Pengetahuan</option>
                                    <option value="Keterampilan Khusus">Keterampilan Khusus</option>
                                    <option value="Sikap">Sikap</option>
                                    <option value="Keterampilan Umum">Keterampilan Umum</option>
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb mr-1"></i> Pilih kategori aspek lulusan.
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="profesi" class="form-label font-weight-bold">Profesi <span
                                        class="text-danger">*</span></label>
                                <select name="profesi" id="profesi" class="form-control" required>
                                    <option disabled selected>-- Pilih Profesi --</option>
                                    <option value="E-Commerce Spesialist">E-Commerce Spesialist</option>
                                    <option value="Media Social Specialist">Media Social Specialist</option>
                                    <option value="Technopreneurship">Technopreneurship</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Staff Marketing">Staff Marketing</option>
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fas fa-briefcase mr-1"></i> Pilih profesi utama yang relevan.
                                </small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <a href="{{ route ('prodi-fti') }}" class="btn btn-secondary btn-sm mr-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save mr-1"></i> Simpan Data
                                </button>
                            </div>
                            <small class="text-muted"><span class="text-danger">*</span> Wajib diisi</small>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- SIDEBAR BANTUAN -->
        <div class="col-xl-4">
            <div class="card shadow border-left-info">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body small">
                    <p><strong>Kode PL</strong>: Kode unik profil lulusan (misal: PL01, PL02)</p>
                    <p><strong>Profil Lulusan</strong>: Capaian utama lulusan dari program studi</p>
                    <p><strong>Aspek</strong>: Pilih kategori seperti Pengetahuan, Sikap, dsb</p>
                    <p><strong>Profesi</strong>: Pilih jenis profesi yang sesuai</p>
                    <p><strong>Level KKNI</strong>: Contoh: 6 untuk S1, 7 untuk S2</p>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Pastikan data lengkap sebelum disimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

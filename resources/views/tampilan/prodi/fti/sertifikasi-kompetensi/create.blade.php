@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus mr-2"></i> {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('setif-kompetensi-fti') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="#" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="thn_akademik" class="form-label">Tahun Akademik</label>
                        <input type="text" name="thn_akademik" id="thn_akademik" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="di_upload" class="form-label">Prodi</label>
                        <select name="di_upload" id="di_upload" class="form-control" required>
                            <option disabled selected>-- Pilih Prodi --</option>
                            <option value="Rektorat">Rektorat</option>
                            <option value="Fakultas">Fakultas</option>
                            <option value="Prodi">Prodi</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nm_mhs" class="form-label">Nama Mahasiswa</label>
                        <input type="text" name="nm_mhs" id="nm_mhs" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="level" class="form-label">Level</label>
                        <select name="level" id="level" class="form-control" required>
                            <option disabled selected>-- Pilih Level --</option>
                            <option value="local-wilayah">Local/Wilayah</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                    </div>
                </div>

                <!-- Tambah Upload File -->
                <div class="mb-4">
                    <label for="file_upload" class="form-label font-weight-bold d-block">
                        <i class="fas fa-paperclip text-primary me-2"></i> Upload Dokumen Pendukung
                    </label>
                    <input type="file" name="file_upload" id="file_upload" class="form-control"
                        style="padding: 10px; height: 48px;" required>
                    <small class="form-text text-muted mt-1">
                        Format: .pdf, .docx, .jpg | Maks. ukuran 2MB
                    </small>
                </div>

                <div class="mb-4">
                    <label for="Deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="Deskripsi" id="Deskripsi" class="form-control" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

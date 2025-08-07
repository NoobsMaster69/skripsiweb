@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('target-rek') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('dok-rekStore') }}" method="post">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nomor_dokumen" class="form-label">Nomor Dokumen</label>
                        <input type="text" name="nomor_dokumen" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="di_upload" class="form-label">Di Upload Oleh</label>
                    <select name="di_upload" class="form-control" required>
                        <option disabled selected>-- Pilih Unit --</option>
                        <option value="Rektorat">Rektorat</option>
                        <option value="Fakultas">Fakultas</option>
                        <option value="Prodi">Prodi</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal_upload" class="form-label">Tanggal Upload</label>
                        <input type="date" name="tanggal_upload" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_pengesahan" class="form-label">Tanggal Pengesahan</label>
                        <input type="date" name="tanggal_pengesahan" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option disabled selected>-- Pilih Status --</option>
                        <option value="belum">Belum Di Validasi</option>
                        <option value="sudah">Sudah Di Validasi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="validasi" class="form-label">Validasi</label>
                    <select name="validasi" class="form-control" required>
                        <option disabled selected>-- Pilih Validasi --</option>
                        <option value="valid">✔ Validasi</option>
                        <option value="tidak">✖ Tidak Valid</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

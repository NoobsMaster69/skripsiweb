@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('RataMT-fti') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali</a>
        </div>
        <div class="card-body">
            <form action="#" method="post">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="kode_pl" class="form-label">Kode PL</label>
                        <input type="text" name="kode_pl" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" name="nim" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pekerjaan_rata" class="form-label">Pekerjaan</label>
                        <input type="text" name="nm_dosen" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nm_Perusahaan_rata" class="form-label">Nama Perusahaan</label>
                        <input type="text" name="nm_Perusahaan_rata" class="form-control" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="rata_masa_tunggu" class="form-label">Rata-rata Masa Tunggu</label>
                    <input type="text" name="rata_masa_tunggu" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

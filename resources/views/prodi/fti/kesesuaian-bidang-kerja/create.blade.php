@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('kesesuaian-fti') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali</a>
        </div>
        <div class="card-body">
            <form action="#" method="post">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="kode_dok" class="form-label">Kode Dok</label>
                        <input type="text" name="kode_dok" class="form-control" required>
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
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nm_Perusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" name="nm_Perusahaan" class="form-control" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="kesesuaian" class="form-label">kesesuaian Bidang Kerja</label>
                    <input type="text" name="kesesuaian" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

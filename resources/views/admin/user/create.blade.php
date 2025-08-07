@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user') }}">Data User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Form Input -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Input Data User</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Terdapat kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('userStore') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="nama" class="form-label font-weight-bold">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama') }}" required
                                    placeholder="Contoh: Anisya Hamidah">
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted"><i class="fas fa-user mr-1"></i> Masukkan nama lengkap user.</small>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label font-weight-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required
                                    placeholder="Contoh: anisya@gmail.com">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted"><i class="fas fa-envelope mr-1"></i> Masukkan email aktif dan unik.</small>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="jabatan" class="form-label font-weight-bold">Jabatan <span class="text-danger">*</span></label>
                            <select name="jabatan" id="jabatan"
                                class="form-control @error('jabatan') is-invalid @enderror" required>
                                <option disabled selected value="">--- Pilih Jabatan ---</option>
                                <option value="admin" {{ old('jabatan') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="rektorat" {{ old('jabatan') == 'rektorat' ? 'selected' : '' }}>Rektorat</option>
                                <option value="fakultas" {{ old('jabatan') == 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                                <option value="dosen" {{ old('jabatan') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="prodi" {{ old('jabatan') == 'prodi' ? 'selected' : '' }}>Prodi</option>
                            </select>
                            @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted"><i class="fas fa-briefcase mr-1"></i> Pilih peran user sesuai tugasnya.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label font-weight-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required placeholder="Contoh: rahasia123">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted"><i class="fas fa-lock mr-1"></i> Gunakan minimal 8 karakter kombinasi angka dan huruf.</small>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label font-weight-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required placeholder="Ulangi password di atas">
                                <small class="form-text text-muted"><i class="fas fa-key mr-1"></i> Harus sesuai dengan password di atas.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Simpan
                                </button>
                                <a href="{{ route('user') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                            <small class="text-muted"><span class="text-danger">*</span> Wajib diisi</small>
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
                        <i class="fas fa-info-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Nama</h6>
                        <p class="small text-muted">Masukkan nama lengkap user sesuai identitas.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Email</h6>
                        <p class="small text-muted">Gunakan email yang valid dan aktif.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Jabatan</h6>
                        <p class="small text-muted">Pilih peran user dalam sistem, sesuai dengan hak aksesnya.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">Password</h6>
                        <p class="small text-muted">Gunakan kombinasi angka dan huruf untuk keamanan.</p>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>Tips:</strong> Pastikan email tidak duplikat untuk menghindari konflik login.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

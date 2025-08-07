@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('viewKK-fti') }}">Profil Lulusan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data KK</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Keterampilan Khusus</h6>
                </div>

                <div class="card-body">
                    {{-- Alert --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

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

                    <form action="{{ route('kkStore') }}" method="POST">
                        @csrf

                        {{-- CPL SN-DIKTI --}}
                        <div class="form-group">
                            <label for="kode" class="font-weight-bold">CPL SN-DIKTI <span class="text-danger">*</span></label>
                            <input type="text" name="kode" id="kode"
                                class="form-control @error('kode') is-invalid @enderror"
                                value="{{ old('kode') }}"
                                placeholder="Contoh: KK-01" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label for="deskripsi" class="font-weight-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" id="deskripsi"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="3"
                                placeholder="Contoh: Mampu mengimplementasikan algoritma kompleks dalam pengembangan perangkat lunak."
                                required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sumber --}}
                        <div class="form-group">
                            <label for="sumber" class="font-weight-bold">Sumber <span class="text-danger">*</span></label>
                            <input type="text" name="sumber" id="sumber"
                                class="form-control @error('sumber') is-invalid @enderror"
                                value="{{ old('sumber') }}"
                                placeholder="Contoh: SN-DIKTI" required>
                            @error('sumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <a href="{{ route('viewKK-fti') }}" class="btn btn-secondary btn-sm mr-2">
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

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card shadow border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Pengisian
                    </h6>
                </div>
                <div class="card-body small">
                    <p><strong>CPL SN-DIKTI</strong>: Kode untuk keterampilan khusus (contoh: KK-01)</p>
                    <p><strong>Deskripsi</strong>: Penjabaran ringkas kompetensi khusus lulusan</p>
                    <p><strong>Sumber</strong>: Misal: SN-DIKTI, University Value, dsb.</p>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-lightbulb mr-1"></i> Pastikan semua field diisi lengkap dan valid.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

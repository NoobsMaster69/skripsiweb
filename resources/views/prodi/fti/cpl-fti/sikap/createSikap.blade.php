@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('viewSikap-fti') }}">Profil Lulusan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data Sikap</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Sikap</h6>
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

                    <form action="{{ route('sikapStore') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="kode" class="form-label font-weight-bold">CPL SN-DIKTI <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" placeholder="Contoh: PL-01"  required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-barcode mr-1"></i> Contoh: PL-01</small>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label font-weight-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Masukan Deskripsi"  required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-align-left mr-1"></i> Uraikan profil sikap lulusan secara ringkas</small>
                        </div>

                        <div class="mb-4">
                            <label for="sumber" class="form-label font-weight-bold">Sumber <span class="text-danger">*</span></label>
                            <input type="text" name="sumber" class="form-control @error('sumber') is-invalid @enderror" value="{{ old('sumber') }}" placeholder="Contoh: SN-DIKTI" required>
                            @error('sumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-book mr-1"></i> Contoh: SN-DIKTI</small>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <a href="{{ route ('viewSikap-fti') }}" class="btn btn-secondary btn-sm mr-2">
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
                    <p><strong>CPL SN-DIKTI</strong>: Kode unik untuk sikap lulusan (misal: PL-01)</p>
                    <p><strong>Deskripsi</strong>: Penjabaran sikap yang dimiliki lulusan</p>
                    <p><strong>Sumber</strong>: Acuan perumusan sikap (misal: SN-DIKTI)</p>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-lightbulb mr-1"></i> Pastikan semua field terisi dengan benar sebelum menyimpan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

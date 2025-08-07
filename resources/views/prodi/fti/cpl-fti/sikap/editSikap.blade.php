@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit mr-2"></i> {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('viewSikap-fti') }}">Profil Lulusan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data Sikap</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Sikap</h6>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Terdapat kesalahan:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    <form action="{{ route('sikapUpdate', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="kode" class="form-label font-weight-bold">CPL SN-DIKTI <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                                   value="{{ old('kode', $item->kode) }}" placeholder="Contoh: PL-01" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label font-weight-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3" placeholder="Masukan Deskripsi" required>{{ old('deskripsi', $item->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sumber" class="form-label font-weight-bold">Sumber <span class="text-danger">*</span></label>
                            <input type="text" name="sumber" class="form-control @error('sumber') is-invalid @enderror"
                                   value="{{ old('sumber', $item->sumber) }}" placeholder="Contoh: SN-DIKTI" required>
                            @error('sumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm" style="background-color: #4e73df; color: white;">
                                <i class="fas fa-save mr-1"></i> Perbarui
                            </button>
                            <a href="{{ route('viewSikap-fti') }}" class="btn btn-sm ml-2" style="background-color: #6c757d; color: white;">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
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
                        <i class="fas fa-question-circle mr-2"></i> Bantuan Edit
                    </h6>
                </div>
                <div class="card-body small">
                    <p><strong>CPL SN-DIKTI</strong>: Kode CPL seperti PL-01, PL-02</p>
                    <p><strong>Deskripsi</strong>: Jelaskan sikap yang dicapai lulusan</p>
                    <p><strong>Sumber</strong>: Referensi CPL (misal: SN-DIKTI)</p>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-lightbulb mr-1"></i> Lakukan perubahan hanya jika diperlukan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

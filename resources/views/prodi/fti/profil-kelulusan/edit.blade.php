@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-edit mr-2"></i>
        Edit {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('prodi-fti') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('prodi-plUpdate', $item->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode_pl" class="form-label">Kode PL</label>
                    <input type="text" name="kode_pl" class="form-control" value="{{ $item->kode_pl }}" required>
                </div>

                <div class="mb-3">
                    <label for="profil_lulusan" class="form-label">Profil Lulusan (PL)</label>
                    <textarea name="profil_lulusan" class="form-control" rows="3" required>{{ $item->profil_lulusan }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="aspek" class="form-label">Aspek</label>
                    <select name="aspek" class="form-control" required>
                        <option disabled>-- Pilih Aspek --</option>
                        @foreach(['Pengetahuan', 'Keterampilan Khusus', 'Sikap', 'Keterampilan Umum'] as $aspek)
                            <option value="{{ $aspek }}" {{ $item->aspek == $aspek ? 'selected' : '' }}>{{ $aspek }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="profesi" class="form-label">Profesi</label>
                    <select name="profesi" class="form-control" required>
                        <option disabled>-- Pilih Profesi --</option>
                        @foreach(['E-Commerce Spesialist', 'Media Social Specialist', 'Technopreneurship', 'Marketing', 'Staff Marketing'] as $profesi)
                            <option value="{{ $profesi }}" {{ $item->profesi == $profesi ? 'selected' : '' }}>{{ $profesi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="level_kkni" class="form-label">Level KKNI</label>
                    <input type="text" name="level_kkni" class="form-control" value="{{ $item->level_kkni }}" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Update
                </button>
            </form>
        </div>
    </div>
@endsection

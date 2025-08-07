@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('prodi-feb') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="#" method="post">
                @csrf

                <div class="mb-3">
                    <label for="kode_pl" class="form-label">Kode PL</label>
                    <input type="text" name="kode_pl" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="profil_lulusan" class="form-label">Profil Lulusan (PL)</label>
                    <textarea name="profil_lulusan" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="Profesi" class="form-label">Profesi</label>
                    <select name="Profesi" class="form-control" required>
                        <option disabled selected>-- Pilih Profesi --</option>
                        <option value="e-commerce">E-Commerce Spesialist</option>
                        <option value="media_sosial">Media Social Specialist</option>
                        <option value="technopreneurship">Technopreneurship</option>
                        <option value="marketing">Marketing</option>
                        <option value="staff_marketing">Staff Marketing</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="level_kkni" class="form-label">Level KKNI</label>
                    <input type="text" name="level_kkni" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

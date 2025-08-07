@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('viewSikap-fti') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="#" method="post">
                @csrf

                <div class="mb-3">
                    <label for="cpl_sndikti" class="form-label">CPL SN-DIKTI</label>
                    <input type="text" name="cpl_sndikti" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="Deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="Deskripsi" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="cpl_sndikti" class="form-label">Sumber</label>
                    <input type="text" name="cpl_sndikti" class="form-control" required>
                </div>

                {{-- <div class="mb-3">
                    <label for="di_upload" class="form-label">Aspek</label>
                    <select name="di_upload" class="form-control" required>
                        <option disabled selected>-- Pilih Aspek --</option>
                        <option value="pengetahuan">Pengetahuan</option>
                        <option value="keterampilan_khusus">Keterampilan Khusus</option>
                        <option value="sikap">Sikap</option>
                        <option value="keterampilan_umum">Keterampilan Umum</option>
                    </select>
                </div> --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

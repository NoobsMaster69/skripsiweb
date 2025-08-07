@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-graduate mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Profil Lulusan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $items->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Export -->
    <div class="mb-3">
        <a href="{{ route('admin.pl.export.pdf') }}" class="btn btn-danger btn-sm shadow-sm">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
        </a>
        <a href="{{ route('admin.pl.export.excel') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-file-excel mr-1"></i> Export Excel
        </a>
    </div>

    <!-- Tabel Profil Lulusan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i> Daftar Profil Lulusan
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode PL</th>
                            <th>Profil Lulusan</th>
                            <th>Aspek</th>
                            <th>Profesi</th>
                            <th>Level KKNI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $item->kode_pl }}</span>
                                </td>
                                <td>{{ $item->profil_lulusan }}</td>
                                <td>{{ $item->aspek }}</td>
                                <td>{{ $item->profesi }}</td>
                                <td class="text-center">{{ $item->level_kkni }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                    Belum ada data profil lulusan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

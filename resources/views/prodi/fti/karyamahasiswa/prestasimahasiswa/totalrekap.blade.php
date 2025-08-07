@extends('layout/app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-gray-800">
        <i class="fas fa-chart-bar mr-2"></i> {{ $title }}
    </h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table mr-2"></i> Tabel Rekap Prestasi Mahasiswa
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Tahun</th>
                        <th>Prestasi Akademik</th>
                        <th>Prestasi Non Akademik</th>
                        <th>Tingkat Lokal</th>
                        <th>Tingkat Nasional</th>
                        <th>Tingkat Internasional</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $item)
                        <tr>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->total_akademik }}</td>
                            <td>{{ $item->total_non_akademik }}</td>
                            <td>{{ $item->tingkat_lokal }}</td>
                            <td>{{ $item->tingkat_nasional }}</td>
                            <td>{{ $item->tingkat_internasional }}</td>
                            <td class="font-weight-bold text-primary">{{ $item->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data untuk direkap</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

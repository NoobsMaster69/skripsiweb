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
            <i class="fas fa-table mr-2"></i> Data Rekap Prestasi Mahasiswa
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Tahun</th>
                        <th>Judul Karya</th>
                        <th>Tingkat</th>
                        <th>Prestasi</th>
                        <th>Status</th>
                        <th>Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->nm_mhs }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->judul_karya }}</td>
                            <td>{{ ucfirst($item->tingkat) }}</td>
                            <td>{{ ucfirst($item->prestasi) }}</td>
                            <td>{!! status_prestasi($item->status) !!}</td>
                            <td>
                                @if ($item->file_upload)
                                    <a href="{{ Storage::url($item->file_upload) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted">Belum ada data rekap</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

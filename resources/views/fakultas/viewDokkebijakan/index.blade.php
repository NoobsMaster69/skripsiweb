@extends('layout.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i> {{ $title }}
    </h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nomor Dokumen</th>
                            <th>Nama Dokumen</th>
                            <th>Di Upload</th>
                            <th>Tanggal Upload</th>
                            <th>Tanggal Pengesahan</th>
                            <th>Status</th>
                            <th>Lampiran</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumens as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nomor_dokumen }}</td>
                                <td>{{ $item->nama_dokumen }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $item->di_upload }}</span>
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    {{ $item->tanggal_pengesahan ? \Carbon\Carbon::parse($item->tanggal_pengesahan)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center text-white">
                                    @php
                                        echo status_prestasi($item->status);
                                    @endphp
                                </td>
                                <td class="text-center">
                                    @if ($item->hasFile())
                                        <a href="{{ $item->getFileUrl() }}" class="btn btn-info btn-sm" target="_blank">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ $item->deskripsi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-2"></i>
                                        <p>Belum ada data dokumen kebijakan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- DataTables & SweetAlert --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endsection

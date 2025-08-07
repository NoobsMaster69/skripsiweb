@extends('layout/app')

@section('content')
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-graduation-cap mr-2"></i> {{ $title }}
        </h1>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Statistik Card -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-Rata IPK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($averageIpk, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mb-3">
        <a href="{{ route('RataIpk.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Data
        </a>
        <a href="#" onclick="location.reload()" class="btn btn-success btn-sm">
            <i class="fas fa-sync-alt mr-1"></i> Sync
        </a>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i> Data Rata-Rata IPK
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Tahun Lulus</th>
                            <th>Tanggal Lulus</th>
                            <th>IPK</th>
                            <th>Predikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rataIpk as $item)
                            <tr>
                                <td>{{ ($rataIpk->currentPage() - 1) * $rataIpk->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->nim }}</td>
                                <td class="text-left">{{ $item->nama }}</td>
                                <td>{{ $item->prodi }}</td>
                                <td>{{ $item->tahun_lulus }}</td>
                                <td>{{ $item->tanggal_lulus->format('d-m-Y') }}</td>
                                @php
                                    $ipkValue = floatval($item->ipk ?? 0);
                                    $badgeClass = $ipkValue >= 3.5 ? 'success' : ($ipkValue >= 3.0 ? 'info' : ($ipkValue >= 2.75 ? 'warning' : 'danger'));
                                @endphp
                                <td><span class="badge badge-{{ $badgeClass }}">{{ $item->formatted_ipk }}</span></td>
                                <td><span class="badge badge-{{ $badgeClass }}">{{ $item->predikat }}</span></td>
                                <td>
                                    <a href="{{ route('RataIpk.show', $item->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('RataIpk.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" data-name="{{ $item->nama }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data IPK</span>
                                    <p class="text-muted">Klik tombol "Tambah Data" untuk menambahkan data pertama.</p>
                                    <a href="{{ route('RataIpk.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Data Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $rataIpk->appends(request()->query())->links() }}
            </div>

            <!-- Export -->
            <div class="mt-4">
                <div class="dropdown w-100">
                    <button class="btn btn-warning btn-lg dropdown-toggle w-100" type="button" data-toggle="dropdown">
                        <i class="fas fa-print"></i> Export
                    </button>
                    <div class="dropdown-menu w-100 text-center">
                        <a class="dropdown-item" href="{{ route('RataIpk.exportExcel') }}">
                            <i class="fas fa-file-excel text-success mr-2"></i> Export Excel
                        </a>
                        <a class="dropdown-item" href="{{ route('RataIpk.exportPDF') }}">
                            <i class="fas fa-file-pdf text-danger mr-2"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-circle text-danger mr-2"></i> Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Apakah Anda yakin ingin menghapus data <strong id="deleteName"></strong>?</p>
                        <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        const deleteForm = document.getElementById('deleteForm');
        const deleteName = document.getElementById('deleteName');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                deleteName.textContent = name;
                deleteForm.setAttribute('action', '{{ url('RataIpk') }}/' + id);
                $('#deleteModal').modal('show');
            });
        });
    });
</script>
@endpush

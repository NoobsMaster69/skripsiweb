@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-graduate mr-2"></i>{{ $title }}
        </h1>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow border-left-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Karya Produk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahProduk }}</div>
                    </div>
                    <div class="text-gray-300">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow border-left-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Karya Jasa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahJasa }}</div>
                    </div>
                    <div class="text-gray-300">
                        <i class="fas fa-briefcase fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-2" style="gap: 10px;">
            <a href="{{ route('mahasiswa-lainnya-fti.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </a>
            <a href="#" onclick="location.reload()" class="btn btn-success btn-sm">
                <i class="fas fa-sync-alt mr-1"></i> Sync
            </a>
        </div>
        <div class="btn-group gap-2" style="gap: 10px;">
            <a href="{{ route('mahasiswa-lainnya-fti.export-excel') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ route('mahasiswa-lainnya-fti.export-pdf') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-2"></i> Data Karya Mahasiswa Lainnya
                </h6>
                <form method="GET" action="{{ route('mahasiswa-lainnya-fti') }}">
                    <div class="input-group" style="min-width: 250px;">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Cari Nama, NIM, Judul...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th>Fakultas</th>
                            <th>Tahun</th>
                            <th>Judul Karya</th>
                            <th>Kegiatan</th>
                            <th>Tanggal Perolehan</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Lampiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswaLainnya as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nm_mhs }}</td>
                                <td>{{ $item->nim ?? '-' }}</td>
                                <td>{{ $item->prodi ?? '-' }}</td>
                                <td>{{ $item->fakultas ?? '-' }}</td>
                                <td>{{ $item->tahun }}</td>
                                <td>{{ $item->judul_karya }}</td>
                                <td>
                                    <span class="badge badge-{{ $item->kegiatan == 'Produk' ? 'primary' : 'success' }}">
                                        {{ $item->kegiatan }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d-m-Y') ?? '-' }}</td>
                                <td class="text-white">
                                    {!! status_prestasi($item->status) ?? '<span class="badge badge-secondary">Belum ada</span>' !!}
                                </td>
                                <td>{{ $item->deskripsi ?? '--' }}</td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info btn-sm px-2 py-1"
                                            style="font-size: 0.75rem;"
                                            onclick="window.open('{{ Storage::url($item->file_upload) }}', '_blank')">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->status == 'terverifikasi')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <div class="btn-group">
                                            <a href="{{ route('mahasiswa-lainnya-fti.edit', ['mahasiswaLainnya' => $item->id]) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('{{ route('mahasiswa-lainnya-fti.destroy', $item->id) }}', '{{ $item->nm_mhs }}')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data karya mahasiswa</span>
                                    <p class="text-muted">Silakan tambah data dengan klik tombol "Tambah Data".</p>
                                    <a href="{{ route('mahasiswa-lainnya-fti.create') }}"
                                        class="btn btn-sm btn-primary shadow-sm">
                                        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Data Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Hapus -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(deleteUrl, name) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `<p>Yakin ingin menghapus data karya dari <strong>${name}</strong>?</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = deleteUrl;
                    form.submit();
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            let timer;
            const delay = 600;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        if (this.value.trim().length > 1) { // hanya submit kalau isi > 1 karakter
                            this.form.submit();
                        }
                    }, delay);
                });
            }
        });
    </script>
@endpush

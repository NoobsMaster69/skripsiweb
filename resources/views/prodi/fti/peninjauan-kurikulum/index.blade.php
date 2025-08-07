@extends('layout/app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-book mr-2"></i>
        {{ $title }}
    </h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-center justify-content-xl-between">
            <div class="mb-1 mr-2">
                <a href="{{ route('peninjauan-kurikulum.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i> Tambah Data
                </a>
                <button class="btn btn-sm btn-success" onclick="location.reload()">
                    <i class="fas fa-sync mr-2"></i> Refresh
                </button>
            </div>
            <div class="btn-group me-2 mb-2" style="gap: 10px;">
                <a href="{{ route('peninjauan-kurikulum.export.excel') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                </a>
                <a href="{{ route('peninjauan-kurikulum.export.pdf') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf mr-1"></i> Export PDF
                </a>
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nomor Dokumen</th>
                            <th>Nama Dokumen</th>
                            <th>Di Upload</th>
                            <th>Tanggal Upload</th> {{-- ✅ Baru --}}
                            <th>Tanggal Pengesahan</th> {{-- ✅ Baru --}}
                            <th>Status</th>
                            <th>Lampiran</th>
                            <th>Deskripsi</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item->nomor_dokumen }}</td>
                                <td>{{ $item->nama_dokumen }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $item->di_upload == 'Rektorat' ? 'primary' : ($item->di_upload == 'Fakultas' ? 'success' : 'info') }}">
                                        {{ $item->di_upload }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d/m/Y') }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengesahan)->format('d/m/Y') }}
                                </td>
                                <td class="text-center text-white">
                                    {!! status_prestasi($item->status) !!}
                                </td>
                                <td class="text-center">
                                    @if ($item->file_path)
                                        <button class="btn btn-info btn-sm"
                                            onclick="window.open('{{ asset($item->file_path) }}', '_blank')">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->deskripsi ?? '--' }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'terverifikasi')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <div class="btn-group">
                                        <a href="{{ route('peninjauan-kurikulum.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="confirmDelete('{{ route('peninjauan-kurikulum.destroy', $item->id) }}', '{{ $item->nama_dokumen }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4"> {{-- ✅ sesuaikan jumlah kolom jadi 10 --}}
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Belum ada data peninjauan kurikulum</p>
                                        <a href="{{ route('peninjauan-kurikulum.create') }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus mr-2"></i> Tambah Data Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(deleteUrl, documentName) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 48px;"></i>
                        <p>Apakah Anda yakin ingin menghapus dokumen:</p>
                        <strong class="text-danger">${documentName}</strong>
                        <p class="text-danger mt-2"><i class="fas fa-warning mr-1"></i> Data yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus Data...',
                        html: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = deleteUrl;
                    deleteForm.submit();
                }
            });
        }
    </script>
@endsection

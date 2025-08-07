@extends('layout/app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user mr-2"></i>
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
                <a href="{{ route('buku-kurikulumfti.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i> Tambah Data
                </a>
                <button class="btn btn-sm btn-success" onclick="location.reload()">
                    <i class="fas fa-sync mr-2"></i> Refresh
                </button>
            </div>
            <div class="btn-group me-2 mb-2" style="gap: 10px;">
                <a href="{{ route('buku-kurikulumfti.export.excel') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                </a>
                <a href="{{ route('buku-kurikulumfti.export.pdf') }}" class="btn btn-danger btn-sm">
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
                            <th>Tanggal Upload</th>
                            <th>Tanggal Pengesahan</th>
                            <th>Status</th>
                            <th>Lampiran</th>
                            <th>Deskripsi</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bukuKurikulum as $index => $buku)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $buku->nomor_dokumen }}</td>
                                <td>{{ $buku->nama_dokumen }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $buku->di_upload == 'Rektorat' ? 'primary' : ($buku->di_upload == 'Fakultas' ? 'success' : 'info') }}">
                                        {{ $buku->di_upload }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($buku->tanggal_upload)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    {{ $buku->tanggal_pengesahan ? \Carbon\Carbon::parse($buku->tanggal_pengesahan)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center text-white">
                                    @php
                                        echo status_prestasi($buku->status);
                                    @endphp
                                </td>
                                <td class="text-center">
                                    @if ($buku->file_path)
                                        <a href="{{ url($buku->file_path) }}" class="btn btn-info btn-sm"
                                            target="_blank" title="Lihat Dokumen">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $buku->deskripsi ?? '--' }}</td>
                                <td class="text-center">
                                    @if ($buku->status == 'terverifikasi')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <div class="btn-group">
                                        <a href="{{ route('buku-kurikulumfti.edit', $buku->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="confirmDelete('{{ route('buku-kurikulumfti.destroy', $buku->id) }}', '{{ $buku->nama_dokumen }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Belum ada data dokumen rekam</p>
                                        <a href="{{ route('buku-kurikulumfti.create') }}" class="btn btn-primary btn-sm">
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

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#28a745',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        @endif
    </script>
@endsection

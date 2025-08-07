@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-book-open mr-2"></i> Data Profil Lulusan - Keterampilan Khusus
        </h1>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        {{-- Kiri: Tambah & Kembali --}}
        <div class="mb-2">
            <a href="{{ route('kkCreate') }}" class="btn btn-sm btn-primary mr-2 mb-1">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </a>
            <a href="{{ route('plprodi-fti') }}" class="btn btn-sm btn-secondary mb-1">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        {{-- Kanan: Export --}}
        <div class="mb-2 d-flex flex-wrap gap-2">
            <a href="{{ route('exportKK.excel') }}" class="btn btn-sm btn-success mr-2 mb-1">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ route('exportKK.pdf') }}" class="btn btn-sm btn-danger mb-1">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>
        </div>

    </div>

    <!-- TABLE -->
    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>CPL SN-DIKTI</th>
                            <th>Deskripsi</th>
                            <th>Sumber</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($KeterampilanKhusus as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->kode }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td class="text-center">{{ $item->sumber }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kkEdit', $item->id) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete('{{ route('kkDestroy', $item->id) }}', '{{ $item->kode }}')"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <p>Belum ada data keterampilan umum</p>
                                    <a href="{{ route('kuCreate') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus mr-1"></i> Tambah Data Pertama
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(deleteUrl, kode) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `<p>Yakin ingin menghapus data dengan kode <strong>${kode}</strong>?</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = deleteUrl;
                    form.submit();
                }
            });
        }
    </script>
@endsection

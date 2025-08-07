@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-graduate mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Prestasi Akademik
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $jumlahPrestasiAkademik }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-certificate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Prestasi Non Akademik
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $jumlahPrestasiNon }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-certificate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Tombol Aksi -->
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex" style="gap: 10px;">
            <a href="{{ route('prestasi-mahasiswa-fti.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </a>
            <a href="#" onclick="location.reload()" class="btn btn-success btn-sm">
                <i class="fas fa-sync-alt mr-1"></i> Sync
            </a>
        </div>

        <div class="d-flex" style="gap: 10px;">
            {{-- <!-- Tombol Rekap -->
            <a href="{{ route('prestasi-mahasiswa-fti.rekap') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chart-bar mr-1"></i> Halaman Rekap
            </a>
            <!-- Tombol Rekap -->
            <a href="{{ route('prestasi-mahasiswa-fti.totalrekap') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chart-bar mr-1"></i> Total Rekap
            </a> --}}

            <!-- Tombol Export -->

            <div class="btn-group me-2 mb-2" style="gap: 10px;">
                <a href="{{ route('prestasi-mahasiswa-fti.export-excel') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                </a>
                <a href="{{ route('prestasi-mahasiswa-fti.export-pdf') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf mr-1"></i> Export PDF
                </a>
            </div>
        </div>
    </div>


    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-2"></i> Data Prestasi Mahasiswa
                </h6>

                <!-- Form Search Kanan -->
                <form method="GET" action="{{ route('prestasi-mahasiswa-fti') }}">
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
            <div class="d-flex justify-content-end mb-3">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th>Fakultas</th>
                            <th>Tahun</th>
                            <th>Judul Karya</th>
                            <th>Tingkat</th>
                            <th>Prestasi</th>
                            <th>Tanggal Perolehan</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Lampiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasiMahasiswa as $index => $karya)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $karya->nm_mhs }}</td>
                                <td class="text-center">{{ $karya->nim }}</td>
                                <td class="text-center">{{ $karya->prodi ?? '-' }}</td>
                                <td class="text-center">{{ $karya->fakultas ?? '-' }}</td>
                                <td class="text-center">{{ $karya->tahun }}</td>
                                <td>{{ $karya->judul_karya }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $karya->tingkat === 'internasional' ? 'danger' : ($karya->tingkat === 'nasional' ? 'warning' : 'secondary') }} text-capitalize">
                                        {{ $karya->tingkat }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $karya->prestasi === 'prestasi-akademik' ? 'danger' : ($karya->prestasi === 'prestasi-non-akademik' ? 'primary' : 'secondary') }} text-capitalize">
                                        {{ str_replace('-', ' ', $karya->prestasi) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ $karya->tanggal_perolehan ?? '-' }}
                                </td>
                                <td class="text-center text-white">
                                    @php echo status_prestasi($karya->status); @endphp
                                </td>
                                <td>{{ $karya->deskripsi ?? '--' }}</td>
                                <td class="text-center">
                                    @if ($karya->file_upload)
                                        <a href="{{ Storage::url($karya->file_upload) }}" class="btn btn-info btn-sm"
                                            target="_blank" title="Lihat Dokumen">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($karya->status === 'terverifikasi')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('prestasi-mahasiswa-fti.edit', $karya->id) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('{{ route('prestasi-mahasiswa-fti.destroy', $karya->id) }}', '{{ $karya->nm_mhs }}')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data karya mahasiswa</span>
                                    <p class="text-muted">Silakan tambah data dengan mengklik tombol "Tambah Data".</p>
                                    <a href="{{ route('prestasi-mahasiswa-fti.create') }}"
                                        class="btn btn-sm btn-primary shadow-sm">
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
        function confirmDelete(deleteUrl, name) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `<p>Yakin ingin menghapus data karya dari <strong>${name}</strong>?</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').action = deleteUrl;
                    document.getElementById('deleteForm').submit();
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
@endsection

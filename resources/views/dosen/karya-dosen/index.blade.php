    @extends('layout/app')

    @section('content')
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-graduate mr-2"></i>
                {{ $title }}
            </h1>
        </div>

        <!-- Flash Messages -->
        @if (session('message'))
            <div class="alert alert-{{ session('message_type', 'success') }} alert-dismissible fade show" role="alert">
                <i
                    class="fas fa-{{ session('message_type') == 'success' ? 'check-circle' : 'exclamation-circle' }} mr-2"></i>
                {!! session('message') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Statistik Cards -->
        <div class="row mb-4">
            @php
                $stats = [
                    [
                        'label' => 'Total Karya',
                        'jumlah' => $karyaDosens->total() ?? 0,
                        'color' => 'primary',
                        'icon' => 'book-open',
                    ],
                    [
                        'label' => 'Aplikasi',
                        'jumlah' => App\Models\KaryaDosen::where('jenis_karya', 'Aplikasi')->count(),
                        'color' => 'success',
                        'icon' => 'laptop-code',
                    ],
                    [
                        'label' => 'Publikasi',
                        'jumlah' => App\Models\KaryaDosen::where('jenis_karya', 'Publikasi')->count(),
                        'color' => 'info',
                        'icon' => 'newspaper',
                    ],
                    [
                        'label' => 'Buku',
                        'jumlah' => App\Models\KaryaDosen::where('jenis_karya', 'Buku')->count(),
                        'color' => 'warning',
                        'icon' => 'book',
                    ],
                    [
                        'label' => 'Lainnya',
                        'jumlah' => App\Models\KaryaDosen::where('jenis_karya', 'Lainnya')->count(),
                        'color' => 'secondary',
                        'icon' => 'certificate',
                    ],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-{{ $stat['color'] }} shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                        {{ $stat['label'] }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stat['jumlah'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-{{ $stat['icon'] }} fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-3" style="gap: 10px;">
                <a href="{{ route('karya-dosen.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Data
                </a>
                <a href="#" onclick="location.reload()" class="btn btn-success btn-sm">
                    <i class="fas fa-sync-alt mr-1"></i> Sync
                </a>
            </div>

            <div class="btn-group" style="gap: 10px;">
                <a href="{{ route('karya-dosen.export-excel') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                </a>
                <a href="{{ route('karya-dosen.export-pdf') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf mr-1"></i> Export PDF
                </a>
            </div>

        </div>

        <!-- Tabel Data -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i> Data Karya Dosen
                        @if ($karyaDosens->total() > 0)
                            <span class="badge badge-primary ml-2">{{ $karyaDosens->total() }} Data</span>
                        @endif
                    </h6>

                    <!-- Form Search Kanan -->
                    <form method="GET" action="{{ route('karya-dosen.index') }}" class="mb-3">
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                placeholder="Cari nama dosen..." value="{{ request('search') }}" autocomplete="off">
                            <button type="submit" class="d-none" id="realSubmit"></button>
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
                @if ($karyaDosens->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-primary text-white">
                                <th>No</th>
                                <th class="text-center">Judul Karya</th>
                                <th class="text-center">Nama Dosen</th>
                                <th class="text-center">Program Studi</th>
                                <th class="text-center">Fakultas</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Tanggal Perolehan</th>
                                <th class="text-center">Jenis Karya</th> <!-- ini ke-8 -->
                                <th class="text-center">Status</th> <!-- ke-9 -->
                                <th class="text-center">Deskripsi</th> <!-- ke-10 -->
                                <th class="text-center">Lampiran</th> <!-- ke-11 -->
                                <th class="text-center">Aksi</th> <!-- ke-12 -->
                            </thead>

                            <tbody>
                                @foreach ($karyaDosens as $index => $karya)
                                    <tr>
                                        <td class="text-center">{{ $karyaDosens->firstItem() + $index }}</td>
                                        <td>{{ $karya->judul_karya }}</td>
                                        <td class="text-center">{{ $karya->nama_dosen }}</td>
                                        <td class="text-center">{{ $karya->prodi }}</td>
                                        <td class="text-center">{{ $karya->fakultas ?? '-' }}</td>
                                        <td class="text-center">{{ $karya->tahun_pembuatan }}</td>
                                        <td class="text-center">
                                            {{ $karya->tanggal_perolehan ? \Carbon\Carbon::parse($karya->tanggal_perolehan)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badgeColors = [
                                                    'Aplikasi' => 'success',
                                                    'Publikasi' => 'primary',
                                                    'Buku' => 'warning',
                                                    'Lainnya' => 'secondary',
                                                ];
                                                $color = $badgeColors[$karya->jenis_karya] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $color }}">{{ $karya->jenis_karya }}</span>
                                        </td>
                                        <td class="text-center text-white">
                                            {!! status_prestasi($karya->status) !!}
                                        </td>
                                        <td>{{ $karya->deskripsi ?? '--' }}</td>
                                        <td class="text-center">
                                            @if ($karya->file_karya)
                                                <a href="{{ asset('storage/' . $karya->file_karya) }}" target="_blank"
                                                    class="btn btn-outline-info btn-sm mb-1">
                                                    <i class="fas fa-eye mr-1"></i> Lihat
                                                </a>
                                            @else
                                                <span class="badge badge-light">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($karya->status == 'terverifikasi')
                                                <span class="badge badge-success">Selesai</span>
                                            @else
                                                <div class="btn-group">
                                                    <a href="{{ route('karya-dosen.edit', $karya->id) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('karya-dosen.destroy', $karya->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); if(confirm('Yakin hapus?')) { document.getElementById('deleteForm').action = this.href; document.getElementById('deleteForm').submit(); }"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $karyaDosens->firstItem() }} sampai {{ $karyaDosens->lastItem() }} dari
                            {{ $karyaDosens->total() }} data
                        </div>
                        <div>
                            {{ $karyaDosens->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-600">Belum Ada Data Karya Dosen</h5>
                        <p class="text-muted">Silakan tambah data karya dosen dengan mengklik tombol "Tambah Data" di atas.
                        </p>
                        <a href="{{ route('karya-dosen.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Data Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Hapus -->
        <form id="deleteForm" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        @if (session('message'))
            @if (session('message'))
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: '{{ session('message_type', 'success') }}',
                            title: '{{ session('message_type') == 'success' ? 'Sukses' : 'Gagal' }}',
                            text: '{{ session('message') }}',
                            confirmButtonColor: '#6c63ff',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'swal2-rounded',
                                confirmButton: 'swal2-confirm-custom'
                            }
                        });
                    });
                </script>
                @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const searchInput = document.getElementById('searchInput');
                            const submitBtn = document.getElementById('realSubmit');
                            let timer;
                            const delay = 300;

                            if (searchInput && submitBtn) {
                                searchInput.addEventListener('input', function() {
                                    clearTimeout(timer);
                                    timer = setTimeout(() => {
                                        submitBtn.click(); // klik tombol submit tersembunyi
                                    }, delay);
                                });
                            }
                        });
                    </script>
                @endpush
            @endif
        @endif
    @endsection

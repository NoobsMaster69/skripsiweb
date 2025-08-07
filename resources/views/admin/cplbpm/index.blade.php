@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-bullseye text-primary mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    <!-- Filter Form -->
    <div class="card mb-5">
        <div class="card-body">
            <form action="{{ route('cpl-bpm') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="tahun_akademik" class="form-label fw-bold">Filter Tahun Akademik</label>
                        <select name="tahun_akademik" id="tahun_akademik" class="form-control form-control-sm">
                            <option value="">-- Semua Tahun --</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="unit" class="form-label fw-bold">Filter Unit</label>
                        <select name="unit" id="unit" class="form-control form-control-sm">
                            <option value="">-- Pilih Unit --</option>
                            <option value="Fakultas">Fakultas</option>
                            <option value="Prodi">Prodi</option>
                            <option value="Universitas">Universitas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mata_kuliah" class="form-label fw-bold">Filter Mata Kuliah</label>
                        <div class="input-group input-group-sm">
                            <select name="mata_kuliah" id="mata_kuliah" class="form-control">
                                <option value="">-- Pilih Mata Kuliah --</option>
                                <option value="Technoprenership">Technoprenership</option>
                                <option value="Aljabar">Aljabar Linier</option>
                                <option value="PemogramanAlgoritma">Pemograman algoritma</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter mr-1"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tombol Action yang Sejajar -->
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-5" style="gap: 10px;">
            <a href="{{ route('cpl-bpm.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </a>
            <a href="#" onclick="location.reload()" class="btn btn-success btn-sm">
                <i class="fas fa-sync-alt mr-1"></i> Sync
            </a>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-file-export mr-1"></i> Export
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('cpl-bpm.export-excel') }}">
                    <i class="fas fa-file-excel text-success mr-1"></i> Excel
                </a>
                <a class="dropdown-item" href="{{ route('cpl-bpm.export-pdf') }}">
                    <i class="fas fa-file-pdf text-danger mr-1"></i> PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Target CPL BPM</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Tahun Akademik</th>
                            <th>Program Studi</th>
                            <th>Mata Kuliah</th>
                            <th>Target</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($targets as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->tahun_akademik }}</td>
                                <td class="text-center">{{ $item->program_studi }}</td>
                                <td class="text-center">{{ $item->mata_kuliah }}</td>
                                <td class="text-center">
                                    @php
                                        $targetValue = floatval($item->target_pencapaian ?? 0);
                                        $badgeClass =
                                            $targetValue >= 80
                                                ? 'success'
                                                : ($targetValue >= 60
                                                    ? 'warning'
                                                    : 'danger');
                                    @endphp
                                    <span
                                        class="badge badge-{{ $badgeClass }}">{{ number_format($targetValue, 1) }}%</span>
                                </td>
                                <td class="text-center">{{ $item->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('cpl-bpm.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}"
                                        data-name="{{ $item->mata_kuliah }}" data-toggle="modal"
                                        data-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                <span class="text-muted">Belum ada data rekognisi dosen</span>
                                <p class="text-muted">Silakan tambah data karya dosen dengan mengklik tombol "Tambah
                                    Data" di atas.</p>
                                <a href="{{ route('cpl-bpm.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Tambah Data Pertama
                                </a>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total Presentasi Ketercapaian -->
            <div class="d-flex justify-content-end mt-3">
                <div class="card shadow-sm border-0" style="min-width: 280px; background-color: #f8f9fc;">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-line fa-lg text-primary mr-2"></i>
                            <span class="text-secondary font-weight-bold">Total Ketercapaian</span>
                        </div>
                        <span class="badge badge-primary p-2 px-3">
                            {{ number_format($targets->avg('target_pencapaian') ?? 0, 1) }}%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tombol Cetak Besar di Bawah -->
            <div class="mt-3">
                <div class="dropdown w-100">
                    <button class="btn btn-warning btn-lg dropdown-toggle w-100 text-center" type="button"
                        data-toggle="dropdown">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                    <div class="dropdown-menu w-100 text-center">
                        <a class="dropdown-item mb-2" href="{{ route('cpl-bpm.export-pdf') }}"
                            style="font-size: 1.1rem;">
                            <i class="fas fa-file-pdf text-danger mr-2 fa-lg"></i> <strong>Export PDF</strong>
                        </a>
                        <a class="dropdown-item" href="{{ route('cpl-bpm.export-excel') }}" style="font-size: 1.1rem;">
                            <i class="fas fa-file-excel text-success mr-2 fa-lg"></i> <strong>Export Excel</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                            Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <p>Apakah Anda yakin ingin menghapus data berikut?</p>
                        <p><strong id="deleteName"></strong></p>
                        <p class="text-muted small">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Hapus Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-delete').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                // DEBUG (lihat di console browser F12)
                console.log("ID untuk hapus:", id);

                $('#deleteName').text(name);

                // Pastikan route-nya benar-benar mengandung ID
                let url = '{{ route('cpl-bpm.destroy', ':id') }}'.replace(':id', id);
                $('#deleteForm').attr('action', url);
            });
        });
    </script>
@endpush

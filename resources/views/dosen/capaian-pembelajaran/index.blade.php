@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-bullseye text-primary mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    <!-- Tombol Export dan Tambah Data -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="d-flex gap-3" style="gap: 10px;">
            @if ($targets->isNotEmpty())
                <a href="{{ route('cpl-dosen.create', ['master_cpl_id' => $targets->first()->id]) }}"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Data
                </a>
            @endif
            <a href="#" onclick="location.reload()" class="btn btn-success btn-sm">
                <i class="fas fa-sync-alt mr-1"></i> Sync
            </a>
        </div>

        <div class="btn-group" style="gap: 10px;">
            <a href="{{ route('cpl-dosen.export-excel') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ route('cpl-dosen.export-pdf') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>
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
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-2"></i> Data Target CPL BPM
                </h6>
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <form method="GET" action="{{ route('cpl-dosen') }}" class="d-flex">
                        <div class="input-group" style="min-width: 250px;">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari Tahun, Prodi, Mata Kuliah...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @if (request('search'))
                        <a href="{{ route('cpl-dosen') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-undo mr-1"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Program Studi</th>
                            <th>Mata Kuliah</th>
                            <th>Target</th>
                            <th>Ketercapaian</th>
                            <th>Dokumen</th>
                            <th>Link</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($targets as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->tahun_akademik }}</td>
                                <td>{{ $item->program_studi }}</td>
                                <td>{{ $item->mata_kuliah }}</td>
                                <td class="text-center">
                                    @php
                                        $target = floatval($item->target_pencapaian ?? 0);
                                        $badge = $target >= 80 ? 'success' : ($target >= 60 ? 'warning' : 'danger');
                                    @endphp
                                    <span class="badge badge-{{ $badge }}">{{ number_format($target, 1) }}%</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $capai = optional($item->cplDosen)->ketercapaian;
                                        $badgeCapai = $capai >= 80 ? 'success' : ($capai >= 60 ? 'warning' : 'danger');
                                    @endphp
                                    @if ($capai)
                                        <span
                                            class="badge badge-{{ $badgeCapai }}">{{ number_format($capai, 1) }}%</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (optional($item->cplDosen)->dokumen_pendukung)
                                        <a href="{{ asset('storage/' . $item->cplDosen->dokumen_pendukung) }}"
                                            target="_blank" class="btn btn-outline-info btn-sm mb-1">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                    @else
                                        <span class="badge badge-secondary">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    @if (optional($item->cplDosen)->link)
                                        <a href="{{ $item->cplDosen->link }}" target="_blank">Buka Link</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ optional($item->cplDosen)->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($item->cplDosen)
                                        <a href="{{ route('cpl-dosen.edit', $item->cplDosen->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm btn-delete"
                                            data-id="{{ $item->cplDosen->id }}" data-name="{{ $item->mata_kuliah }}"
                                            data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('cpl-dosen.create', ['master_cpl_id' => $item->id]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Tambah
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="mb-0 text-muted">Data masih kosong.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Statistik -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card bg-light border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <strong>Total Target</strong>
                            <span
                                class="badge badge-primary px-3">{{ number_format($targets->avg('target_pencapaian') ?? 0, 1) }}%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <strong>Total Ketercapaian</strong>
                            <span class="badge badge-success px-3">
                                {{ number_format($targets->map(fn($i) => optional($i->cplDosen)->ketercapaian)->filter()->avg() ?? 0, 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cetak -->
            <div class="mt-4">
                <div class="dropdown w-100">
                    <button class="btn btn-warning btn-lg dropdown-toggle w-100" type="button" data-toggle="dropdown">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                    <div class="dropdown-menu text-center w-100">
                        <a class="dropdown-item" href="{{ route('cpl-dosen.export-pdf') }}">
                            <i class="fas fa-file-pdf text-danger mr-2"></i> Export PDF
                        </a>
                        <a class="dropdown-item" href="{{ route('cpl-dosen.export-excel') }}">
                            <i class="fas fa-file-excel text-success mr-2"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">
                            <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                            Konfirmasi Hapus
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Apakah Anda yakin ingin menghapus data berikut?</p>
                        <p><strong id="deleteName">...</strong></p>
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
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');

                    // Set URL action form
                    const form = document.getElementById('deleteForm');
                    const url = '{{ route('cpl-dosen.destroy', ':id') }}'.replace(':id', id);
                    form.setAttribute('action', url);

                    // Tampilkan nama CPL di modal
                    document.getElementById('deleteName').textContent = name;
                });
            });
        });
    </script>
@endpush

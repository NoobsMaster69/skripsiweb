@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user mr-2"></i> {{ $title }}
        </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i> Daftar Validasi Dokumen
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-success btn-sm mr-2" onclick="location.reload()">
                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                        </button>
                        {{-- <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-download mr-1"></i> Export
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-file-excel mr-2"></i>Excel
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-file-pdf mr-2"></i>PDF
                        </a>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Fakultas</th>
                            <th>Tahun</th>
                            <th>Tanggal Perolehan</th>
                            <th>Judul Karya</th>
                            <th>Kegiatan</th>
                            <th>Jenis Publikasi</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Lampiran</th>
                            <th>Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publikasiMahasiswa as $index => $karya)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $karya->nm_mhs }}</td>
                                <td class="text-center">{{ $karya->nim }}</td>
                                <td class="text-center">{{ $karya->prodi ?? '-' }}</td>
                                <td class="text-center">{{ $karya->fakultas ?? '-' }}</td>
                                <td class="text-center">{{ $karya->tahun }}</td>
                                <td class="text-center">
                                    {{ $karya->tanggal_perolehan ? \Carbon\Carbon::parse($karya->tanggal_perolehan)->format('d-m-Y') : '-' }}
                                </td>
                                <td>{{ $karya->judul_karya }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $karya->kegiatan }}</span>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $karya->jenis_publikasi == 'buku' ? 'danger' : ($karya->jenis_publikasi == 'jurnal_artikel' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $karya->jenis_publikasi)) }}
                                    </span>
                                </td>
                                <td class="text-center text-white">{!! status_prestasi($karya->status) !!}</td>
                                <td class="text-center">{{ $karya->deskripsi ?? '--' }}</td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info btn-sm"
                                            onclick="window.open('{{ Storage::url($karya->file_upload) }}', '_blank')">
                                            <i class="fas fa-eye mr-1"></i>Lihat
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('validasi-publikasi', $karya->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-check mr-1"></i> Validasi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data karya mahasiswa</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('#dataTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: true,
                    language: {
                        search: "Cari:",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            }
        });
    </script>
@endpush

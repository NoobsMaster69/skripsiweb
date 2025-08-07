@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-check mr-2"></i> Validasi Karya Dosen
        </h1>
    </div>

    <!-- Flash Message -->
    @if (session('message'))
        <div class="alert alert-{{ session('message_type', 'success') }} alert-dismissible fade show" role="alert">
            <i class="fas fa-{{ session('message_type') == 'success' ? 'check-circle' : 'exclamation-circle' }} mr-2"></i>
            {!! session('message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i>
                        Daftar Validasi Dokumen
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-success btn-sm mr-2">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Refresh
                        </button>
                        {{-- <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-download mr-1"></i>
                            Export
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
            @if ($karyaDosens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th class="text-center">Judul Karya</th>
                                <th class="text-center">Nama Dosen</th>
                                <th class="text-center">Program Studi</th>
                                <th class="text-center">Fakultas</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Tanggal Perolehan</th>
                                <th class="text-center">Jenis Karya</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Lampiran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyaDosens as $index => $karyaDosen)
                                <tr>
                                    <td class="text-center">{{ $karyaDosens->firstItem() + $index }}</td>
                                    <td>{{ $karyaDosen->judul_karya }}</td>
                                    <td class="text-center">{{ $karyaDosen->nama_dosen }}</td>
                                    <td class="text-center">{{ $karyaDosen->prodi }}</td>
                                    <td class="text-center">{{ $karyaDosen->fakultas ?? '-' }}</td>
                                    <td class="text-center">({{ $karyaDosen->tahun_pembuatan }})</td>
                                    <td class="text-center">
                                        {{ $karyaDosen->tanggal_perolehan ? \Carbon\Carbon::parse($karyaDosen->tanggal_perolehan)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badgeColors = [
                                                'Aplikasi' => 'success',
                                                'Publikasi' => 'primary',
                                                'Buku' => 'warning',
                                                'Lainnya' => 'secondary',
                                            ];
                                            $color = $badgeColors[$karyaDosen->jenis_karya] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $color }}">{{ $karyaDosen->jenis_karya }}</span>
                                    </td>
                                    <td class="text-center text-white">
                                        {!! status_prestasi($karyaDosen->status) !!}
                                    </td>
                                    <td>{{ $karyaDosen->deskripsi ?? '--' }}</td>
                                    <td class="text-center">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info btn-sm"
                                                onclick="window.open('{{ Storage::url($karyaDosen->file_karya) }}', '_blank')">
                                                <i class="fas fa-eye mr-1"></i>Lihat
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('validasi-karyaDosenValid', $karyaDosen->id) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-check-circle"></i> Validasi
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $karyaDosens->firstItem() }} sampai {{ $karyaDosens->lastItem() }} dari
                        {{ $karyaDosens->total() }} data
                    </div>
                    <div>
                        {{ $karyaDosens->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada Data Karya Dosen</h5>
                </div>
            @endif
        </div>
    </div>

    <!-- Form Delete -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-check mr-2"></i>{{ $title }}
        </h1>
    </div>

    <!-- Alert Messages -->
    @if (session('message'))
        <div class="alert alert-{{ session('message_type', 'success') }} alert-dismissible fade show" role="alert">
            <i class="fas fa-{{ session('message_type') == 'success' ? 'check-circle' : 'exclamation-circle' }} mr-2"></i>
            {!! session('message') !!}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pendidikan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPendidikan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-search fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengabdian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPengabdian }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hands-helping fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Penelitian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPenelitian }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-award fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Profesional</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahProfesional }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-award fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <!-- Tombol Aksi (Export + Tambah Data) -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-3" style="gap: 10px;">
            <a href="{{ route('dosen.rekognisi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </a>
            <a href="#" onclick="location.reload()" class="btn btn-success btn-sm">
                <i class="fas fa-sync-alt mr-1"></i> Sync
            </a>
        </div>

        <div class="btn-group">
            <a href="{{ route('dosen.rekognisi.export-excel') }}" class="btn btn-success btn-sm mr-2">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ route('dosen.rekognisi.export-pdf') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>

        </div>
    </div>


    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-2"></i> Data Rekognisi Dosen
                </h6>

                <!-- Form Search Kanan -->
                <form method="GET" action="{{ route('dosen.rekognisi.index') }}">
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
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Prodi</th>
                            <th>Bidang</th>
                            <th>Tahun</th>
                            <th><strong>Tanggal</strong></th>
                            <th class="text-center">Status</th> <!-- ke-9 -->
                            <th class="text-center">Deskripsi</th>
                            <th>Lampiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekognisiDosen as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama_dosen }}</td>
                                <td>{{ $item->prodi }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $item->bidang_rekognisi == 'Pendidikan'
                                            ? 'info'
                                            : ($item->bidang_rekognisi == 'Pengabdian'
                                                ? 'success'
                                                : ($item->bidang_rekognisi == 'Penelitian'
                                                    ? 'primary'
                                                    : 'secondary')) }}">
                                        {{ $item->bidang_rekognisi }}
                                    </span>
                                </td>

                                <td class="text-center">{{ $item->tahun_akademik }}</td>
                                <td class="text-center">
                                    {{ $item->tanggal_rekognisi ? \Carbon\Carbon::parse($item->tanggal_rekognisi)->format('d-m-Y') : '-' }}
                                </td>
                                <td class="text-center text-white">
                                    {!! status_prestasi($item->status) !!}
                                </td>
                                <td>{{ $item->deskripsi ?? '--' }}</td>


                                <td class="text-center">
                                    @if ($item->file_bukti)
                                        <a href="{{ Storage::url($item->file_bukti) }}" target="_blank"
                                            class="btn btn-outline-info btn-sm mb-1">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        {{-- <a href="{{ Storage::url($item->file_bukti) }}" download
                                            class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-download mr-1"></i> Download
                                        </a> --}}
                                    @else
                                        <span class="badge badge-secondary">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->status == 'terverifikasi')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <div class="btn-group">
                                            <a href="{{ route('dosen.rekognisi.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('{{ route('dosen.rekognisi.destroy', $item->id) }}', '{{ $item->nama_dosen }}')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data rekognisi dosen</span>
                                    <p class="text-muted">Silakan tambah data karya dosen dengan mengklik tombol "Tambah
                                        Data" di atas.</p>
                                    <a href="{{ route('dosen.rekognisi.create') }}" class="btn btn-primary">
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
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>{{-- Script konfirmasi hapus --}}
    <script>
        function confirmDelete(url, nama) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: `Data rekognisi dosen <strong>${nama}</strong> akan dihapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal2-rounded',
                    confirmButton: 'swal2-confirm-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.setAttribute('action', url);
                    form.submit();
                }
            });
        }
    </script>

    {{-- Script notifikasi sukses jika message_type = success (hapus atau simpan) --}}
    @if (session('message') && session('message_type') == 'success')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    html: `{!! session('message') !!}`,
                    confirmButtonColor: '#6c63ff',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal2-rounded',
                        confirmButton: 'swal2-confirm-custom'
                    }
                });
            });
        </script>
    @endif

    {{-- Script search otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const delay = 300;
            let timer;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        this.form.submit();
                    }, delay);
                });
            }
        });
    </script>

@endsection

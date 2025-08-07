@extends('layout/app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tasks mr-2"></i>
            {{ $title }}
        </h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Target</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $targets->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata Target</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($targets->avg('target_pencapaian') ?? 0, 2) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <a href="{{ route('master-cpl.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Data
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i> Data Target CPL BPM
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="dataTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tahun_akademik }}</td>
                                <td>{{ $item->program_studi }}</td>
                                <td>{{ $item->mata_kuliah }}</td>
                                <td>{{ $item->target_pencapaian }}%</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <a href="{{ route('master-cpl.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $item->id }}, '{{ $item->mata_kuliah }}')"
                                            class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('master-cpl.destroy', $item->id) }}"
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                    <span class="text-muted">Belum ada data target CPL</span>
                                    <p class="text-muted">Silakan tambah data dengan mengklik tombol "Tambah Data" di atas.</p>
                                    <a href="{{ route('master-cpl.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Data Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, mataKuliah) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: `Data <strong>${mataKuliah}</strong> akan dihapus.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection

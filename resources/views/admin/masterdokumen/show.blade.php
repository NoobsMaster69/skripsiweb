@extends('layout/app')

@section('content')
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-file-alt text-primary mr-2"></i>
            {{ $title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('master-dokumen.index') }}">Master Dokumen</a>
                </li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <!-- Document Detail Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-info-circle mr-1"></i>
                Informasi Dokumen
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Document Info -->
                <div class="col-lg-8">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="font-weight-bold text-gray-800">Nomor Dokumen</td>
                            <td width="5%">:</td>
                            <td>
                                <span class="badge badge-info px-3 py-2">{{ $dokumen->nomor }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Nama Dokumen</td>
                            <td>:</td>
                            <td class="text-gray-900">{{ $dokumen->nama_dokumen }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Kategori</td>
                            <td>:</td>
                            <td>
                                @if($dokumen->kategori == 'STATUTA')
                                    <span class="badge badge-success">{{ $dokumen->kategori }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $dokumen->kategori }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Status</td>
                            <td>:</td>
                            <td>
                                @if($dokumen->status == 'DONE')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check mr-1"></i>SELESAI
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock mr-1"></i>{{ $dokumen->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Tanggal Upload</td>
                            <td>:</td>
                            <td>
                                <i class="fas fa-calendar mr-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($dokumen->created_at)->format('d F Y') }}
                                <small class="text-muted ml-2">
                                    ({{ \Carbon\Carbon::parse($dokumen->created_at)->diffForHumans() }})
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Ukuran File</td>
                            <td>:</td>
                            <td>
                                <i class="fas fa-file mr-1 text-muted"></i>
                                {{ $dokumen->file_size ?? 'Tidak diketahui' }}
                            </td>
                        </tr>
                        @if($dokumen->deskripsi)
                        <tr>
                            <td class="font-weight-bold text-gray-800">Deskripsi</td>
                            <td>:</td>
                            <td class="text-gray-700">{{ $dokumen->deskripsi }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- Document Preview/Actions -->
                <div class="col-lg-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if(pathinfo($dokumen->file_path, PATHINFO_EXTENSION) == 'pdf')
                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                @elseif(in_array(pathinfo($dokumen->file_path, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <i class="fas fa-file-word fa-4x text-primary"></i>
                                @else
                                    <i class="fas fa-file fa-4x text-secondary"></i>
                                @endif
                            </div>
                            <h6 class="font-weight-bold">{{ pathinfo($dokumen->file_path, PATHINFO_BASENAME) }}</h6>
                            <p class="text-muted small mb-3">
                                {{ strtoupper(pathinfo($dokumen->file_path, PATHINFO_EXTENSION)) }} Document
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}"
                                   target="_blank"
                                   class="btn btn-primary btn-sm mb-2">
                                    <i class="fas fa-eye mr-1"></i>Lihat Dokumen
                                </a>
                                <a href="{{ route('master-dokumen.download', $dokumen->id) }}"
                                   class="btn btn-success btn-sm mb-2">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                                <a href="{{ route('master-dokumen.edit', $dokumen->id) }}"
                                   class="btn btn-warning btn-sm mb-2">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#deleteModal">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info Cards -->
    <div class="row">
        <!-- File Information -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info mr-1"></i>Informasi File
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Ekstensi:</strong></p>
                            <p class="text-muted">{{ strtoupper(pathinfo($dokumen->file_path, PATHINFO_EXTENSION)) }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Lokasi:</strong></p>
                            <p class="text-muted small">{{ $dokumen->file_path }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history mr-1"></i>Riwayat Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Dokumen dibuat</h6>
                                <p class="text-muted small mb-0">
                                    {{ \Carbon\Carbon::parse($dokumen->created_at)->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        @if($dokumen->updated_at != $dokumen->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Terakhir diperbarui</h6>
                                <p class="text-muted small mb-0">
                                    {{ \Carbon\Carbon::parse($dokumen->updated_at)->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('master-dokumen.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('master-dokumen.destroy', $dokumen->id) }}">
                @csrf @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                            Konfirmasi Hapus
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <p>Apakah Anda yakin ingin menghapus dokumen ini?</p>
                        <p><strong>{{ $dokumen->nama_dokumen }}</strong></p>
                        <p class="text-muted small">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i>Hapus Dokumen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -38px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: -33px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e3e6f0;
    }
</style>
@endpush

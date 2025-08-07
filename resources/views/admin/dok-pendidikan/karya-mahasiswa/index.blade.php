@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user mr-2"></i>
        {{ $title }}
    </h1>
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-center justify-content-xl-between">
            <div class="mb-1 mr-2">
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-sync mr-2"></i> Sync
                </a>
            </div>
            <div>
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel mr-2"></i> Excel
                </a>
                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf mr-2"></i> PDF
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Tahun</th>
                            <th>Judul Publikasi/Karya</th>
                            <th>Kegiatan</th>
                            <th>Tingkat</th>
                            <th>Lampiran</th>
                            <th>Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td>Anisya Hamidah</td>
                            <td>2021-2022</td>
                            <td>Prestasi kegiatan ..</td>
                            <td>Publikasi</td>
                            <td>Nasional</td>
                            <td class="text-center">
                                <div class="form-group">
                                    <button type="button" class="btn btn-info btn-sm"
                                        onclick="window.open('{{ asset('path/to/statuta_ucic.pdf') }}', '_blank')">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat Dokumen
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <!-- Tombol Validasi -->
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#validasiModal1">
                                    <a href="{{ route('karyaMhs-valid') }}" class="btn btn-primary">Ya</a>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal Konfirmasi -->
                        <div class="modal fade" id="validasiModal1" tabindex="-1" role="dialog"
                            aria-labelledby="validasiModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="validasiModalLabel">Konfirmasi Validasi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Yakin ingin memvalidasi dokumen <strong>Publikasi</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                        <!-- Simulasi redirect ke halaman detail dokumen -->
                                        <a href="{{ route('karyaMhs-valid') }}" class="btn btn-primary">Ya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Validasi -->
    <div class="modal fade" id="validasiModal1" tabindex="-1" role="dialog" aria-labelledby="validasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Validasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Yakin ingin memvalidasi dokumen <strong>STATUTA UCIC</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                    <a href="#" class="btn btn-primary">Ya</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-center
        justify-content-xl-between">
            <div class="mb-1 mr-2">
                <a href="{{ route('dok-rekCreate') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Data</a>
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-sync mr-2"></i>
                    Sync</a>
            </div>
            <div>

                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel mr-2"></i>
                    Excel</a>

                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf mr-2"></i>
                    PDF</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nomor Dokumen</th>
                            <th>Nama Dokumen</th>
                            <th>Di Upload</th>
                            <th>Tanggal Upload</th>
                            <th>Tanggal Pengesahan</th>
                            <th>Status</th>
                            <th>Lampiran</th>
                            <th>
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">01</td>
                            <td class="text-center">STATUTA UCIC</td>
                            <td class="text-center">
                                <span class="badge badge-dark"
                                    style="font-size:  0.75rem; padding: 0.5em 1em;">Rektorat</span>
                            </td>
                            <td class="text-center">
                                17-05-2025
                            </td>
                            <td class="text-center">
                                18-05-2025
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger" style="font-size:  0.73rem; padding: 0.5em 1em;">Belum Di
                                    Validasi</span>
                            </td>

                            <td class="text-center">
                                <a href="{{ asset('path/to/image.jpg') }}" target="_blank">
                                    <button class="btn btn-success btn-sm" style="font-size: 0.73rem; padding: 0.5em 1em;">
                                        Lampiran
                                    </button>
                                </a>
                            </td>


                            <td class="text-center">
                                <a href="#" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit mr-1"></i> Perbarui
                                </a>
                                {{-- <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash "></i>
                                </a> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

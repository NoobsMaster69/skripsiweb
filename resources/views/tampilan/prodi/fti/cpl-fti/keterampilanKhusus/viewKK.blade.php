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
                <a href="{{ route('kkCreate') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Data
                </a>
                <a href="{{ route('plprodi-fti') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
            <div>
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel mr-2"></i>
                    Excel
                </a>
                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf mr-2"></i>
                    PDF
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            <th style="width: 100px;">CPL SN-DIKTI</th>
                            <th style="min-width: 300px;">Deskripsi</th>
                            <th style="width: 150px;">Sumber</th>
                            <th style="width: 120px;">
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">PL-01</td>
                            <td>Lulusan menguasai konsep umum berbahasa,
                                numerasi, dan literasi bisnis ritel untuk mendukung
                                kinerja di lingkungan ritel.</td>
                            <td class="text-center">SN-DIKTI</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="#" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('layout/app')

@section('content')
    <h1 class="h4 mb-3 text-gray-800">
        <i class="fas fa-user mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            {{-- <div class="mb-1">
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-sync mr-1"></i> Sync
                </a>
            </div>
            <div>
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel mr-1"></i> Excel
                </a>
                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf mr-1"></i> PDF
                </a>
            </div> --}}
        </div>

        <div class="card-body pt-4 pb-5">
            {{-- <h6 class="font-weight-bold mb-4">Capaian Prodi</h6> --}}

            <div class="row g-4 justify-content-center align-items-stretch">

                <!-- CARD 1 -->
                <div class="col-md-6 col-lg-5 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="min-height: 150px;">
                        <div class="card-header text-white d-flex justify-content-between align-items-center"
                             style="background-color: #1a71cf;">
                            <span style="font-size: 13px;">Aspek Sikap</span>
                            <div>
                                <i class="fas fa-cog fa-sm mr-1"></i>
                                <i class="fas fa-ellipsis-v fa-sm"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center px-4">
                            <h5 class="card-title font-weight-bold mb-0" style="font-size: 18px;">SIKAP (S)</h5>
                            <a href="{{ route ('viewSikap-fti') }}" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                               style="width: 28px; height: 28px;">
                                <i class="fas fa-plus fa-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="col-md-6 col-lg-5 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="min-height: 150px;">
                        <div class="card-header text-white d-flex justify-content-between align-items-center"
                             style="background-color: #1a71cf;">
                            <span style="font-size: 13px;">Aspek Keterampilan Umum</span>
                            <div>
                                <i class="fas fa-cog fa-sm mr-1"></i>
                                <i class="fas fa-ellipsis-v fa-sm"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center px-4">
                            <h5 class="card-title font-weight-bold mb-0" style="font-size: 18px;">Keterampilan Umum (KU)</h5>
                            <a href="{{ route ('viewKU-fti') }}" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                               style="width: 28px; height: 28px;">
                                <i class="fas fa-plus fa-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="col-md-6 col-lg-5">
                    <div class="card h-100 shadow-sm border-0" style="min-height: 150px;">
                        <div class="card-header text-white d-flex justify-content-between align-items-center"
                             style="background-color: #1a71cf;">
                            <span style="font-size: 13px;">Aspek Keterampilan Khusus</span>
                            <div>
                                <i class="fas fa-cog fa-sm mr-1"></i>
                                <i class="fas fa-ellipsis-v fa-sm"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center px-4">
                            <h5 class="card-title font-weight-bold mb-0" style="font-size: 18px;">Keterampilan Khusus (KS)</h5>
                            <a href="{{ route ('viewKK-fti') }}" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                               style="width: 28px; height: 28px;">
                                <i class="fas fa-plus fa-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CARD 4 -->
                <div class="col-md-6 col-lg-5">
                    <div class="card h-100 shadow-sm border-0" style="min-height: 150px;">
                        <div class="card-header text-white d-flex justify-content-between align-items-center"
                             style="background-color: #1a71cf;">
                            <span style="font-size: 13px;">Aspek Pengetahuan</span>
                            <div>
                                <i class="fas fa-cog fa-sm mr-1"></i>
                                <i class="fas fa-ellipsis-v fa-sm"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center px-4">
                            <h5 class="card-title font-weight-bold mb-0" style="font-size: 18px;">Pengetahuan (P)</h5>
                            <a href="{{ route ('viewPengetahuan-fti') }}" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                               style="width: 28px; height: 28px;">
                                <i class="fas fa-plus fa-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

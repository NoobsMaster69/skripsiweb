@extends('layout/app')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-3">Master Dokumen Kebijakan</h4>

        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm border-start border-3 border-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted small">TOTAL DOKUMEN</div>
                            <h4 class="mb-0">{{ $total }}</h4>
                        </div>
                        <i class="fa fa-file-alt fa-2x text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm border-start border-3 border-success">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted small">DOKUMEN PDF</div>
                            <h4 class="mb-0">{{ $pdf }}</h4>
                        </div>
                        <i class="fa fa-file-pdf fa-2x text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm border-start border-3 border-info">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted small">DOKUMEN WORD</div>
                            <h4 class="mb-0">{{ $word }}</h4>
                        </div>
                        <i class="fa fa-file-word fa-2x text-info"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm border-start border-3 border-warning">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted small">DOKUMEN TERBARU</div>
                            <h4 class="mb-0">{{ $terbaru->nomor ?? '-' }}</h4>
                        </div>
                        <i class="fa fa-calendar-alt fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Daftar Master Dokumen</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="background-color: #3366cc; color: white;">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nomor</th>
                            <th class="text-center">Nama Dokumen</th>
                            <th class="text-center">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dokumens as $i => $dokumen)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><span class="badge badge-info">{{ $dokumen->nomor }}</span></td>
                                <td>
                                    <strong>{{ $dokumen->nama }}</strong><br>
                                    <small>{{ $dokumen->keterangan }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('rektorat.master-dokumen.view', $dokumen->id) }}"
                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                        Lihat
                                    </a>

                                    <a href="{{ route('rektorat.master-dokumen.download', $dokumen->id) }}"
                                        class="btn btn-sm btn-outline-success">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

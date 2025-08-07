@extends('layout/app') {{-- Atur sesuai layout kamu --}}

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">
            <i class="fas fa-folder-open text-primary mr-2"></i> {{ $title ?? 'Dokumen Buku Kurikulum (Prodi)' }}
        </h4>

        {{-- Statistik Kartu --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body text-center">
                        <strong>TOTAL DOKUMEN</strong>
                        <h4>{{ $dokumens->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-left-danger">
                    <div class="card-body text-center">
                        <strong>DOKUMEN PDF</strong>
                        <h4>{{ $dokumens->where('tipe', 'pdf')->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body text-center">
                        <strong>DOKUMEN WORD</strong>
                        <h4>{{ $dokumens->where('tipe', 'word')->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-body text-center">
                        <strong>DOKUMEN TERBARU</strong>
                        <h4>{{ $dokumens->sortByDesc('created_at')->first()->nomor ?? '-' }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Dokumen --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>Daftar Master Dokumen</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 15%;">Nomor</th>
                                <th style="width: 40%;">Nama Dokumen</th>
                                <th style="width: 20%;">File</th>
                                <th style="width: 20%;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dokumens as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge badge-pill badge-info py-2 px-3">{{ $item->nomor }}</span>
                                    </td>
                                    <td class="text-left">
                                        <i class="fas fa-file-pdf text-danger mr-2 fa-lg"></i>
                                        <strong>{{ $item->nama }}</strong><br>
                                        <small class="text-muted">{{ $item->keterangan ?? 'Tidak ada keterangan' }}</small>
                                    </td>
                                    <td>
                                        @if ($item->file_path)
                                            <a href="{{ route('master-dokumen-buku.view', $item->id) }}" target="_blank"
                                                class="btn btn-outline-info btn-sm mb-1">
                                                <i class="fas fa-eye"></i> Lihat Dokumen
                                            </a>
                                            <a href="{{ route('master-dokumen-buku.download', $item->id) }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ \Carbon\Carbon::parse($item->created_at)->setTimezone('Asia/Jakarta')->format('d/m/Y') }}
                                        <br>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($item->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted">Belum ada dokumen.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

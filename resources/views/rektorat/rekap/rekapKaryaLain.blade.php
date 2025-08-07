@extends('layout/app')

@section('content')
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-bullseye text-primary me-2"></i>
            {{ $title }}
        </h1>
    </div>
    <a href="{{ route('rekapRektorat.karyalainnya.grafik') }}" class="btn btn-primary mb-3">
        <i class="fas fa-chart-bar"></i> Lihat Grafik Karya Mahasiswa
    </a>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('rekapRektorat.mhsKaryaLainnya') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="tahun" class="form-label fw-bold">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control form-control-sm">
                            <option value="">-- Semua Tahun --</option>
                            @foreach ($listTahun as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="prodi" class="form-label fw-bold">Program Studi</label>
                        <select name="prodi" id="prodi" class="form-control form-control-sm">
                            <option value="">-- Semua Prodi --</option>
                            @foreach ($listProdi as $prodi)
                                <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                    {{ $prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Fakultas</label>
                        <select name="fakultas" class="form-control form-control-sm">
                            <option value="">-- Semua Fakultas --</option>
                            <option value="FTI" {{ request('fakultas') == 'FTI' ? 'selected' : '' }}>FTI</option>
                            <option value="FEB" {{ request('fakultas') == 'FEB' ? 'selected' : '' }}>FEB</option>
                        </select>
                    </div>


                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" name="submit_filter" value="1" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan Data
                            </button>
                            <a href="{{ route('rekapRektorat.mhsKaryaLainnya') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Jenis Kegiatan</label>
                        <select name="kegiatan" class="form-control form-control-sm">
                            <option value="">-- Semua Kegiatan --</option>
                            <option value="Produk" {{ request('kegiatan') == 'Produk' ? 'selected' : '' }}>Produk</option>
                            <option value="Jasa" {{ request('kegiatan') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (request()->has('submit_filter') && $data && $data->count())
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 text-primary">Data Karya Mahasiswa Lainnya</h6>
                <form id="exportForm" method="GET" target="_blank">
                    <!-- Kirimkan filter sebagai input hidden -->
                    @foreach (request()->all() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div class="btn-group" style="gap: 10px;">
                        <button type="button" onclick="exportData('excel')" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" onclick="exportData('pdf')" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover table-sm" id="dataTable">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Judul Karya</th>
                            <th>Kegiatan</th>
                            <th>Program Studi</th>
                            <th>Fakultas</th>
                            <th>Tanggal</th>
                            <th>Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $item->nm_mhs }}</strong><br>
                                    <small>{{ $item->nim }}</small>
                                </td>
                                <td>{{ $item->judul_karya }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge {{ $item->kegiatan_badge_class ?? 'bg-secondary' }}">{{ $item->kegiatan }}</span>
                                </td>
                                <td class="text-center">{{ $item->prodi }}</td>
                                <td class="text-center">{{ $item->fakultas }}</td>
                                <td class="text-center">
                                    {{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($item->file_upload)
                                        <a href="{{ asset('storage/' . $item->file_upload) }}" target="_blank"
                                            class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(request()->has('submit_filter'))
        <div class="alert alert-warning text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data ditemukan.
        </div>
    @endif

    <script>
        function exportData(type) {
            const form = document.getElementById('exportForm');
            if (type === 'excel') {
                form.action = "{{ route('rekapRektorat.mhsKaryaLainnya.export.excel') }}";
            } else {
                form.action = "{{ route('rekapRektorat.mhsKaryaLainnya.export.pdf') }}";
            }
            form.submit();
        }
    </script>
@endsection

@extends('layout/app')

@section('content')
    <!-- Page Title -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800 d-flex align-items-center">
            <i class="fas fa-bullseye text-primary me-2"></i> {{ $title }}
        </h1>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('rekapProdi.publikasi') }}" method="GET">
                <div class="row">
                    <!-- Tahun -->
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

                    <!-- Program Studi -->
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

                    <!-- Fakultas -->
                    <div class="col-md-3 mb-3">
                        <label for="fakultas" class="form-label fw-bold">Fakultas</label>
                        <select name="fakultas" id="fakultas" class="form-control form-control-sm">
                            <option value="">-- Semua Fakultas --</option>
                            <option value="FTI" {{ request('fakultas') == 'FTI' ? 'selected' : '' }}>FTI</option>
                            <option value="FEB" {{ request('fakultas') == 'FEB' ? 'selected' : '' }}>FEB</option>
                        </select>
                    </div>

                    <!-- Tanggal Awal -->
                    <div class="col-md-3 mb-3">
                        <label for="tanggal_awal" class="form-label fw-bold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm"
                            value="{{ request('tanggal_awal') }}">
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="col-md-3 mb-3">
                        <label for="tanggal_akhir" class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-sm"
                            value="{{ request('tanggal_akhir') }}">
                    </div>

                    <!-- Jenis Publikasi -->
                    <div class="col-md-3 mb-3">
                        <label for="jenis_publikasi" class="form-label fw-bold">Jenis Publikasi</label>
                        <select name="jenis_publikasi" id="jenis_publikasi" class="form-control form-control-sm">
                            <option value="">-- Semua Jenis --</option>
                            <option value="buku" {{ request('jenis_publikasi') == 'buku' ? 'selected' : '' }}>Buku</option>
                            <option value="jurnal_artikel" {{ request('jenis_publikasi') == 'jurnal_artikel' ? 'selected' : '' }}>
                                Jurnal / Artikel</option>
                            <option value="media_massa" {{ request('jenis_publikasi') == 'media_massa' ? 'selected' : '' }}>
                                Media Massa</option>
                        </select>
                    </div>

                    <!-- Kegiatan (Read Only) -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Kegiatan</label>
                        <input type="text" class="form-control form-control-sm" value="Publikasi Mahasiswa" readonly>
                        <input type="hidden" name="kegiatan" value="Publikasi Mahasiswa">
                    </div>

                    <!-- Tombol Filter & Reset -->
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" name="submit_filter" value="1" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapProdi.publikasi') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Tabel -->
    @if (request()->has('submit_filter') && $publikasi && $publikasi->count())
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 text-primary">Data Publikasi Mahasiswa</h6>
                <form id="exportForm" method="GET" target="_blank">
                    @foreach (['tahun', 'prodi', 'fakultas', 'tanggal_awal', 'tanggal_akhir', 'jenis_publikasi'] as $key)
                        <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
                    @endforeach
                    <input type="hidden" name="kegiatan" value="Publikasi Mahasiswa">

                    <div class="btn-group">
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
                            <th>Jenis Publikasi</th>
                            <th>Program Studi</th>
                            <th>Fakultas</th>
                            <th>Tanggal</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publikasi as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $item->nm_mhs }}</strong><br>
                                    <small>{{ $item->nim }}</small>
                                </td>
                                <td>{{ $item->judul_karya }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->jenis_publikasi_badge_class }}">
                                        {{ $item->formatted_jenis_publikasi }}
                                    </span>
                                </td>
                                <td>{{ $item->prodi }}</td>
                                <td>{{ $item->fakultas }}</td>
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

    <!-- Export Script -->
    <script>
        function exportData(type) {
            const form = document.getElementById('exportForm');
            form.action = (type === 'excel')
                ? "{{ route('rekapProdi.publikasi.export.excel') }}"
                : "{{ route('rekapProdi.publikasi.export.pdf') }}";
            form.submit();
        }
    </script>
@endsection

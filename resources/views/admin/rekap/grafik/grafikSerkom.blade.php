@extends('layout.app')
@section('title', $title)

@section('content')
    <div class="container mt-4">
        <h4 class="mb-3 fw-bold text-primary">{{ $title }}</h4>

        {{-- Filter Form --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rekapBPM.serkom.grafik') }}">
                    <input type="hidden" name="submit_filter" value="1">
                    <div class="row g-3 align-items-end">
                        {{-- Tahun --}}
                        <div class="col-md-2">
                            <label for="tahun" class="form-label fw-semibold text-secondary">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">-- Tahun --</option>
                                @foreach ($listTahun as $thn)
                                    <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>
                                        {{ $thn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Periode --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Periode (3 Tahun)</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="number" name="tahun_awal" class="form-control" placeholder="Dari tahun"
                                    value="{{ request('tahun_awal') }}">
                                <span class="fw-bold">-</span>
                                <input type="number" name="tahun_akhir" class="form-control" placeholder="Sampai tahun"
                                    value="{{ request('tahun_akhir') }}">
                            </div>
                        </div>

                        {{-- Prodi --}}
                        <div class="col-md-3">
                            <label for="prodi" class="form-label fw-semibold text-secondary">Program Studi</label>
                            <select name="prodi" class="form-control">
                                <option value="">-- Semua Prodi --</option>
                                @foreach ($listProdi as $prodi)
                                    <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                        {{ $prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tingkatan --}}
                        <div class="col-md-2">
                            <label for="tingkatan" class="form-label fw-semibold text-secondary">Tingkat</label>
                            <select name="tingkatan" class="form-control">
                                <option value="">-- Semua Tingkat --</option>
                                <option value="lokal" {{ request('tingkatan') == 'lokal' ? 'selected' : '' }}>Lokal
                                </option>
                                <option value="nasional" {{ request('tingkatan') == 'nasional' ? 'selected' : '' }}>
                                    Nasional</option>
                                <option value="internasional"
                                    {{ request('tingkatan') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="col-md-auto mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapBPM.serkom.grafik') }}"
                                class="btn btn-outline-secondary px-4 shadow-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (count($labels) > 0)
            {{-- Ringkasan Total --}}
            <div class="mb-4">
                <div class="card bg-light border-0 shadow-sm mb-3">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Total Sertifikasi Mahasiswa</h6>
                        @php
                            $totalSertifikasi =
                                array_sum($datasetLokal) +
                                array_sum($datasetNasional) +
                                array_sum($datasetInternasional);
                        @endphp
                        <h2 class="fw-bold text-dark">{{ $totalSertifikasi }}</h2>
                    </div>
                </div>

                {{-- Tabel Ringkasan --}}
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Tingkatan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>🏫 Lokal</td>
                                <td>{{ array_sum($datasetLokal) }}</td>
                            </tr>
                            <tr>
                                <td>🏛️ Nasional</td>
                                <td>{{ array_sum($datasetNasional) }}</td>
                            </tr>
                            <tr>
                                <td>🌐 Internasional</td>
                                <td>{{ array_sum($datasetInternasional) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Grafik --}}
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">Grafik Sertifikasi Mahasiswa Berdasarkan Tingkatan per Tahun
                </div>
                <div class="card-body">
                    <canvas id="chartSerkom" height="120"></canvas>
                </div>
            </div>
        @else
            <div class="alert alert-warning shadow-sm">
                <i class="fas fa-exclamation-circle me-1"></i> Tidak ada data untuk filter yang dipilih.
            </div>
        @endif

        {{-- Kembali --}}
        <div class="mt-4">
            <a href="{{ route('rekapBPM.serkom') }}" class="btn btn-outline-secondary">
                ← Kembali ke Tabel Rekap
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const datasetLokal = @json($datasetLokal);
        const datasetNasional = @json($datasetNasional);
        const datasetInternasional = @json($datasetInternasional);

        const ctx = document.getElementById('chartSerkom')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Lokal',
                            data: datasetLokal,
                            backgroundColor: '#36A2EB'
                        },
                        {
                            label: 'Nasional',
                            data: datasetNasional,
                            backgroundColor: '#FF6384'
                        },
                        {
                            label: 'Internasional',
                            data: datasetInternasional,
                            backgroundColor: '#4BC0C0'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tahun'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Sertifikasi'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        },
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

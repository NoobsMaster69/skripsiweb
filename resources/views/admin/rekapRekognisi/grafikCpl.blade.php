@extends('layout.app')
@section('content')
    <div class="container">
        <h4 class="mb-4 fw-bold text-primary">{{ $title }}</h4>

        {{-- Filter --}}
        <form method="GET" action="{{ route('rekapRekognisi.grafik') }}" class="mb-4">
            <div class="row g-3 align-items-end">
                {{-- Tahun --}}
                <div class="col-md-2">
                    <label for="tahun" class="form-label fw-semibold text-secondary">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">-- Tahun --</option>
                        @foreach ($listTahun as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Periode --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Periode (3 Tahun)</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" name="periode_awal" class="form-control" placeholder="Dari Tahun"
                            value="{{ request('periode_awal') }}">
                        <span>-</span>
                        <input type="number" name="periode_akhir" class="form-control" placeholder="Sampai Tahun"
                            value="{{ request('periode_akhir') }}">
                    </div>
                </div>

                {{-- Bidang Rekognisi --}}
                <div class="col-md-3">
                    <label for="bidang" class="form-label fw-semibold text-secondary">Bidang Rekognisi</label>
                    <select name="bidang" class="form-control">
                        <option value="">-- Semua Bidang --</option>
                        @foreach ($listBidang as $bidang)
                            <option value="{{ $bidang }}" {{ request('bidang') == $bidang ? 'selected' : '' }}>
                                {{ $bidang }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- Tombol --}}
                <div class="col-md-auto mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Tampilkan</button>
                    <a href="{{ route('rekapRekognisi.grafik') }}" class="btn btn-outline-secondary px-4">Reset</a>
                </div>
            </div>
        </form>

        @if ($data->count() > 0)
            {{-- Ringkasan --}}
            <div class="mb-4">
                <div class="card shadow-sm bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Total Rekognisi Dosen</h6>
                        <h2 class="fw-bold text-dark">{{ $data->sum('total') }}</h2>
                    </div>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Bidang Rekognisi</th>
                            <th>Jumlah Rekognisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row['label'] }}</td>
                                <td>{{ $row['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Grafik Grouped --}}
            <div class="card shadow-sm animate__animated animate__fadeIn">
                <div class="card-header bg-white fw-semibold">Grafik Rekognisi per Tahun Akademik & Bidang</div>
                <div class="card-body">
                    <canvas id="rekognisiGroupedChart" height="120"></canvas>
                </div>
            </div>
        @else
            <div class="alert alert-warning shadow-sm">Tidak ada data untuk filter yang dipilih.</div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="mt-4">
            <a href="{{ route('rekapRekognisi.index') }}" class="btn btn-outline-secondary">← Kembali ke Tabel Rekap</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- ChartJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartRaw = @json($groupedChartData); // { 2021: { Pendidikan: 4, Penelitian: 2 }, ... }

        const tahunLabels = Object.keys(chartRaw);
        const bidangSet = new Set();

        tahunLabels.forEach(t => {
            Object.keys(chartRaw[t]).forEach(bid => bidangSet.add(bid));
        });

        const bidangLabels = Array.from(bidangSet);
        const colors = ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc', '#fd7e14', '#20c997', '#6610f2'];

        const datasets = bidangLabels.map((bidang, i) => ({
            label: bidang,
            data: tahunLabels.map(tahun => chartRaw[tahun]?.[bidang] ?? 0),
            backgroundColor: colors[i % colors.length]
        }));

        const ctx = document.getElementById('rekognisiGroupedChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tahunLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Grouped Grafik Rekognisi Dosen',
                        font: {
                            size: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.dataset.label}: ${ctx.formattedValue}`
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Tahun Akademik'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Rekognisi'
                        }
                    }
                }
            }
        });
    </script>

    {{-- Animasi --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@extends('layout.app')
@section('title', $title)

@section('content')
    <div class="container mt-4">
        <h4 class="mb-3 fw-bold text-primary">{{ $title }}</h4>

        {{-- Filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rekapProdi.adopsi.grafik') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-secondary">Tahun</label>
                            <select name="tahun" class="form-control">
                                <option value="">-- Tahun --</option>
                                @foreach ($listTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Periode (3 Tahun)</label>
                            <div class="d-flex gap-3">
                                <input type="number" name="tahun_awal" class="form-control" placeholder="Dari tahun"
                                    value="{{ request('tahun_awal') }}">
                                <span class="px-1">-</span>
                                <input type="number" name="tahun_akhir" class="form-control" placeholder="Sampai tahun"
                                    value="{{ request('tahun_akhir') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Program Studi</label>
                            <select name="prodi" class="form-control">
                                <option value="">-- Semua Prodi --</option>
                                @foreach ($listProdi as $prodi)
                                    <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                        {{ $prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Jenis Kegiatan</label>
                            <select name="kegiatan" class="form-control">
                                <option value="">-- Semua Kegiatan --</option>
                                <option value="Produk" {{ request('kegiatan') == 'Produk' ? 'selected' : '' }}>Produk
                                </option>
                                <option value="Jasa" {{ request('kegiatan') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                            </select>
                        </div>
                        <div class="col-md-auto mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary shadow-sm px-4">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapProdi.adopsi.grafik') }}"
                                class="btn btn-outline-secondary shadow-sm px-4">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="fw-semibold text-muted mb-2">Total Jumlah Adopsi</div>
                <div class="h2 fw-bold text-primary">{{ collect($grafikData)->flatten()->sum() }}</div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Tahun</th>
                        <th>🛠️ Produk</th>
                        <th>🤝 Jasa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grafikData as $tahun => $jenis)
                        <tr>
                            <td>{{ $tahun }}</td>
                            <td>{{ $jenis['Produk'] ?? 0 }}</td>
                            <td>{{ $jenis['Jasa'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Grafik --}}
        <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
            <div class="card-header bg-white fw-semibold">Grafik Jumlah Adopsi Mahasiswa per Tahun</div>
            <div class="card-body">
                <canvas id="chartAdopsi" height="120"></canvas>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('rekapProdi.mhsAdopsi') }}" class="btn btn-outline-secondary">
                ← Kembali ke Tabel Rekap
            </a>
            <a href="{{ route('prodi.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        const rawData = @json($grafikData); // Format: {2022: {Produk: 4, Jasa: 2}, ...}
        const tahunLabels = Object.keys(rawData);
        const kegiatanList = ['Produk', 'Jasa'];
        const labelMap = {
            Produk: '🛠️ Produk',
            Jasa: '🤝 Jasa'
        };
        const warna = {
            Produk: '#4e73df',
            Jasa: '#1cc88a'
        };

        const datasets = kegiatanList.map(kegiatan => ({
            label: labelMap[kegiatan],
            backgroundColor: warna[kegiatan],
            data: tahunLabels.map(tahun => rawData[tahun]?.[kegiatan] ?? 0)
        }));

        const ctx = document.getElementById('chartAdopsi')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: tahunLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Grafik Jumlah Karya Mahasiswa yang Diadopsi per Tahun',
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'start',
                            offset: -10,
                            color: '#333',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.dataset.label + ': ' + ctx.formattedValue
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tahun'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Adopsi'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>
@endsection

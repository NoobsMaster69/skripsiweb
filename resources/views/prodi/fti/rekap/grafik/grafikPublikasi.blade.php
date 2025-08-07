@extends('layout.app')
@section('title', $title)

@section('content')
    <div class="container mt-4">
        <h4 class="mb-3 fw-bold text-primary">{{ $title }}</h4>

        {{-- Filter Form --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rekapProdi.publikasi.grafik') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-secondary">Tahun</label>
                            <select name="tahun" class="form-control">
                                <option value="">-- Tahun --</option>
                                @foreach ($listTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
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
                                        {{ $prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Jenis Publikasi</label>
                            <select name="jenis_publikasi" class="form-control">
                                <option value="">-- Semua Jenis Publikasi --</option>
                                <option value="buku" {{ request('jenis_publikasi') == 'buku' ? 'selected' : '' }}>Buku
                                </option>
                                <option value="jurnal_artikel"
                                    {{ request('jenis_publikasi') == 'jurnal_artikel' ? 'selected' : '' }}>Jurnal / Artikel
                                </option>
                                <option value="media_massa"
                                    {{ request('jenis_publikasi') == 'media_massa' ? 'selected' : '' }}>Media Massa
                                </option>
                            </select>
                        </div>

                        <div class="col-md-auto mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary shadow-sm px-4">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapProdi.publikasi.grafik') }}"
                                class="btn btn-outline-secondary shadow-sm px-4">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ✅ Ringkasan Total --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="fw-semibold text-muted mb-2">Total Publikasi Mahasiswa</div>
                <div class="h2 fw-bold text-primary">
                    {{ collect($grafikData)->map(fn($d) => is_array($d) ? array_sum($d) : $d)->sum() }}
                </div>
            </div>
        </div>

        {{-- ✅ Tabel Ringkasan per Jenis Publikasi --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Jenis Publikasi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPerJenis = [];
                        foreach ($grafikData as $tahun => $items) {
                            foreach ($items as $jenis => $jumlah) {
                                $totalPerJenis[$jenis] = ($totalPerJenis[$jenis] ?? 0) + $jumlah;
                            }
                        }

                        $labelMap = [
                            'jurnal_artikel' => '📰 Jurnal / Artikel',
                            'buku' => '📚 Buku',
                            'media_massa' => '🗞️ Media Massa',
                        ];
                    @endphp

                    @forelse ($totalPerJenis as $jenis => $jumlah)
                        <tr>
                            <td>{{ $labelMap[$jenis] ?? ucfirst($jenis) }}</td>
                            <td>{{ $jumlah }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Grafik --}}
        <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
            <div class="card-header bg-white fw-semibold">Grafik Jumlah Publikasi Mahasiswa</div>
            <div class="card-body">
                <canvas id="chartPublikasi" height="120"></canvas>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-4">
            <a href="{{ route('rekapProdi.publikasi') }}" class="btn btn-outline-secondary">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        const rawData = @json($grafikData); // Format: {2021: {buku: 3, jurnal_artikel: 4, media_massa: 2}, ...}
        const labelMap = {
            'jurnal_artikel': '📰 Jurnal / Artikel',
            'buku': '📚 Buku',
            'media_massa': '🗞️ Media Massa'
        };
        const colors = {
            'jurnal_artikel': '#4e73df',
            'buku': '#e74a3b',
            'media_massa': '#1cc88a'
        };
        const jenisList = ['jurnal_artikel', 'buku', 'media_massa'];
        const tahunLabels = Object.keys(rawData);

        const datasets = jenisList.map(jenis => ({
            label: labelMap[jenis],
            backgroundColor: colors[jenis],
            data: tahunLabels.map(tahun => rawData[tahun]?.[jenis] ?? 0)
        }));

        const ctx = document.getElementById('chartPublikasi')?.getContext('2d');
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
                            text: 'Grafik Publikasi Mahasiswa per Tahun',
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: ctx => ctx.dataset.label + ': ' + ctx.formattedValue
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
                                text: 'Jumlah Publikasi'
                            },
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>
@endsection

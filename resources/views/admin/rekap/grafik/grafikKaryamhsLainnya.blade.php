@extends('layout.app')
@section('title', $title)

@section('content')
    <div class="container mt-4">
        <h4 class="mb-3 fw-bold text-primary">{{ $title }}</h4>

        {{-- Filter Form --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rekapBPM.karyalainnya.grafik') }}">
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
                            <label class="form-label fw-semibold text-secondary">Jenis Kegiatan</label>
                            <select name="kegiatan" class="form-control">
                                <option value="">-- Semua Kegiatan --</option>
                                <option value="Produk" {{ request('kegiatan') == 'Produk' ? 'selected' : '' }}>🛠️ Produk
                                </option>
                                <option value="Jasa" {{ request('kegiatan') == 'Jasa' ? 'selected' : '' }}>🤝 Jasa
                                </option>
                            </select>
                        </div>

                        <div class="col-md-auto mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary shadow-sm px-4">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapBPM.karyalainnya.grafik') }}"
                                class="btn btn-outline-secondary shadow-sm px-4">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Ringkasan Total --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="fw-semibold text-muted mb-2">Total Karya Mahasiswa</div>
                <div class="h2 fw-bold text-primary">
                    {{ collect($grafikData)->map(fn($d) => is_array($d) ? array_sum($d) : $d)->sum() }}
                </div>
            </div>
        </div>

        {{-- Tabel Rekap --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Jenis Kegiatan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($grafikData) > 0 && is_array(reset($grafikData)))
                        @php
                            $totalPerJenis = [];
                            foreach ($grafikData as $tahun => $items) {
                                foreach ($items as $jenis => $jumlah) {
                                    $totalPerJenis[$jenis] = ($totalPerJenis[$jenis] ?? 0) + $jumlah;
                                }
                            }
                        @endphp
                        @foreach ($totalPerJenis as $jenis => $jumlah)
                            <tr>
                                <td>
                                    @switch($jenis)
                                        @case('Karya Inovatif')
                                            🧠 Karya Inovatif
                                        @break

                                        @case('Karya Sosial')
                                            🤝 Karya Sosial
                                        @break

                                        @default
                                            {{ ucfirst($jenis) }}
                                    @endswitch
                                </td>
                                <td>{{ $jumlah }}</td>
                            </tr>
                        @endforeach
                    @else
                        @forelse ($grafikData as $jenis => $jumlah)
                            <tr>
                                <td>{{ ucfirst($jenis) }}</td>
                                <td>{{ $jumlah }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Grafik --}}
        <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
            <div class="card-header bg-white fw-semibold">Grafik Karya Mahasiswa</div>
            <div class="card-body">
                <canvas id="chartKaryaLain" height="120"></canvas>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-4">
            <a href="{{ route('rekapBPM.mhsKaryaLainnya') }}" class="btn btn-outline-secondary">
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
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const rawData = @json($grafikData); // format: {2021: {'Produk': 3}, 2022: {'Jasa': 2}}

        // Ambil semua tahun
        const tahunLabels = Object.keys(rawData);

        // Ambil semua jenis kegiatan yang muncul
        const jenisSet = new Set();
        tahunLabels.forEach(tahun => {
            const dataTahun = rawData[tahun];
            Object.keys(dataTahun).forEach(jenis => jenisSet.add(jenis));
        });
        const jenisList = Array.from(jenisSet);

        const warnaDefault = ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc'];
        const labelMap = {
            'Produk': '🛠️ Produk',
            'Jasa': '🤝 Jasa',
            'Karya Inovatif': '🧠 Karya Inovatif',
            'Karya Sosial': '🤝 Karya Sosial'
        };

        const datasets = jenisList.map((jenis, idx) => ({
            label: labelMap[jenis] ?? jenis,
            backgroundColor: warnaDefault[idx % warnaDefault.length],
            data: tahunLabels.map(tahun => rawData[tahun]?.[jenis] ?? 0)
        }));

        const ctx = document.getElementById('chartKaryaLain')?.getContext('2d');
        if (ctx && tahunLabels.length > 0 && datasets.length > 0) {
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
                            text: 'Grafik Karya Mahasiswa Lainnya per Tahun',
                            font: {
                                size: 18,
                                weight: 'bold'
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: context => context.dataset.label + ': ' + context.formattedValue
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
                                text: 'Jumlah Karya'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection

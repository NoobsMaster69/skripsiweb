@extends('layout.app')
@section('content')
    <div class="container">
        <h4 class="mb-4 fw-bold text-primary">{{ $title }}</h4>

        {{-- Filter dalam Card Putih --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rekapProdi.prestasi.grafik') }}">
                    <div class="row g-3 align-items-end">
                        {{-- Tahun --}}
                        <div class="col-md-2">
                            <label for="tahun" class="form-label fw-semibold text-secondary">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">-- Tahun --</option>
                                @foreach ($listTahun as $thn)
                                    <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Periode (3 Tahun) --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Periode (3 Tahun)</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="periode_dari" class="form-control" placeholder="Dari tahun" value="{{ request('periode_dari') }}">
                                <span class="pt-2">-</span>
                                <input type="number" name="periode_sampai" class="form-control" placeholder="Sampai tahun" value="{{ request('periode_sampai') }}">
                            </div>
                        </div>

                        {{-- Program Studi --}}
                        <div class="col-md-3">
                            <label for="prodi" class="form-label fw-semibold text-secondary">Program Studi</label>
                            <select name="prodi" class="form-control">
                                <option value="">-- Semua Prodi --</option>
                                @foreach ($listProdi as $prodi)
                                    <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tingkat --}}
                        <div class="col-md-2">
                            <label for="tingkat" class="form-label fw-semibold text-secondary">Tingkat</label>
                            <select name="tingkat" class="form-control">
                                <option value="">-- Semua Tingkat --</option>
                                <option value="1" {{ request('tingkat') == '1' ? 'selected' : '' }}>Lokal</option>
                                <option value="2" {{ request('tingkat') == '2' ? 'selected' : '' }}>Nasional</option>
                                <option value="3" {{ request('tingkat') == '3' ? 'selected' : '' }}>Internasional</option>
                            </select>
                        </div>

                        {{-- Jenis Prestasi --}}
                        <div class="col-md-3">
                            <label for="jenis_prestasi" class="form-label fw-semibold text-secondary">Jenis Prestasi</label>
                            <select name="jenis_prestasi" class="form-control">
                                <option value="">-- Semua Jenis --</option>
                                <option value="prestasi-akademik" {{ request('jenis_prestasi') == 'prestasi-akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="prestasi-non-akademik" {{ request('jenis_prestasi') == 'prestasi-non-akademik' ? 'selected' : '' }}>Non Akademik</option>
                            </select>
                        </div>

                        {{-- Tombol --}}
                        <div class="col-md-auto mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary shadow-sm px-4">Tampilkan</button>
                            <a href="{{ route('rekapProdi.prestasi.grafik') }}" class="btn btn-outline-secondary shadow-sm px-4">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Label Periode --}}
        @php
            $labelFilter =
                request('periode_dari') && request('periode_sampai')
                    ? 'Periode ' . request('periode_dari') . ' - ' . request('periode_sampai')
                    : (request('tahun') ? 'Tahun ' . request('tahun') : 'Semua Tahun');
        @endphp

        @if (!empty($dataChartByTahun))
            {{-- Total Prestasi --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="fw-semibold text-muted mb-2">Total Prestasi Mahasiswa</div>
                    <div class="h2 fw-bold text-primary">
                        {{ collect($dataChartByTahun)->flatten()->sum() }}
                    </div>
                </div>
            </div>

            {{-- Rekap Jenis Prestasi --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Jenis Prestasi</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rekapJenis = $rekapJenisPrestasi ?? [];
                            $labelJenis = [
                                'prestasi-akademik' => '🎓 Akademik',
                                'prestasi-non-akademik' => '🎯 Non-Akademik',
                            ];
                        @endphp

                        @forelse ($rekapJenis as $jenis => $jumlah)
                            <tr>
                                <td>{{ $labelJenis[$jenis] ?? ucfirst($jenis) }}</td>
                                <td>{{ $jumlah }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Tidak ada data jenis prestasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Grafik --}}
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">Grafik Prestasi Mahasiswa per Tahun & Tingkat</div>
                <div class="card-body">
                    <canvas id="chartTingkat" height="120"></canvas>
                </div>
            </div>
        @else
            <div class="alert alert-warning shadow-sm">Tidak ada data untuk filter yang dipilih.</div>
        @endif

        <div class="mt-4">
            <a href="{{ route('rekapRektorat.prestasi') }}" class="btn btn-outline-secondary">
                ← Kembali ke Tabel Rekap
            </a>
            <a href="{{ route('prodi.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dataChart = @json($dataChartByTahun);
        const tahunLabels = Object.keys(dataChart);
        const wilayahData = tahunLabels.map(t => dataChart[t]['Wilayah'] || 0);
        const nasionalData = tahunLabels.map(t => dataChart[t]['Nasional'] || 0);
        const internasionalData = tahunLabels.map(t => dataChart[t]['Internasional'] || 0);

        const ctx = document.getElementById('chartTingkat')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: tahunLabels,
                    datasets: [
                        {
                            label: 'Wilayah',
                            data: wilayahData,
                            backgroundColor: '#36A2EB'
                        },
                        {
                            label: 'Nasional',
                            data: nasionalData,
                            backgroundColor: '#FF6384'
                        },
                        {
                            label: 'Internasional',
                            data: internasionalData,
                            backgroundColor: '#4BC0C0'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Grafik Prestasi Mahasiswa - {{ $labelFilter }}',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Prestasi'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tahun'
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection

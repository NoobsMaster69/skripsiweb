@extends('layout.app')
@section('content')
    <div class="container">
        <h4 class="mb-4 fw-bold text-primary">{{ $title }}</h4>



        {{-- Filter Tahun --}}
        <form method="GET" action="{{ route('rekapCpl.grafik') }}" class="mb-4">
            <div class="row g-3">
                {{-- Kolom Tahun (Tunggal) --}}
                <div class="col-md-3">
                    <label for="tahun" class="form-label fw-semibold text-secondary">Pilih Tahun (Tunggal)</label>
                    <select name="tahun" id="tahun" class="form-select border-primary rounded shadow-sm px-3 py-2"
                        style="background-color: #f0f8ff; color: #003366;">
                        <option value="">-- Semua Tahun --</option>
                        @foreach ($listTahun as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kolom Periode Tahun --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Dari Tahun</label>
                    <input type="text" name="tahun_awal" class="form-control border-primary rounded shadow-sm"
                        placeholder="2022" value="{{ request('tahun_awal') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">Sampai Tahun</label>
                    <input type="text" name="tahun_akhir" class="form-control border-primary rounded shadow-sm"
                        placeholder="2024" value="{{ request('tahun_akhir') }}">
                </div>

                {{-- Kolom Mata Kuliah --}}
                <div class="col-md-3">
                    <label for="mata_kuliah" class="form-label fw-semibold text-secondary">Mata Kuliah</label>
                    <select name="mata_kuliah" class="form-control">
                        <option value="">-- Semua Mata Kuliah --</option>
                        @foreach ($listMatkul as $matkul)
                            <option value="{{ $matkul }}" {{ request('mata_kuliah') == $matkul ? 'selected' : '' }}>
                                {{ $matkul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary shadow-sm w-100" name="submit_filter">Tampilkan</button>
                    <a href="{{ route('rekapCpl.grafik') }}" class="btn btn-outline-secondary shadow-sm w-100">Reset</a>
                </div>
            </div>
        </form>

        @if ($data->count() > 0)
            @php
                $avgTarget = number_format($data->avg('rata_target'), 2);
                $avgCapai = number_format($data->avg('rata_ketercapaian'), 2);
            @endphp

            {{-- Ringkasan --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm bg-light animate__animated animate__fadeIn">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Rata-rata Target</h6>
                            <h3 class="text-primary fw-bold">{{ $avgTarget }}%</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm bg-light animate__animated animate__fadeIn">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Rata-rata Ketercapaian</h6>
                            <h3 class="text-success fw-bold">{{ $avgCapai }}%</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Detail --}}
            <div class="table-responsive mb-4">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            @if (request()->filled('tahun'))
                                <th>Mata Kuliah</th>
                                <th>Target (%)</th>
                                <th>Ketercapaian (%)</th>
                            @else
                                <th>Tahun Akademik</th>
                                <th>Rata-rata Target (%)</th>
                                <th>Rata-rata Ketercapaian (%)</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ request()->filled('tahun') ? $row['matkul'] : $row['tahun'] }}</td>
                                <td>{{ number_format($row['rata_target'], 2) }}</td>
                                <td>{{ number_format($row['rata_ketercapaian'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Grafik --}}
            <div class="card shadow-sm mb-5 animate__animated animate__fadeIn">
                <div class="card-header bg-white fw-semibold">Grafik Rekap CPL</div>
                <div class="card-body">
                    <canvas id="chartRekapCPL" height="120"></canvas>
                </div>
            </div>
        @else
            <div class="alert alert-warning shadow-sm">Tidak ada data untuk tahun yang dipilih.</div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="mt-4 d-flex gap-3" style="gap: 10px;">
            <a href="{{ route('rekapCPL.prodi') }}" class="btn btn-secondary">
                ← Kembali ke Rekap Tabel
            </a>
            <a href="{{ route('prodi.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i> Kembali ke Dashboard
            </a>
        </div>


    </div>

    {{-- Chart Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = @json($data);
        const ctx = document.getElementById('chartRekapCPL')?.getContext('2d');

        if (ctx && chartData.length > 0) {
            const labels = chartData.map(d => d.matkul ?? d.tahun ?? '-');
            const targetData = chartData.map(d => parseFloat(d.rata_target) || 0);
            const capaiData = chartData.map(d => parseFloat(d.rata_ketercapaian) || 0);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Target (%)',
                            data: targetData,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)'
                        },
                        {
                            label: 'Ketercapaian (%)',
                            data: capaiData,
                            backgroundColor: 'rgba(75, 192, 192, 0.8)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Grafik Rekap CPL {{ request('tahun') ? 'Tahun ' . request('tahun') : 'Semua Tahun' }}',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 15
                            }
                        },
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: context => `${context.dataset.label}: ${context.formattedValue}%`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 100,
                            title: {
                                display: true,
                                text: 'Persentase (%)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: '{{ request('tahun') ? 'Mata Kuliah' : 'Tahun Akademik' }}'
                            }
                        }
                    }
                }
            });
        }
    </script>


    {{-- Optional Animations --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

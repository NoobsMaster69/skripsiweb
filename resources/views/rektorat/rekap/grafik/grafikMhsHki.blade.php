@extends('layout.app')
@section('title', $title)

@section('content')
    <div class="container mt-4">
        <h4 class="mb-3 fw-bold text-primary">{{ $title }}</h4>

        {{-- Filter Form --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rekapRektorat.hki.grafik') }}">
                    <div class="row g-3 align-items-end">
                        {{-- Tahun --}}
                        <div class="col-md-2">
                            <label for="tahun" class="form-label fw-semibold text-secondary">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">-- Tahun --</option>
                                @foreach ($listTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Program Studi --}}
                        <div class="col-md-3">
                            <label for="prodi" class="form-label fw-semibold text-secondary">Program Studi</label>
                            <select name="prodi" id="prodi" class="form-control">
                                <option value="">-- Semua Prodi --</option>
                                @foreach ($listProdi as $prodi)
                                    <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                        {{ $prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Fakultas --}}
                        <div class="col-md-3">
                            <label for="fakultas" class="form-label fw-semibold text-secondary">Fakultas</label>
                            <select name="fakultas" id="fakultas" class="form-control">
                                <option value="">-- Semua Fakultas --</option>
                                @foreach ($listFakultas as $fakultas)
                                    <option value="{{ $fakultas }}"
                                        {{ request('fakultas') == $fakultas ? 'selected' : '' }}>
                                        {{ $fakultas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Periode --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-secondary">Periode (3 Tahun)</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" name="periode_awal" class="form-control" placeholder="Dari Tahun"
                                    value="{{ request('periode_awal') }}" min="2000" max="2100" />
                                <span class="mx-2 fw-semibold text-secondary">-</span>
                                <input type="number" name="periode_akhir" class="form-control" placeholder="Sampai Tahun"
                                    value="{{ request('periode_akhir') }}" min="2000" max="2100" />
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="col-md-auto mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary shadow-sm px-4">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('rekapRektorat.hki.grafik') }}" class="btn btn-outline-secondary shadow-sm px-4">
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
                <div class="fw-semibold text-muted mb-2">Total Mahasiswa Mendapatkan HKI</div>
                @php
                    $totalHki = collect($dataChart)->flatten()->sum();
                @endphp
                <div class="h2 fw-bold text-primary">{{ $totalHki }}</div>
            </div>
        </div>

        {{-- Tabel Rekap HKI per Fakultas --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Fakultas</th>
                        <th>Jumlah HKI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataChart as $fakultas => $jumlahPerTahun)
                        <tr>
                            <td>{{ $fakultas }}</td>
                            <td>{{ array_sum($jumlahPerTahun) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Keterangan Tahun/Periode --}}
        @if (request('periode_awal') && request('periode_akhir'))
            <p class="text-muted text-center mb-1">Periode Tahun: {{ request('periode_awal') }} -
                {{ request('periode_akhir') }}</p>
        @elseif(request('tahun'))
            <p class="text-muted text-center mb-1">Tahun: {{ request('tahun') }}</p>
        @endif

        {{-- Grafik --}}
        <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
            <div class="card-header bg-white fw-semibold">Grafik Mahasiswa Berdasarkan Jumlah HKI</div>
            <div class="card-body">
                <canvas id="chartHki" height="120"></canvas>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-4">
            <a href="{{ route('rekapRektorat.mhsHki') }}" class="btn btn-outline-secondary">
                ← Kembali ke Tabel Rekap
            </a>
            <a href="{{ route('rektorat.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels); // Tahun
        const rawData = @json($dataChart); // { 'FTI': [5,3,2], 'FEB': [1,2,1] }

        const colors = [
            '#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56',
            '#9966FF', '#00a87e', '#ff5e57', '#8e44ad'
        ];

        const datasets = Object.entries(rawData).map(([fakultas, data], index) => ({
            label: fakultas,
            data: data,
            backgroundColor: colors[index % colors.length]
        }));

        const ctx = document.getElementById('chartHki')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Mahasiswa'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tahun'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

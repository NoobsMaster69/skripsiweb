    @extends('layout.app')

    @section('content')
        {{-- Page Heading --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800">
                <i class="fas fa-tachometer-alt mr-2"></i> {{ $title }}
            </h1>
        </div>

        {{-- Tombol ke Rekap CPL --}}
        <div class="mb-4">
            <a href="{{ route('rekapCpl.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Rekap CPL Lengkap</span>
            </a>
        </div>

        {{-- Grafik Rekap CPL --}}
        @if (isset($dataCPL) && count($dataCPL) > 0)
            <div class="card shadow-sm mb-4 animate__animated animate__fadeIn">
                <div class="card-header bg-white fw-semibold">Grafik Rekap CPL</div>
                <div class="card-body">
                    <canvas id="chartCPLDashboard" height="80"></canvas>

                </div>
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('rekapRekognisi.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Rekognisi Lengkap</span>
            </a>
        </div>

        {{-- Grafik Rekognisi Dosen --}}
        @if (!empty($rekognisiGrouped))
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">
                    Grafik Rekognisi Dosen Berdasarkan Tahun & Bidang
                </div>
                <div class="card-body">
                    <canvas id="chartRekognisiDashboard" height="80"></canvas>
                </div>
            </div>
        @endif


        <div class="mb-4">
            <a href="{{ route('rekapBPM.prestasi.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Prestasi Mahasiswa Lengkap</span>
            </a>
        </div>
        {{-- Grafik Prestasi Mahasiswa --}}
        @if (!empty($dataChartPrestasi))
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">
                    Grafik Prestasi Mahasiswa per Tahun & Tingkat
                </div>
                <div class="card-body">
                    <canvas id="chartPrestasiDashboard" height="80"></canvas>
                </div>
            </div>
        @endif



        <div class="mb-4">
            <a href="{{ route('rekapBPM.serkom.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Serfikasi Kompetensi Mahasiswa Lengkap</span>
            </a>
        </div>

        {{-- Grafik Sertifikasi Mahasiswa --}}
        @if (isset($labels) && count($labels) > 0)
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">
                    Grafik Sertifikasi Mahasiswa Berdasarkan Tingkatan per Tahun
                </div>
                <div class="card-body">
                    <canvas id="chartSerkomDashboard" height="80"></canvas>
                </div>
            </div>
        @endif


        <div class="mb-4">
            <a href="{{ route('rekapBPM.hki.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Mahasiswa Mendapatkan HKI Lengkap</span>
            </a>
        </div>

        {{-- Grafik Mahasiswa HKI --}}
        @if (!empty($dataChartHki))
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">Grafik Mahasiswa Berdasarkan Jumlah HKI</div>
                <div class="card-body">
                    <canvas id="chartHkiDashboard" height="80"></canvas>
                </div>
            </div>
        @endif

        {{-- Tombol Detail Publikasi Mahasiswa --}}
        <div class="mb-4">
            <a href="{{ route('rekapBPM.publikasi.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Publikasi Mahasiswa Lengkap</span>
            </a>
        </div>

        {{-- Grafik Publikasi Mahasiswa --}}
        @if (!empty($grafikPublikasi))
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">
                    Grafik Publikasi Mahasiswa per Tahun & Jenis
                </div>
                <div class="card-body">
                    <canvas id="chartPublikasiDashboard" height="80"></canvas>
                </div>
            </div>
        @endif

        {{-- Tombol Detail Adopsi Mahasiswa --}}
        <div class="mb-4">
            <a href="{{ route('rekapBPM.adopsi.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Karya yang Diadopsi oleh masyarakat</span>
            </a>
        </div>

        {{-- Grafik Adopsi Mahasiswa --}}
        @if (!empty($grafikAdopsi))
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">Grafik Adopsi Karya Mahasiswa per Tahun & Jenis</div>
                <div class="card-body">
                    <canvas id="chartAdopsiDashboard" height="80"></canvas>
                </div>
            </div>
        @endif

        {{-- Tombol Detail Karya Mahasiswa Lainnya --}}
        <div class="mb-4">
            <a href="{{ route('rekapBPM.karyalainnya.grafik') }}"
                class="btn btn-lg text-white d-inline-flex align-items-center gap-2 shadow-sm"
                style="background: linear-gradient(135deg, #4e73df, #1cc88a); border-radius: 8px; padding: padding: 6px 12px;
    ;">
                <i class="fas fa-chart-bar fa-lg"></i>
                <span class="fw-semibold">Lihat Detail Karya Mahasiswa Lainnya</span>
            </a>
        </div>
        {{-- Grafik Karya Mahasiswa Lainnya --}}
        @if (!empty($grafikKaryaLain))
            <div class="card shadow-sm animate__animated animate__fadeIn mb-4">
                <div class="card-header bg-white fw-semibold">Grafik Karya Mahasiswa Lainnya per Tahun & Jenis</div>
                <div class="card-body">
                    <canvas id="chartKaryaLainDashboard" height="80"></canvas>
                </div>
            </div>
        @endif
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- Chart CPL --}}
        @if (isset($dataCPL) && count($dataCPL) > 0)
            <script>
                const dataCPL = @json($dataCPL);
                const ctxCPL = document.getElementById('chartCPLDashboard')?.getContext('2d');

                if (ctxCPL && dataCPL.length > 0) {
                    const labels = dataCPL.map(item => item.tahun);
                    const targetData = dataCPL.map(item => parseFloat(item.rata_target) || 0);
                    const capaiData = dataCPL.map(item => parseFloat(item.rata_ketercapaian) || 0);

                    new Chart(ctxCPL, {
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
                                    text: 'Grafik Rekap CPL Semua Tahun',
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
                                        text: 'Tahun Akademik'
                                    }
                                }
                            }
                        }
                    });
                }
            </script>
        @endif

        {{-- Chart Rekognisi Dosen --}}
        @if (!empty($rekognisiGrouped))
            <script>
                const chartRekognisi = @json($rekognisiGrouped);

                const tahunLabelsRek = Object.keys(chartRekognisi);
                const bidangSetRek = new Set();

                tahunLabelsRek.forEach(tahun => {
                    Object.keys(chartRekognisi[tahun]).forEach(bidang => bidangSetRek.add(bidang));
                });

                const bidangLabelsRek = Array.from(bidangSetRek);
                const colorsRek = ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc', '#fd7e14', '#20c997', '#6610f2'];

                const datasetsRek = bidangLabelsRek.map((bidang, i) => ({
                    label: bidang,
                    data: tahunLabelsRek.map(tahun => chartRekognisi[tahun]?.[bidang] ?? 0),
                    backgroundColor: colorsRek[i % colorsRek.length]
                }));

                const ctxRek = document.getElementById('chartRekognisiDashboard')?.getContext('2d');

                if (ctxRek) {
                    new Chart(ctxRek, {
                        type: 'bar',
                        data: {
                            labels: tahunLabelsRek,
                            datasets: datasetsRek
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Rekognisi Dosen per Tahun & Bidang',
                                    font: {
                                        size: 16
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => `${ctx.dataset.label}: ${ctx.formattedValue}`
                                    }
                                },
                                legend: {
                                    position: 'top'
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
                                    title: {
                                        display: true,
                                        text: 'Jumlah Rekognisi'
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
        @endif

        {{-- Chart Prestasi Mahasiswa --}}
        @if (!empty($dataChartPrestasi))
            <script>
                const dataChartPrestasi = @json($dataChartPrestasi);
                const tahunLabelsPrestasi = Object.keys(dataChartPrestasi);

                const wilayahData = tahunLabelsPrestasi.map(t => dataChartPrestasi[t]['Wilayah'] || 0);
                const nasionalData = tahunLabelsPrestasi.map(t => dataChartPrestasi[t]['Nasional'] || 0);
                const internasionalData = tahunLabelsPrestasi.map(t => dataChartPrestasi[t]['Internasional'] || 0);

                const ctxPrestasi = document.getElementById('chartPrestasiDashboard')?.getContext('2d');
                if (ctxPrestasi) {
                    new Chart(ctxPrestasi, {
                        type: 'bar',
                        data: {
                            labels: tahunLabelsPrestasi,
                            datasets: [{
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
                                    text: 'Grafik Prestasi Mahasiswa per Tahun',
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
        @endif



        {{-- Chart Sertifikasi Mahasiswa --}}
        @if (isset($labels) && count($labels) > 0)
            <script>
                const labelsSerkom = @json($labels);
                const datasetLokal = @json($datasetLokal);
                const datasetNasional = @json($datasetNasional);
                const datasetInternasional = @json($datasetInternasional);

                const ctxSerkom = document.getElementById('chartSerkomDashboard')?.getContext('2d');

                if (ctxSerkom) {
                    new Chart(ctxSerkom, {
                        type: 'bar',
                        data: {
                            labels: labelsSerkom,
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
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Sertifikasi Mahasiswa',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    }
                                },
                                legend: {
                                    position: 'top'
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false
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
                                        text: 'Jumlah Sertifikasi'
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
        @endif
        {{-- Chart mahasiswa hki --}}
        @if (!empty($dataChartHki))
            <script>
                const labelsHki = @json($labelsHki); // Tahun
                const rawHkiData = @json($dataChartHki); // { 'FTI': [5,3,2], 'FEB': [1,2,1] }

                const colorsHki = [
                    '#36A2EB', '#FF6384', '#4BC0C0', '#FFCE56',
                    '#9966FF', '#00a87e', '#ff5e57', '#8e44ad'
                ];

                const datasetsHki = Object.entries(rawHkiData).map(([fakultas, data], index) => ({
                    label: fakultas,
                    data: data,
                    backgroundColor: colorsHki[index % colorsHki.length]
                }));

                const ctxHki = document.getElementById('chartHkiDashboard')?.getContext('2d');

                if (ctxHki) {
                    new Chart(ctxHki, {
                        type: 'bar',
                        data: {
                            labels: labelsHki,
                            datasets: datasetsHki
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Mahasiswa HKI per Fakultas & Tahun',
                                    font: {
                                        size: 16
                                    }
                                },
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
                                        text: 'Jumlah Mahasiswa'
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
        @endif

        {{-- chart Publikasi mahasiswa --}}
        @if (!empty($grafikPublikasi))
            <script>
                const publikasiData = @json($grafikPublikasi);
                const tahunLabelsPublikasi = Object.keys(publikasiData);
                const jenisListPublikasi = ['jurnal_artikel', 'buku', 'media_massa'];

                const labelMapPublikasi = {
                    'jurnal_artikel': '📰 Jurnal / Artikel',
                    'buku': '📚 Buku',
                    'media_massa': '🗞️ Media Massa'
                };

                const colorsPublikasi = {
                    'jurnal_artikel': '#4e73df',
                    'buku': '#e74a3b',
                    'media_massa': '#1cc88a'
                };

                const datasetsPublikasi = jenisListPublikasi.map(jenis => ({
                    label: labelMapPublikasi[jenis],
                    data: tahunLabelsPublikasi.map(tahun => publikasiData[tahun]?.[jenis] || 0),
                    backgroundColor: colorsPublikasi[jenis]
                }));

                const ctxPublikasi = document.getElementById('chartPublikasiDashboard')?.getContext('2d');
                if (ctxPublikasi) {
                    new Chart(ctxPublikasi, {
                        type: 'bar',
                        data: {
                            labels: tahunLabelsPublikasi,
                            datasets: datasetsPublikasi
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Publikasi Mahasiswa',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    }
                                },
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.dataset.label}: ${context.raw}`;
                                        }
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
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }
            </script>
        @endif

        {{-- chart karya yang di adopsi masyarakat --}}

        @if (!empty($grafikAdopsi))
            <script>
                const adopsiData = @json($grafikAdopsi);
                const tahunLabelsAdopsi = Object.keys(adopsiData);
                const jenisAdopsi = ['Produk', 'Jasa'];

                const warnaAdopsi = {
                    'Produk': '#4e73df',
                    'Jasa': '#1cc88a'
                };

                const labelAdopsi = {
                    'Produk': '🛠️ Produk',
                    'Jasa': '🤝 Jasa'
                };

                const datasetsAdopsi = jenisAdopsi.map(jenis => ({
                    label: labelAdopsi[jenis],
                    data: tahunLabelsAdopsi.map(tahun => adopsiData[tahun]?.[jenis] ?? 0),
                    backgroundColor: warnaAdopsi[jenis]
                }));

                const ctxAdopsi = document.getElementById('chartAdopsiDashboard')?.getContext('2d');
                if (ctxAdopsi) {
                    new Chart(ctxAdopsi, {
                        type: 'bar',
                        data: {
                            labels: tahunLabelsAdopsi,
                            datasets: datasetsAdopsi
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Adopsi Mahasiswa per Tahun',
                                    font: {
                                        size: 16
                                    }
                                },
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => `${ctx.dataset.label}: ${ctx.raw}`
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Karya Diadopsi'
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
        @endif

        @if (!empty($grafikKaryaLain))
            <script>
                const dataKaryaLain = @json($grafikKaryaLain);
                const tahunLabelsKaryaLain = @json($labelsKaryaLain);
                const jenisListKaryaLain = ['Produk', 'Jasa', 'Karya Inovatif', 'Karya Sosial'];

                const labelMapKarya = {
                    'Produk': '🛠️ Produk',
                    'Jasa': '🤝 Jasa',
                    'Karya Inovatif': '🧠 Karya Inovatif',
                    'Karya Sosial': '🤝 Karya Sosial'
                };

                const warnaKarya = {
                    'Produk': '#4e73df',
                    'Jasa': '#1cc88a',
                    'Karya Inovatif': '#f6c23e',
                    'Karya Sosial': '#e74a3b'
                };

                const datasetsKarya = jenisListKaryaLain.map(jenis => ({
                    label: labelMapKarya[jenis],
                    data: tahunLabelsKaryaLain.map(tahun => dataKaryaLain[tahun]?.[jenis] || 0),
                    backgroundColor: warnaKarya[jenis]
                }));

                const ctxKaryaLain = document.getElementById('chartKaryaLainDashboard')?.getContext('2d');

                if (ctxKaryaLain) {
                    new Chart(ctxKaryaLain, {
                        type: 'bar',
                        data: {
                            labels: tahunLabelsKaryaLain,
                            datasets: datasetsKarya
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Karya Mahasiswa Lainnya',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    }
                                },
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => `${ctx.dataset.label}: ${ctx.raw}`
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Karya'
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
        @endif

        {{-- Optional Animations --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @endpush

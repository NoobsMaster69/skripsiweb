<!-- Detail Publikasi Modal Content -->
<div class="container-fluid py-4 p-lg-5">
    <!-- Header Card -->
    <div class="card border-0 mb-4 main-header">
        <div class="card-header border-0 py-3">
            <h5 class="mb-0 text-white">
                <i class="fas fa-book-open me-2"></i>
                Detail Publikasi Mahasiswa
            </h5>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Left Column - Informasi Mahasiswa -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header sub-header py-3">
                    <h6 class="mb-0 title-highlight">
                        <i class="fas fa-user-graduate me-2"></i>
                        Informasi Mahasiswa
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-label">NAMA LENGKAP</div>
                                <div class="info-content">{{ $publikasi->nm_mhs }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">NIM</div>
                                <div class="info-content">{{ $publikasi->nim }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">TAHUN</div>
                                <div class="info-content">{{ $publikasi->tahun }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-label">PROGRAM STUDI</div>
                                <div class="info-content">{{ $publikasi->prodi }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-label">FAKULTAS</div>
                                <div class="info-content">{{ $publikasi->fakultas }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Informasi Publikasi -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header sub-header py-3">
                    <h6 class="mb-0 title-highlight">
                        <i class="fas fa-newspaper me-2"></i>
                        Informasi Publikasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-label">JENIS KEGIATAN</div>
                                <div class="mt-2">
                                    <span class="badge bg-primary-badge">
                                        <i class="fas fa-clipboard-list me-1"></i>
                                        {{ $publikasi->kegiatan }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">TINGKAT</div>
                                <div class="mt-2">
                                    <span class="badge
                                        @if($publikasi->tingkat == 'internasional') bg-success-badge
                                        @elseif($publikasi->tingkat == 'nasional') bg-warning-badge
                                        @else bg-info-badge
                                        @endif">
                                        @if($publikasi->tingkat == 'internasional')
                                            <i class="fas fa-globe me-1"></i>Internasional
                                        @elseif($publikasi->tingkat == 'nasional')
                                            <i class="fas fa-flag me-1"></i>Nasional
                                        @else
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ ucfirst(str_replace('-', ' ', $publikasi->tingkat)) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">JENIS PRESTASI</div>
                                <div class="mt-2">
                                    <span class="badge
                                        @if($publikasi->prestasi == 'prestasi-akademik') bg-info-badge
                                        @else bg-dark-badge
                                        @endif">
                                        @if($publikasi->prestasi == 'prestasi-akademik')
                                            <i class="fas fa-graduation-cap me-1"></i>Akademik
                                        @else
                                            <i class="fas fa-trophy me-1"></i>Non-Akademik
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">TANGGAL PEROLEHAN</div>
                                <div class="info-content">
                                    @if($publikasi->tanggal_perolehan)
                                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                                        {{ $publikasi->tanggal_perolehan->format('d F Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">STATUS</div>
                                <div class="mt-2">
                                    <span class="badge bg-success-badge">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ ucfirst($publikasi->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Detail Karya Section -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header sub-header py-3">
                    <h6 class="mb-0 title-highlight">
                        <i class="fas fa-file-alt me-2"></i>
                        Detail Karya Publikasi
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Judul Karya -->
                    <div class="mb-4">
                        <div class="info-label mb-2">JUDUL KARYA</div>
                        <div class="detail-box">
                            <div class="info-content">
                                {{ $publikasi->judul_karya ?: 'Tidak ada judul yang tercatat' }}
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    @if($publikasi->deskripsi)
                    <div class="mb-4">
                        <div class="info-label mb-2">DESKRIPSI</div>
                        <div class="detail-box">
                            <div class="text-dark lh-base">
                                {{ $publikasi->deskripsi }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- File Lampiran -->
                    @if($publikasi->file_upload)
                    <div class="mb-4">
                        <div class="info-label mb-2">BERKAS LAMPIRAN</div>
                        <div class="file-box">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-paperclip text-primary fs-3 me-3"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">File Publikasi</div>
                                    <small class="text-muted">Klik untuk mengunduh berkas</small>
                                </div>
                            </div>
                            <a href="{{ $publikasi->file_url }}" target="_blank" class="btn btn-download text-white ms-3">
                                <i class="fas fa-download me-1"></i>
                                Download
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan -->
                    @if($publikasi->catatan)
                    <div class="mb-3">
                        <div class="info-label mb-2">CATATAN</div>
                        <div class="detail-box note-box p-3">
                            <div class="text-dark lh-base">
                                <i class="fas fa-sticky-note text-warning me-2"></i>
                                {{ $publikasi->catatan }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header sub-header py-3">
                    <h6 class="mb-0 title-highlight">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3">
                                <div class="system-icon create">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div>
                                    <div class="info-label">TANGGAL DIBUAT</div>
                                    <div class="info-content">
                                        {{ $publikasi->created_at ? $publikasi->created_at->format('d F Y, H:i') : 'Tidak tersedia' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3">
                                <div class="system-icon update">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div>
                                    <div class="info-label">TERAKHIR DIPERBARUI</div>
                                    <div class="info-content">
                                        {{ $publikasi->updated_at ? $publikasi->updated_at->format('d F Y, H:i') : 'Tidak tersedia' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fc;
        color: #444;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-fluid {
        max-width: 1200px;
    }

    .card {
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.03);
    }

    .card-body {
        padding: 1.5rem;
    }

    .main-header {
        background: linear-gradient(135deg, #1a6aa2, #0d4a75);
        border-radius: 12px !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .sub-header {
        background: linear-gradient(to right, #f8f9fc, #e9ecef);
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-content {
        font-size: 1.05rem;
        font-weight: 500;
        color: #333;
    }

    .badge {
        font-weight: 600;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
    }

    .badge i {
        margin-right: 0.5rem;
        font-size: 0.9em;
    }

    .bg-primary-badge {
        background: rgba(26, 106, 162, 0.15) !important;
        color: #1a6aa2 !important;
        border: 1px solid rgba(26, 106, 162, 0.2);
    }

    .bg-success-badge {
        background: rgba(40, 167, 69, 0.15) !important;
        color: #28a745 !important;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .bg-warning-badge {
        background: rgba(255, 193, 7, 0.15) !important;
        color: #d39e00 !important;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .bg-info-badge {
        background: rgba(23, 162, 184, 0.15) !important;
        color: #17a2b8 !important;
        border: 1px solid rgba(23, 162, 184, 0.2);
    }

    .bg-dark-badge {
        background: rgba(52, 58, 64, 0.15) !important;
        color: #343a40 !important;
        border: 1px solid rgba(52, 58, 64, 0.2);
    }

    .detail-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 1.25rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .file-box {
        background-color: rgba(26, 106, 162, 0.05);
        border: 1px dashed rgba(26, 106, 162, 0.3);
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .file-box:hover {
        background-color: rgba(26, 106, 162, 0.1);
        border-style: solid;
    }

    .note-box {
        background-color: rgba(255, 193, 7, 0.1);
        border-left: 4px solid #ffc107;
        border-radius: 0 8px 8px 0;
    }

    .system-box {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 1.25rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .system-icon {
        font-size: 1.5rem;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .system-icon.create {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .system-icon.update {
        background-color: rgba(255, 193, 7, 0.15);
        color: #d39e00;
    }

    .btn-download {
        background: linear-gradient(135deg, #1a6aa2, #0d4a75);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(26, 106, 162, 0.3);
    }

    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.1), transparent);
        margin: 2rem 0;
    }

    .title-highlight {
        color: #1a6aa2;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .card-header h5, .card-header h6 {
            font-size: 1.1rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .info-content {
            font-size: 1rem;
        }

        .badge {
            padding: 0.5rem 0.8rem;
            font-size: 0.85rem;
        }
    }
</style>

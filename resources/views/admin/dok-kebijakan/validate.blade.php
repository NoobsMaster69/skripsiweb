@extends('layout.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i> {{ $title }}
    </h1>


    <form action="{{ route('dok-kebijakan.validasi', $dokRek->id) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">

                <!-- Nomor & Nama Dokumen -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nomor Dokumen</label>
                        <input type="text" class="form-control" value="{{ $dokRek->nomor_dokumen }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama Dokumen</label>
                        <input type="text" class="form-control" value="{{ $dokRek->nama_dokumen }}" readonly>
                    </div>
                </div>

                <!-- Uploader & Tanggal -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Di-upload Oleh</label>
                        <input type="text" class="form-control" value="{{ $dokRek->di_upload }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Upload</label>
                        <input type="text" class="form-control" value="{{ $dokRek->tanggal_upload_formatted }}"
                            readonly>
                    </div>
                </div>

                <!-- Tanggal Pengesahan -->
                <div class="form-group">
                    <label>Tanggal Pengesahan</label>
                    <input type="text" class="form-control"
                        value="{{ $dokRek->tanggal_pengesahan_formatted ?? '-' }}" readonly>
                </div>

                <!-- Lampiran -->
                <div class="form-group">
                    <label for="lampiran">Lampiran</label>
                    @if ($dokRek->file_path)
                        <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                                <span class="text-dark">{{ basename($dokRek->file_path) }}</span>
                            </div>
                            <a href="{{ url($dokRek->file_path) }}" target="_blank"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-eye mr-1"></i> Lihat Lampiran
                            </a>
                        </div>
                    @else
                        <div class="text-muted">Tidak ada file terlampir</div>
                    @endif
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="Deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Masukkan deskripsi dokumen..." required></textarea>
                </div>

                <!-- Tombol Validasi -->
                <div class="d-flex justify-content-start gap-2 mt-3">
                    <button type="submit" class="btn btn-sm btn-success" name="type_verifikasi" value="terverifikasi">
                        <i class="fas fa-check mr-1"></i> Validasi Sekarang
                    </button>
                    <button type="submit" class="btn btn-sm btn-danger ml-2" name="type_verifikasi" value="ditolak">
                        <i class="fas fa-times mr-1"></i> Tolak
                    </button>
                </div>

            </div>
        </div>
    </form>

    <!-- SweetAlert Konfirmasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin ingin menyimpan hasil validasi?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });
    </script>
@endsection

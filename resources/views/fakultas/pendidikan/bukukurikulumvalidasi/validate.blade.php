@extends('layout/app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i>
        {{ $title }}
    </h1>

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">

                <!-- Info Dokumen -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nomor_dokumen">Nomor Dokumen</label>
                        <input type="text" class="form-control" id="nomor_dokumen" value="01" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama_dokumen">Nama Dokumen</label>
                        <input type="text" class="form-control" id="nama_dokumen" value="STATUTA UCIC" readonly>
                    </div>
                </div>

                <!-- Info Upload -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="diupload_oleh">Di Upload Oleh</label>
                        <input type="text" class="form-control" id="diupload_oleh" value="Rektorat" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_upload">Tanggal Upload</label>
                        <input type="text" class="form-control" id="tanggal_upload" value="17-05-2025" readonly>
                    </div>
                </div>

                <!-- Tanggal Pengesahan -->
                <div class="form-group">
                    <label for="tanggal_pengesahan">Tanggal Pengesahan</label>
                    <input type="text" class="form-control" id="tanggal_pengesahan" value="18-05-2025" readonly>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="perlu_direvisi" selected>Perlu direvisi</option>
                        <option value="belum_divalidasi">Sudah Di Validasi</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>

                <!-- Lampiran -->
                <div class="form-group">
                    <label for="lampiran">Lampiran</label>
                    <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                            <span class="text-dark">STATUTA_UCIC.pdf</span>
                        </div>
                        <a href="{{ asset('path/to/statuta_ucic.pdf') }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-eye mr-1"></i> Lihat Lampiran
                        </a>
                    </div>
                </div>


                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="Deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="Deskripsi" name="Deskripsi" rows="3"
                        placeholder="Masukkan deskripsi dokumen..." required></textarea>
                </div>

                <!-- Tombol Validasi -->
                <button type="button" class="btn btn-success" onclick="validasiDokumen()">
                    ✔ Validasi Sekarang
                </button>
            </div>
        </div>
    </form>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function validasiDokumen() {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Dokumen berhasil divalidasi!',
            confirmButtonText: 'OK',
            confirmButtonColor: '#6C5DD3',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('valid-buku-Kurikulum') }}";
            }
        });
    }
</script>

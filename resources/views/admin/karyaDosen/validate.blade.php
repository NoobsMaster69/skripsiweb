@extends('layout.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i> {{ $title }}
    </h1>

    <form action="{{ route('karyaDosenValid.validasi', $karyaDosen->id) }}" method="POST">
        @csrf
        <div class="card shadow">
            <div class="card-body">

                <!-- Informasi Utama -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Judul Karya</label>
                        <input type="text" class="form-control" value="{{ $karyaDosen->judul_karya }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama Dosen</label>
                        <input type="text" class="form-control" value="{{ $karyaDosen->nama_dosen }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Program Studi</label>
                        <input type="text" class="form-control" value="{{ $karyaDosen->prodi }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Fakultas</label>
                        <input type="text" class="form-control" value="{{ $karyaDosen->fakultas }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tahun</label>
                        <input type="text" class="form-control" value="{{ $karyaDosen->tahun_pembuatan }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Perolehan</label>
                        <input type="text" class="form-control"
                            value="{{ \Carbon\Carbon::parse($karyaDosen->tanggal_perolehan)->format('d-m-Y') }}" readonly>
                    </div>
                </div>

                <!-- Jenis Karya & Status -->
                <div class="form-group">
                    <label>Jenis Karya</label>
                    <input type="text" class="form-control" value="{{ $karyaDosen->jenis_karya }}" readonly>
                </div>

                <!-- Lampiran -->
                <div class="form-group">
                    <label for="lampiran">Lampiran</label>
                    @if ($karyaDosen->file_karya)
                        <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                                <span class="text-dark">{{ basename($karyaDosen->file_karya) }}</span>
                            </div>
                            <a href="{{ Storage::url($karyaDosen->file_karya) }}" target="_blank"
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
                <button type="submit" class="btn btn-success btn-sm" name="type_verifikasi" value="terverifikasi">
                    <i class="fas fa-check mr-1"></i> Validasi Sekarang
                </button>
                <button type="submit" class="btn btn-danger btn-sm ml-2" name="type_verifikasi" value="ditolak">
                    <i class="fas fa-times mr-1"></i> Tolak
                </button>
                <a href="{{ route('karyaDosenValid') }}" class="btn btn-sm btn-secondary ml-2">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>


            </div>
        </div>
    </form>

    <!-- SweetAlert -->
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
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });
    </script>
@endsection

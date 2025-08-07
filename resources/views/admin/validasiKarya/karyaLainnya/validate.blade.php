@extends('layout/app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i>
        {{ $title }}
    </h1>

    <form id="validasi-form" action="{{ route('valid-karyalainnya.validasi', $MahasiswaLainnya->id) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">

                <!-- Info Mahasiswa -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama_mahasiswa">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="nama_mahasiswa"
                            value="{{ $MahasiswaLainnya->nm_mhs }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" value="{{ $MahasiswaLainnya->nim }}"
                            readonly>
                    </div>
                </div>

                <!-- Info Akademik -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" id="prodi" value="{{ $MahasiswaLainnya->prodi }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fakultas">Fakultas</label>
                        <input type="text" class="form-control" id="fakultas" value="{{ $MahasiswaLainnya->fakultas }}"
                            readonly>
                    </div>
                </div>

                <!-- Info Kegiatan -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tahun">Tahun</label>
                        <input type="text" class="form-control" id="tahun" value="{{ $MahasiswaLainnya->tahun }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_perolehan">Tanggal Perolehan</label>
                        <input type="text" class="form-control" id="tanggal_perolehan"
                            value="{{ \Carbon\Carbon::parse($MahasiswaLainnya->tanggal_perolehan)->format('d-m-Y') }}"
                            readonly>
                    </div>
                </div>

                <!-- Judul & Jenis -->
                <div class="form-group">
                    <label for="judul_karya">Judul Karya</label>
                    <input type="text" class="form-control" id="judul_karya" value="{{ $MahasiswaLainnya->judul_karya }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="kegiatan">Kegiatan</label>
                    <input type="text" class="form-control" id="kegiatan" value="{{ $MahasiswaLainnya->kegiatan }}"
                        readonly>
                </div>

                <!-- Lampiran -->
                <div class="form-group">
                    <label for="lampiran">Lampiran</label>
                    @if ($MahasiswaLainnya->file_upload)
                        <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                                <span class="text-dark">{{ basename($MahasiswaLainnya->file_upload) }}</span>
                            </div>
                            <a href="{{ Storage::url($MahasiswaLainnya->file_upload) }}" target="_blank"
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
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Masukkan deskripsi dokumen..." required></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-start gap-2 mt-3">
                    <button type="submit" class="btn btn-sm btn-success " name="type_verifikasi" value="terverifikasi">
                        <i class="fas fa-check mr-1"></i> Validasi Sekarang
                    </button>
                    <button type="submit" class="btn btn-sm btn-danger ml-2" name="type_verifikasi" value="ditolak">
                        <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                    <a href="{{ route('valid-karyalainnya') }}" class="btn btn-sm btn-secondary ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
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
                    window.location.href = "{{ route('valid-karyalainnya') }}";
                }
            });
        }
    </script>
@endpush

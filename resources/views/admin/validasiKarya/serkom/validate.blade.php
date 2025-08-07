@extends('layout/app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i> {{ $title }}
    </h1>

    <form id="validasi-form" action="{{ route('valid-serkom.validasi', $sertifikasiKomp->id) }}" method="POST">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Mahasiswa</label>
                            <input type="text" class="form-control" value="{{ $sertifikasiKomp->nm_mhs }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Program Studi</label>
                            <input type="text" class="form-control" value="{{ $sertifikasiKomp->prodi ?? '-' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Tahun</label>
                            <input type="text" class="form-control" value="{{ $sertifikasiKomp->tahun }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Perolehan</label>
                            <input type="text" class="form-control"
                                value="{{ \Carbon\Carbon::parse($sertifikasiKomp->tanggal_perolehan)->format('d-m-Y') }}"
                                readonly>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">NIM</label>
                            <input type="text" class="form-control" value="{{ $sertifikasiKomp->nim }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Fakultas</label>
                            <input type="text" class="form-control" value="{{ $sertifikasiKomp->fakultas ?? '-' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Karya</label>
                            <input type="text" class="form-control" value="{{ $sertifikasiKomp->judul_karya }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Kegiatan</label>
                            <input type="text" class="form-control" value="{{ $sertifikasiKomp->kegiatan ?? 'Sertifikasi Kompetensi' }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Tingkatan (Full) -->
                <div class="form-group">
                    <label class="font-weight-bold">Tingkatan</label>
                    <input type="text" class="form-control" value="{{ ucfirst($sertifikasiKomp->tingkatan) }}" readonly>
                </div>

                <!-- Lampiran -->
                <div class="form-group">
                    <label class="font-weight-bold">Lampiran</label>
                    <div class="p-2 border rounded bg-light d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt fa-lg text-danger mr-2"></i>
                            <span class="small text-dark">
                                {{ basename($sertifikasiKomp->file_upload ?? 'Tidak ada file') }}
                            </span>
                        </div>
                        <a href="{{ $sertifikasiKomp->file_upload ? Storage::url($sertifikasiKomp->file_upload) : '#' }}"
                            target="_blank"
                            class="btn btn-sm btn-info {{ !$sertifikasiKomp->file_upload ? 'disabled' : '' }}">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="form-group mt-4">
                    <label class="font-weight-bold">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3"
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
                    <a href="{{ route('valid-serkom') }}" class="btn btn-sm btn-secondary ml-2">
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
                    window.location.href = "{{ route('valid-serkom') }}";
                }
            });
        }
    </script>
@endpush

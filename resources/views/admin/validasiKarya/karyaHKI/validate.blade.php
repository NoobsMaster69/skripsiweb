@extends('layout/app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i>
        {{ $title }}
    </h1>

    <form id="validasi-form" action="{{ route('valid-mhsHki.validasi', $mahasiswaHki->id) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama_mahasiswa">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="nama_mahasiswa" value="{{ $mahasiswaHki->nm_mhs }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" value="{{ $mahasiswaHki->nim }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" id="prodi" value="{{ $mahasiswaHki->prodi }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fakultas">Fakultas</label>
                        <input type="text" class="form-control" id="fakultas" value="{{ $mahasiswaHki->fakultas }}"
                            readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tahun">Tahun</label>
                        <input type="text" class="form-control" id="tahun" value="{{ $mahasiswaHki->tahun }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_perolehan">Tanggal Perolehan</label>
                        <input type="text" class="form-control" id="tanggal_perolehan"
                            value="{{ \Carbon\Carbon::parse($mahasiswaHki->tanggal_perolehan)->translatedFormat('d F Y') }}"
                            readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="judul_karya">Judul Karya</label>
                    <input type="text" class="form-control" id="judul_karya" value="{{ $mahasiswaHki->judul_karya }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="kegiatan">Kegiatan</label>
                    <input type="text" class="form-control" id="kegiatan" value="HKI" readonly>
                </div>

                <div class="form-group">
                    <label for="lampiran">Lampiran</label>
                    <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                        @if ($mahasiswaHki->file_upload)
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x text-danger mr-3"></i>
                                <span class="text-dark">{{ $mahasiswaHki->file_name }}</span>
                            </div>
                            <a href="{{ Storage::url($mahasiswaHki->file_upload) }}" target="_blank"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-eye mr-1"></i> Lihat Lampiran
                            </a>
                        @else
                            <div class="text-muted">Tidak ada file yang diunggah.</div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Masukkan deskripsi dokumen..." required>{{ old('deskripsi') }}</textarea>
                </div>


                <div class="d-flex justify-content-start gap-2 mt-3">
                    <button type="submit" class="btn btn-sm btn-success " name="type_verifikasi" value="terverifikasi">
                        <i class="fas fa-check mr-1"></i> Validasi Sekarang
                    </button>
                    <button type="submit" class="btn btn-sm btn-danger ml-2" name="type_verifikasi" value="ditolak">
                        <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                    <a href="{{ route('valid-mhsHki') }}" class="btn btn-sm btn-secondary ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </form>
@endsection

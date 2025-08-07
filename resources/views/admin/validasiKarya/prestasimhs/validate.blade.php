@extends('layout/app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-file-alt mr-2"></i>
        {{ $title }}
    </h1>

    <form id="validasi-form" action="{{ route('valid-prestasimhs.validasi', $prestasiMahasiswa->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="card">
            <div class="card-body">

                <!-- Info Dokumen -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama_mahasiswa">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="nama_mahasiswa"
                            value= "{{ $prestasiMahasiswa->nm_mhs }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" value="{{ $prestasiMahasiswa->nim }}"
                            readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" value="{{ $prestasiMahasiswa->prodi }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fakultas">Fakultas</label>
                        <input type="text" class="form-control" value="{{ $prestasiMahasiswa->fakultas }}" readonly>
                    </div>
                </div>

                <!-- Info Upload -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tahun">Tahun</label>
                        <input type="text" class="form-control" id="tahun" value="{{ $prestasiMahasiswa->tahun }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="judul_karya">Judul Karya</label>
                        <input type="text" class="form-control" id="judul_karya"
                            value="{{ $prestasiMahasiswa->judul_karya }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tingkat">Tingkat</label>
                        <input type="text" class="form-control" id="tingkat" value="{{ $prestasiMahasiswa->tingkat }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prestasi">Prestasi</label>
                        <input type="text" class="form-control" id="prestasi" value="{{ $prestasiMahasiswa->prestasi }}"
                            readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="tanggal_perolehan">Tanggal Perolehan</label>
                        <input type="text" class="form-control" style="width: 100%;"
                            value="{{ \Carbon\Carbon::parse($prestasiMahasiswa->tanggal_perolehan)->format('d-m-Y') }}"
                            readonly>
                    </div>
                </div>




                <!-- Status -->
                {{-- <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Sudah Di Validasi"
                            {{ $prestasiMahasiswa->status == 'Sudah Di Validasi' ? 'selected' : '' }}>Sudah Di Validasi
                        </option>
                        <option value="Ditolak" {{ $prestasiMahasiswa->status == 'Ditolak' ? 'selected' : '' }}>Ditolak
                        </option>
                    </select>
                </div> --}}

                <!-- Lampiran -->
                <div class="form-group">
                    <label for="lampiran">Lampiran</label>
                    @if ($prestasiMahasiswa->file_upload)
                        <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>
                                <span class="text-dark">{{ basename($prestasiMahasiswa->file_upload) }}</span>
                            </div>
                            <a href="{{ Storage::url($prestasiMahasiswa->file_upload) }}" target="_blank"
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
                    <button type="submit" class="btn btn-sm btn-success " name="type_verifikasi" value="terverifikasi">
                        <i class="fas fa-check mr-1"></i> Validasi Sekarang
                    </button>
                    <button type="submit" class="btn btn-sm btn-danger ml-2" name="type_verifikasi" value="ditolak">
                        <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                    <a href="{{ route('valid-prestasimhs') }}" class="btn btn-sm btn-secondary ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function kirimValidasi(statusValue) {
        // Set status dari tombol
        document.getElementById('status').value = statusValue;

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Status akan disimpan sebagai '" + statusValue + "'",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('validasi-form').submit();
            }
        });
    }
</script>

@extends('layout/app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user mr-2"></i>
        {{ $title }}
    </h1>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="TA" class="form-label">Periode Akademik</label>
                    <select name="TA" class="form-control" required>
                        <option disabled selected>-- Pilih Tahun Akademik --</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="ProgramStudi" class="form-label"> Program Studi Akademik</label>
                    <select name="ProgramStudi" class="form-control" required>
                        <option disabled selected>-- Pilih Program Studi --</option>
                        <option value="TeknikInformatika">Teknik Informatika</option>
                        <option value="SistemInformasi">Sistem Informasi</option>
                        <option value="DKV">DKV</option>
                        <option value="Manajemen Informatika">Manajemen Informatika</option>
                    </select>
                </div>
            </div>

            {{-- <div class="mb-3">
                <label for="Matakuliah" class="form-label">Pilih Mata Kuliah</label>
                <select name="Matakuliah" class="form-control" required>
                    <option disabled selected>-- Pilih Mata Kuliah --</option>
                    <option value="Rektorat">Rektorat</option>
                    <option value="Fakultas">Fakultas</option>
                    <option value="Prodi">Prodi</option>
                </select>
            </div> --}}

            <!-- Tombol kiri kecil dan sejajar -->
            <div class="d-flex justify-content-start mt-3">
                <a href="{{ route('RataMT-fti') }}" class="btn btn-danger btn-sm me-2 mr-2">Batal</a>
                <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-center
        justify-content-xl-between">
            <div class="mb-1 mr-2">
                <a href="{{ route ('RataMT-ftiCreate') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Data</a>
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-sync mr-2"></i>
                    Sync</a>
            </div>
            <div>

                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel mr-2"></i>
                    Excel</a>

                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf mr-2"></i>
                    PDF</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode Dok</th>
                            <th>Tahun Lulus</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Pekerjaan</th>
                            <th>Nama Perusahaan</th>
                            <th>Rata-rata Masa Tunggu</th>
                            <th>
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">20210120029</td>
                            <td class="text-center">xxxxxx (TS-2)</td>
                            <td class="text-center">20210120029</td>
                            <td class="text-center">Anisya Hamidah</td>
                            <td class="text-center">Software Engineering</td>
                            <td class="text-center">Toko Pedia</td>
                            <td class="text-center">xx</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit "></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash "></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-warning w-100 text-white fw-bold py-2" style="max-width: 100%;">
                        <i class="fas fa-print me-2"></i> Cetak
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

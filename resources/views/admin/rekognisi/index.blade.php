@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-check mr-2"></i> {{ $title }}
        </h1>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('rekognisiDosenValid') }}" method="GET" class="form-inline">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari Nama Dosen / Prodi / Bidang / Deskripsi..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>



    @if (session('message'))
        <div class="alert alert-{{ session('message_type', 'success') }} alert-dismissible fade show" role="alert">
            <i class="fas fa-{{ session('message_type') == 'success' ? 'check-circle' : 'exclamation-circle' }} mr-2"></i>
            {!! session('message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i> Daftar Rekognisi Dosen
            </h6>
        </div>
        <div class="card-body">
            @if ($RekognisiDosens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Dosen</th>
                                <th class="text-center">Prodi</th>
                                <th class="text-center">Bidang Rekognisi</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Tanggal Rekognisi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Lampiran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($RekognisiDosens as $index => $rekognisi)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $rekognisi->nama_dosen }}</td>
                                    <td>{{ $rekognisi->prodi }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge
        {{ $rekognisi->bidang_rekognisi == 'Pendidikan'
            ? 'badge-info'
            : ($rekognisi->bidang_rekognisi == 'Pengabdian' || $rekognisi->bidang_rekognisi == 'Pengabdian Masyarakat'
                ? 'badge-success'
                : ($rekognisi->bidang_rekognisi == 'Penelitian'
                    ? 'badge-primary'
                    : ($rekognisi->bidang_rekognisi == 'Profesional'
                        ? 'badge-secondary'
                        : 'badge-dark'))) }}">
                                            {{ $rekognisi->bidang_rekognisi }}
                                        </span>
                                    </td>

                                    <td class="text-center">{{ $rekognisi->tahun_akademik }}</td>
                                    <td class="text-center">
                                        {{ $rekognisi->tanggal_rekognisi ? \Carbon\Carbon::parse($rekognisi->tanggal_rekognisi)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td class="text-center text-white">
                                        {!! status_prestasi($rekognisi->status) !!}
                                    </td>
                                    <td>{{ $rekognisi->deskripsi ?? '--' }}</td>
                                    <td class="text-center">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info btn-sm"
                                                onclick="window.open('{{ Storage::url($rekognisi->file_bukti) }}', '_blank')">
                                                <i class="fas fa-eye mr-1"></i>Lihat
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('validasi-rekognisiDosenValid', $rekognisi->id) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-check-circle"></i> Validasi
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada Data Rekognisi</h5>
                </div>
            @endif
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

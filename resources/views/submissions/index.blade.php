@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Daftar Ajuan Dokumen</h1>
  <a href="{{ route('submissions.create') }}" class="btn btn-primary mb-3">Ajukan Dokumen</a>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table">
    <thead>
      <tr>
        <th>#</th><th>Nomor</th><th>Nama</th><th>Uploaded</th>
        <th>Status</th><th>Pengesahan</th><th>Deskripsi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($subs as $s)
        <tr>
          <td>{{ $loop->iteration + ($subs->currentPage()-1)*$subs->perPage() }}</td>
          <td>{{ $s->masterDocument->nomor }}</td>
          <td>{{ $s->masterDocument->nama }}</td>
          <td>{{ $s->tanggal_upload }}</td>
          <td>{{ ucfirst($s->status) }}</td>
          <td>{{ $s->tanggal_pengesahan ?? '-' }}</td>
          <td>{{ $s->deskripsi ?? '-' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $subs->links() }}
</div>
@endsection

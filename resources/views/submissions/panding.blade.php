@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Ajuan Menunggu Validasi</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table">
    <thead>
      <tr>
        <th>#</th><th>Nomor</th><th>Nama</th><th>Pengaju</th>
        <th>Uploaded</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($subs as $s)
        <tr>
          <td>{{ $loop->iteration + ($subs->currentPage()-1)*$subs->perPage() }}</td>
          <td>{{ $s->masterDocument->nomor }}</td>
          <td>{{ $s->masterDocument->nama }}</td>
          <td>{{ $s->user->name }}</td>
          <td>{{ $s->tanggal_upload }}</td>
          <td>
            <a href="{{ route('admin.submissions.edit', $s) }}"
               class="btn btn-sm btn-primary">Validasi</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $subs->links() }}
</div>
@endsection


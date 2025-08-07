@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Ajukan Dokumen</h1>

  <form action="{{ route('submissions.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label>Pilih Dokumen</label>
      <select id="master_document_id" name="master_document_id" class="form-control">
        <option value="">-- pilih --</option>
        @foreach($docs as $doc)
          <option value="{{ $doc->id }}"
                  data-nomor="{{ $doc->nomor }}"
                  data-nama="{{ $doc->nama }}">
            {{ $doc->nomor }} — {{ $doc->nama }}
          </option>
        @endforeach
      </select>
      @error('master_document_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
      <label>Nomor Dokumen</label>
      <input id="nomor" type="text" class="form-control" disabled>
    </div>
    <div class="mb-3">
      <label>Nama Dokumen</label>
      <input id="nama" type="text" class="form-control" disabled>
    </div>

    <button class="btn btn-primary">Kirim Ajuan</button>
  </form>
</div>

<script>
  document.getElementById('master_document_id')
    .addEventListener('change', function() {
      let opt = this.options[this.selectedIndex];
      document.getElementById('nomor').value = opt.dataset.nomor || '';
      document.getElementById('nama').value = opt.dataset.nama || '';
    });
</script>
@endsection

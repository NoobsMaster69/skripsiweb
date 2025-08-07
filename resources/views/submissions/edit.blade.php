@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Validasi Ajuan Dokumen</h1>

  <form action="{{ route('admin.submissions.update', $submission) }}" method="POST">
    @csrf @method('PATCH')

    <div class="mb-3">
      <label>Nomor Dokumen</label>
      <input type="text" class="form-control"
             value="{{ $submission->masterDocument->nomor }}" disabled>
    </div>
    <div class="mb-3">
      <label>Nama Dokumen</label>
      <input type="text" class="form-control"
             value="{{ $submission->masterDocument->nama }}" disabled>
    </div>
    <div class="mb-3">
      <label>Nama Pengaju</label>
      <input type="text" class="form-control"
             value="{{ $submission->user->name }}" disabled>
    </div>
    <div class="mb-3">
      <label>Tanggal Upload</label>
      <input type="text" class="form-control"
             value="{{ $submission->tanggal_upload }}" disabled>
    </div>

    <div class="mb-3">
      <label>Status</label>
      <select name="status" class="form-control">
        @foreach(['pending','approved','rejected'] as $st)
          <option value="{{ $st }}"
            {{ $submission->status === $st ? 'selected' : '' }}>
            {{ ucfirst($st) }}
          </option>
        @endforeach
      </select>
      @error('status')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
      <label>Deskripsi (opsional)</label>
      <textarea name="deskripsi" class="form-control"
                rows="3">{{ old('deskripsi', $submission->deskripsi) }}</textarea>
      @error('deskripsi')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button class="btn btn-success">Simpan Validasi</button>
  </form>
</div>
@endsection

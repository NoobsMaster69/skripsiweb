@extends('layout.app')

@section('content')
    <div class="mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-eye mr-2 text-info"></i> {{ $title }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <iframe src="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true"
                    style="width:100%; height:600px;" frameborder="0">
            </iframe>
        </div>
    </div>
@endsection

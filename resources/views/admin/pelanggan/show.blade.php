@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h2>Detail Pelanggan: {{ $pelanggan->first_name }} {{ $pelanggan->last_name }}</h2>
    <p>Email: {{ $pelanggan->email }}</p>
    <p>Phone: {{ $pelanggan->phone }}</p>
    <p>Gender: {{ $pelanggan->gender }}</p>
    <p>Birthday: {{ $pelanggan->birthday }}</p>

    <hr>
    <h4>File Pendukung</h4>

    <!-- Upload Form -->
    <form action="{{ route('pelanggan.uploadFile', $pelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="files[]" multiple required>
        <button type="submit" class="btn btn-primary mt-2">Upload</button>
    </form>

    <!-- List of Files -->
    @if($pelanggan->files->count() > 0)
        <ul class="list-group mt-3">
            @foreach($pelanggan->files as $file)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(in_array(pathinfo($file->filename, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif']))
                        <img src="{{ asset('storage/'.$file->filename) }}" width="50" class="me-2">
                    @endif
                    {{ $file->filename }}
                    <form action="{{ route('pelanggan.deleteFile', $file->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="mt-3">Belum ada file diupload.</p>
    @endif
</div>
@endsection

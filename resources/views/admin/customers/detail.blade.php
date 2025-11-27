@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h2>Detail Customer</h2>

    <!-- Info Pelanggan -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $customer->nama }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Telepon:</strong> {{ $customer->telepon }}</p>
        </div>
    </div>

    <!-- Form Upload File Pendukung -->
    <div class="card mb-4">
        <div class="card-header">File Pendukung</div>
        <div class="card-body">
            <form action="{{ route('customers.uploadFile', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="files" class="form-label">Pilih File</label>
                    <input type="file" name="files[]" id="files" multiple class="form-control">
                </div>

                <!-- Hidden untuk ref_table & ref_id -->
                <input type="hidden" name="ref_table" value="pelanggan">
                <input type="hidden" name="ref_id" value="{{ $customer->id }}">

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <!-- List File Terupload -->
    <div class="card">
        <div class="card-header">File Terupload</div>
        <div class="card-body">
            @if($customer->files->count() > 0)
                <ul class="list-group">
                    @foreach($customer->files as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @if(in_array(pathinfo($file->filename, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif']))
                                <img src="{{ asset('storage/' . $file->filename) }}" width="50" class="me-2">
                            @endif
                            {{ $file->filename }}
                            <form action="{{ route('customers.deleteFile', $file->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada file terupload.</p>
            @endif
        </div>
    </div>
</div>
@endsection

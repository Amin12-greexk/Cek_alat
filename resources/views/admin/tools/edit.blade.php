@extends('adminlte::page')

@section('title', 'Edit Alat')

@section('content_header')
    <h1>Edit Alat</h1>
@endsection

@section('content')
    <form action="{{ route('admin.tools.update', $tool) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Alat</label>
            <input type="text" name="name" class="form-control" value="{{ $tool->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $tool->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Gambar</label>
            <input type="file" name="image" class="form-control">
            @if($tool->image)
                <p class="mt-2">Gambar Saat Ini:</p>
                <img src="{{ asset('storage/' . $tool->image) }}" alt="Gambar Alat" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Alat</button>
    </form>
@endsection

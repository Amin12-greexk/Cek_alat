@extends('adminlte::page')

@section('title', 'Edit Bagian')

@section('content_header')
    <h1>Edit Bagian untuk {{ $tool->name }}</h1>
@endsection

@section('content')
<form action="{{ route('admin.tools.parts.update', [$tool, $part]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="part_name">Nama Bagian</label>
        <input type="text" name="part_name" class="form-control" value="{{ $part->part_name }}" required>
    </div>

    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" class="form-control" required>{{ $part->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="validation">Aturan Validasi</label>
        <input type="text" name="validation" class="form-control" value="{{ $part->validation }}" placeholder="contoh: required|boolean">
    </div>

    <div class="form-group">
        <label for="image">Gambar</label>
        <input type="file" name="image" class="form-control">
        @if($part->image)
            <p class="mt-2">Gambar Saat Ini:</p>
            <img src="{{ asset('storage/' . $part->image) }}" alt="{{ $part->part_name }}" width="100">
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Perbarui Bagian</button>
</form>
@endsection

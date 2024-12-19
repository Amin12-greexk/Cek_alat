@extends('adminlte::page')

@section('title', 'Tambah Alat Baru')

@section('content_header')
    <h1>Tambah Alat Baru</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Alat</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tools.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama alat" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" placeholder="Masukkan deskripsi alat" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Gambar</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tambahkan Alat</button>
        </form>
    </div>
</div>
@endsection

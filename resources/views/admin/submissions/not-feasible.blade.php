@extends('adminlte::page')

@section('title', 'Validasi Gagal')

@section('content_header')
    <h1>Validasi Gagal</h1>
@endsection

@section('content')
    <div class="alert alert-danger">
        <h3>Hasil Validasi Alat</h3>
        <p>
            Alat <strong>{{ $tool->name }}</strong> gagal dalam proses validasi.
        </p>
        <p>
            Silakan tinjau kembali alat tersebut dan coba lagi.
        </p>
        <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">Kembali ke Daftar Alat</a>
    </div>
@endsection

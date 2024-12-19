@extends('adminlte::page')

@section('title', 'Kelola Alat')

@section('content_header')
    <h1>Kelola Alat</h1>
@endsection

@section('content')
    <a href="{{ route('admin.tools.create') }}" class="btn btn-primary mb-3">Tambah Alat Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tools as $tool)
            <tr>
                <td>{{ $tool->name }}</td>
                <td>{{ $tool->description }}</td>
                <td>
    @if($tool->image)
        <img src="{{ asset('storage/' . $tool->image) }}" alt="{{ $tool->name }}" width="50">
    @else
        Tidak Ada Gambar
    @endif
</td>

                <td>
    <a href="{{ route('admin.tools.parts.index', $tool) }}" class="btn btn-info">Kelola Bagian</a>
    <a href="{{ route('admin.tools.edit', $tool) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('admin.tools.destroy', $tool) }}" method="POST" style="display:inline;">
        @csrf @method('DELETE')
        <button class="btn btn-danger" onclick="return confirm('Hapus alat ini?')">Hapus</button>
    </form>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

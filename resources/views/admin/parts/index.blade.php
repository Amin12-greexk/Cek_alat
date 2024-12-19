@extends('adminlte::page')

@section('title', 'Kelola Bagian untuk ' . $tool->name)

@section('content_header')
    <h1>Kelola Bagian untuk {{ $tool->name }}</h1>
@endsection

@section('content')
    <!-- Form untuk Menambahkan Bagian Baru -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Tambah Bagian Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tools.parts.store', $tool) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="part_name">Nama Bagian</label>
                    <input type="text" name="part_name" class="form-control" placeholder="Masukkan nama bagian" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" placeholder="Masukkan deskripsi bagian" required></textarea>
                </div>
                <div class="form-group">
                    <label for="validation">Tipe Validasi</label>
                    <select name="validation" class="form-control" required>
                        <option value="">-- Pilih Tipe Validasi --</option>
                        <option value="required|boolean">Ya/Tidak</option>
                        <option value="required|integer|min:1|max:5">Rating 1-5</option>
                        <option value="required|string">Input Teks</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Gambar Bagian</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Tambah Bagian</button>
            </form>
        </div>
    </div>

    <!-- Daftar Bagian yang Ada -->
    <div class="card">
        <div class="card-header">
            <h3>Daftar Bagian</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Bagian</th>
                        <th>Deskripsi</th>
                        <th>Validasi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parts as $part)
                        <tr>
                            <td>{{ $part->part_name }}</td>
                            <td>{{ $part->description }}</td>
                            <td>
                                @if($part->validation === 'required|boolean')
                                    Ya/Tidak
                                @elseif($part->validation === 'required|integer|min:1|max:5')
                                    Rating 1-5
                                @elseif($part->validation === 'required|string')
                                    Input Teks
                                @else
                                    {{ $part->validation ?? 'Tidak Ada Validasi' }}
                                @endif
                            </td>
                            <td>
                                @if($part->image)
                                    <img src="{{ asset('storage/' . $part->image) }}" alt="{{ $part->part_name }}" width="50">
                                @else
                                    Tidak Ada Gambar
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.tools.parts.edit', [$tool, $part]) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('admin.tools.parts.destroy', $part) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Hapus bagian ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

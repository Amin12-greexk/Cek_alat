@extends('adminlte::page')

@section('title', 'Kelola Pengajuan')

@section('content_header')
    <h1>Kelola Form Inspeksi</h1>
@endsection

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Alat</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Kedaluwarsa</th>
                <th>Layak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $submission)
            <tr>
                <td>{{ $submission->tool->name }}</td>
                <td>{{ $submission->submission_date }}</td>
                <td>{{ $submission->expiration_date }}</td>
                <td>{{ $submission->is_feasible ? 'Ya' : 'Tidak' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

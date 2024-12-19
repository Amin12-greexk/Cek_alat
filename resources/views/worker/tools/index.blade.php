@extends('layouts.worker')

@section('title', 'Pilih Alat')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-5">Pilih Alat untuk di Inspeksi</h1>
    <p class="text-muted">Klik pada alat untuk memulai proses inspeksi.</p>
</div>

<div class="row">
    @foreach ($tools as $tool)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm animate__animated animate__fadeIn">
                <a href="{{ route('worker.tools.inspect', $tool->id) }}" class="stretched-link">
                    <img src="{{ asset('storage/' . $tool->image) }}" class="card-img-top" alt="{{ $tool->name }}">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $tool->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($tool->description, 50) }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

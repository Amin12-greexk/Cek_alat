@extends('layouts.worker')

@section('title', 'Hasil Inspeksi')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-body text-center">
            <!-- Pesan Status -->
            <h1 class="display-5 fw-bold mb-4 text-{{ session('status') === 'The tool is worthy.' ? 'success' : 'danger' }}">
                {{ session('status') }}
            </h1>
            <p class="text-muted mb-4">Terima kasih telah menyelesaikan proses inspeksi.</p>
        </div>
    </div>

    <!-- Detail Inspeksi -->
    <div class="card shadow-lg my-4">
        <div class="card-body">
            <h3 class="card-title text-center">Detail Inspeksi</h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Alat:</p>
                    <h5>{{ session('tool_name', 'Nama Alat Tidak Tersedia') }}</h5>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Tanggal Kedaluwarsa:</p>
                    <h5>{{ session('expiration_date') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi -->
    <div class="text-center mt-4">
        @if (session('submission_id'))
            <a href="{{ route('worker.submission.export', ['submission' => session('submission_id')]) }}" class="btn btn-success btn-lg me-3">
                <i class="fas fa-download"></i> Unduh Inspeksi Layak
            </a>
        @endif
        <a href="{{ route('worker.tools.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-arrow-left"></i> Kembali ke Alat
        </a>
    </div>
</div>
@endsection

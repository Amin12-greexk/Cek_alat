@extends('adminlte::page')

@section('title', 'Dasbor Admin')

@section('content_header')
    <h1>Dasbor</h1>
@endsection

@section('content')
    <div class="row">
        <!-- Total Alat -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalTools }}</h3>
                    <p>Total Alat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tools"></i>
                </div>
                <a href="{{ route('admin.tools.index') }}" class="small-box-footer">Kelola Alat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Bagian -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalParts }}</h3>
                    <p>Total Bagian</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <a href="{{ route('admin.tools.index') }}" class="small-box-footer">Kelola Bagian <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Inspeksi -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalSubmissions }}</h3>
                    <p>Total Inspeksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <a href="{{ route('admin.submissions.index') }}" class="small-box-footer">Lihat Inspeksi <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Tombol Logout -->
    <div class="row mt-4">
        <div class="col-lg-12 text-center">
            <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
@endsection

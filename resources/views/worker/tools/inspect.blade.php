@extends('layouts.worker')

@section('title', 'Inspeksi Alat')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-5">Inspeksi Alat: {{ $tool->name }}</h1>
</div>

<div class="card shadow-lg animate__animated animate__fadeIn">
    <div class="card-body">
        <form action="{{ route('worker.tools.submit', $tool->id) }}" method="POST">
            @csrf

            <!-- Nama Perusahaan -->
            <div class="mb-4">
                <label for="company_name" class="form-label">Nama Perusahaan</label>
                <input 
                    type="text" 
                    name="company_name" 
                    class="form-control" 
                    placeholder="Masukkan nama perusahaan"
                    required
                >
            </div>

            <!-- Tanggal Inspeksi -->
            <div class="mb-4">
                <label for="inspection_date" class="form-label">Tanggal Inspeksi</label>
                <input 
                    type="date" 
                    name="inspection_date" 
                    class="form-control" 
                    required
                >
            </div>

            <!-- Pertanyaan Validasi Bagian Alat -->
            @foreach ($parts as $part)
                <div class="mb-5 border rounded p-3 shadow-sm hover-shadow-lg transition duration-300 animate__animated animate__fadeInUp" style="width: 100%;">
                    <div class="d-flex align-items-center">
                        <!-- Gambar Bagian -->
                        @if ($part->image)
                            <img src="{{ asset('storage/' . $part->image) }}" 
                                alt="{{ $part->part_name }}" 
                                class="me-3 rounded"
                                style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                                onclick="openImageModal('{{ asset('storage/' . $part->image) }}')"
                            >
                        @else
                            <img src="https://via.placeholder.com/150" 
                                alt="Tidak Ada Gambar" 
                                class="me-3 rounded"
                                style="width: 150px; height: 150px; object-fit: cover;"
                            >
                        @endif

                        <!-- Detail Bagian -->
                        <div class="w-100">
                            <label class="form-label fw-bold">{{ $part->part_name }}</label>
                            <p class="text-muted">{{ $part->description }}</p>

                            <!-- Input Berdasarkan Validasi -->
                            @if ($part->validation === 'required|boolean')
                                <select name="responses[{{ $part->id }}]" class="form-select" required>
                                    <option value="yes">Ya</option>
                                    <option value="no">Tidak</option>
                                </select>
                            @elseif ($part->validation === 'required|integer|min:1|max:5')
                                <input type="number" name="responses[{{ $part->id }}]" 
                                    class="form-control" min="1" max="5" required>
                            @elseif ($part->validation === 'required|string')
                                <input type="text" name="responses[{{ $part->id }}]" 
                                    class="form-control" required>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Tag -->
            <div class="mb-4">
                <label for="tags" class="form-label">Tag</label>
                <input 
                    type="text" 
                    name="tags" 
                    class="form-control" 
                    placeholder="Masukkan tag terkait alat"
                >
            </div>

            <!-- Tanggal Kedaluwarsa -->
            <div class="mb-4">
                <label for="expiration_date" class="form-label">Tanggal Kedaluwarsa</label>
                <input 
                    type="date" 
                    name="expiration_date" 
                    class="form-control" 
                    required
                >
            </div>

            <!-- Tombol Kirim -->
            <button 
                type="submit" 
                class="btn btn-success w-100 animate__animated animate__pulse"
            >
                Kirim Inspeksi
            </button>
        </form>
    </div>
</div>

<!-- Modal Gambar -->
<div id="imageModal" class="modal d-none justify-content-center align-items-center"
     style="background-color: rgba(0, 0, 0, 0.8); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000;">
    <div style="position: relative;">
        <span id="closeModal" 
              style="position: absolute; top: -30px; right: 0; font-size: 2rem; color: white; cursor: pointer;">&times;</span>
        <img id="modalImage" src="" 
             style="max-width: 100%; max-height: 90vh; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.5);">
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Modal untuk Membuka Gambar
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modal.classList.remove('d-none');
        modal.classList.add('d-flex');
    }

    // Tutup Modal
    document.getElementById('closeModal').onclick = function () {
        const modal = document.getElementById('imageModal');
        modal.classList.add('d-none');
        modal.classList.remove('d-flex');
    };

    // Tutup Modal Saat Klik di Luar
    window.onclick = function (event) {
        const modal = document.getElementById('imageModal');
        if (event.target === modal) {
            modal.classList.add('d-none');
            modal.classList.remove('d-flex');
        }
    };
</script>
@endsection

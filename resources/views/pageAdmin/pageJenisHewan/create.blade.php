@extends('layouts.app')

@section('title', 'Tambah Jenis Hewan')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Tambah Jenis Hewan</h2>
        <a href="{{ route('admin.jenis.hewan') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.jenis.hewan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_jenis_hewan" class="form-label fw-semibold">Nama Jenis Hewan</label>
                    <input type="text"
                           name="nama_jenis_hewan"
                           id="nama_jenis_hewan"
                           value="{{ old('nama_jenis_hewan') }}"
                           class="form-control @error('nama_jenis_hewan') is-invalid @enderror"
                           placeholder="Contoh: Kucing, Anjing, Kelinci...">

                    @error('nama_jenis_hewan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted small mt-4">
        &copy; {{ date('Y') }} Rumah Sakit Hewan | Developed by Princess Risha 👑
    </footer>
</div>
@endsection

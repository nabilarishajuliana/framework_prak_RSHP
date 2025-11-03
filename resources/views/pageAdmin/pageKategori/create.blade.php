@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Tambah Kategori Baru</h2>

    <form action="{{ route('admin.kategori.store') }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" placeholder="Masukkan nama kategori" required>
            @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- <div class="mb-3">
            <label class="form-label">Deskripsi (Opsional)</label>
            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi kategori..."></textarea>
            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div> -->

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kategori') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection

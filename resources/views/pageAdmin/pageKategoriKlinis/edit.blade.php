@extends('layouts.app')

@section('title', 'Edit Kategori Klinis')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Edit Kategori Klinis</h2>

    <form action="{{ route('admin.kategori.klinis.update', $kategoriKlinis->idkategori_klinis) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Kategori Klinis</label>
            <input type="text" name="nama_kategori_klinis" value="{{ old('nama_kategori_klinis', $kategoriKlinis->nama_kategori_klinis) }}" class="form-control @error('nama_kategori_klinis') is-invalid @enderror" required>
            @error('nama_kategori_klinis') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

  

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kategori.klinis') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
</div>
@endsection

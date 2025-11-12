@extends('layouts.adminlte.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold mb-0"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Kategori</h3>
    <p class="text-muted small mb-0">Perbarui data kategori yang sudah ada.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <form action="{{ route('admin.kategori.update', $kategori->idkategori) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori"
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                   class="form-control @error('nama_kategori') is-invalid @enderror"
                   required>
            @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kategori') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-warning rounded-pill px-4">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => document.querySelectorAll('.alert').forEach(a => a.remove()), 3000);
</script>
@endsection

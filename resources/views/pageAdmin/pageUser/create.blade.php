@extends('layouts.adminlte.app')

@section('title', 'Tambah User')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2"><i class="bi bi-person-plus text-success me-2"></i>Tambah User Baru</h3>
    <p class="text-muted small mb-0">Isi form di bawah untuk menambahkan user baru.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <form action="{{ route('admin.user.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email">
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 5 karakter">
          </div>

          <div class="mb-3">
            <label class="form-label">Role Awal</label>
            <select name="role" class="form-select">
              <option value="">-- Pilih Role --</option>
              @foreach ($roles as $r)
                <option value="{{ $r->idrole }}">{{ $r->nama_role }}</option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => el.remove());
  }, 3000);
</script>
@endsection

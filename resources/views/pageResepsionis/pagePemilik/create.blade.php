@extends('layouts.adminlte.app')

@section('title', 'Tambah Pemilik')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2">
      <i class="bi bi-person-plus text-primary me-2"></i>Tambah Pemilik Baru
    </h3>
    <p class="text-muted small mb-0">Masukkan data pemilik serta akun login-nya.</p>
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
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">

        <form action="{{ route('resepsionis.pemilik.store') }}" method="POST">
          @csrf

          <h5 class="fw-semibold mb-3 text-primary">Data User</h5>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">
              @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <hr>

          <h5 class="fw-semibold mb-3 text-primary">Data Pemilik</h5>

          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">No WhatsApp</label>
            <input type="text" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" value="{{ old('no_wa') }}">
            @error('no_wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('resepsionis.pemilik') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

@endsection

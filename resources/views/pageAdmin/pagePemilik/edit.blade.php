@extends('layouts.adminlte.app')

@section('title', 'Edit Pemilik & User')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Pemilik & User</h3>
    <p class="text-muted small mb-0">Perbarui data akun dan informasi pemilik hewan.</p>
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
        <form action="{{ route('admin.pemilik.update', $pemilik->idpemilik) }}" method="POST">
          @csrf
          @method('PUT')

          <h5 class="fw-semibold mb-3 text-primary">Data User</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" value="{{ old('nama', $pemilik->user->nama) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="{{ old('email', $pemilik->user->email) }}" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control" placeholder="Isi jika ingin ubah password">
          </div>

          <hr class="my-4">

          <h5 class="fw-semibold mb-3 text-primary">Data Pemilik</h5>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $pemilik->alamat) }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">No. WhatsApp</label>
            <input type="text" name="no_wa" value="{{ old('no_wa', $pemilik->no_wa) }}" class="form-control">
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.pemilik') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
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

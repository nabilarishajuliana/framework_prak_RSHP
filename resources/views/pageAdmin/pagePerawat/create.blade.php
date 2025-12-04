@extends('layouts.adminlte.app')
@section('title', 'Tambah Perawat')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark"><i class="bi bi-person-plus me-2 text-primary"></i>Tambah Perawat Baru</h3>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <form action="{{ route('admin.perawat.store') }}" method="POST">
          @csrf

          <h5 class="fw-bold text-primary mb-3">Data User</h5>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
          </div>

          <hr class="my-3">

          <h5 class="fw-bold text-primary mb-3">Data Perawat</h5>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <div class="col-md-8 mb-3">
              <label class="form-label">No HP</label>
              <input type="text" name="no_hp" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Pendidikan</label>
            <input type="text" name="pendidikan" class="form-control">
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.perawat') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>
@endsection

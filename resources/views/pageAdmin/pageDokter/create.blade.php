@extends('layouts.adminlte.app')

@section('title', 'Tambah Dokter')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark"><i class="bi bi-person-plus text-primary me-2"></i>Tambah Dokter</h3>
    <p class="text-muted small mb-0">Tambahkan user & detail dokter baru.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">

        <form action="{{ route('admin.dokter.store') }}" method="POST">
          @csrf

          <h5 class="fw-semibold mb-3 text-primary">Data User</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Nama Lengkap</label>
              <input type="text" name="nama" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
          </div>

          <hr>

          <h5 class="fw-semibold mb-3 text-primary">Data Dokter</h5>

          <div class="mb-3">
            <label>Bidang Dokter</label>
            <input type="text" name="bidang_dokter" class="form-control">
          </div>

          <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control">
          </div>

          <div class="text-end">
            <a href="{{ route('admin.dokter') }}" class="btn btn-secondary">Batal</a>
            <button class="btn btn-primary">Simpan</button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>
@endsection

@extends('layouts.adminlte.app')
@section('title', 'Edit Perawat')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Perawat</h3>
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
        <form action="{{ route('admin.perawat.update', $perawat->idperawat) }}" method="POST">
          @csrf @method('PUT')

          <h5 class="fw-bold text-primary mb-3">Data User</h5>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" value="{{ $perawat->user->nama }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="{{ $perawat->user->email }}" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password (opsional)</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
          </div>

          <hr class="my-3">

          <h5 class="fw-bold text-primary mb-3">Data Perawat</h5>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="L" {{ $perawat->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $perawat->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>

            <div class="col-md-8 mb-3">
              <label class="form-label">No HP</label>
              <input type="text" name="no_hp" value="{{ $perawat->no_hp }}" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2">{{ $perawat->alamat }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Pendidikan</label>
            <input type="text" name="pendidikan" value="{{ $perawat->pendidikan }}" class="form-control">
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.perawat') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-warning rounded-pill px-4">Update</button>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>
@endsection

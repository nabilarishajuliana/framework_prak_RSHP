@extends('layouts.adminlte.app')

@section('title', 'Edit Pet')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Pet</h3>
    <p class="text-muted small mb-0">Perbarui data hewan peliharaan di bawah ini.</p>
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
        <form action="{{ route('admin.pet.update', $pet->idpet) }}" method="POST">
          @csrf @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Pet</label>
              <input type="text" name="nama" value="{{ old('nama', $pet->nama) }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="P" {{ $pet->jenis_kelamin == 'P' ? 'selected' : '' }}>Betina</option>
                <option value="L" {{ $pet->jenis_kelamin == 'L' ? 'selected' : '' }}>Jantan</option>
              </select>
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ $pet->tanggal_lahir }}" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Warna / Tanda</label>
            <input type="text" name="warna_tanda" value="{{ old('warna_tanda', $pet->warna_tanda) }}" class="form-control">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Ras Hewan</label>
              <select name="idras_hewan" class="form-select">
                @foreach ($rasHewan as $r)
                  <option value="{{ $r->idras_hewan }}" {{ $pet->idras_hewan == $r->idras_hewan ? 'selected' : '' }}>
                    {{ $r->nama_ras }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Pemilik</label>
              <select name="idpemilik" class="form-select">
                @foreach ($pemilik as $p)
                  <option value="{{ $p->idpemilik }}" {{ $pet->idpemilik == $p->idpemilik ? 'selected' : '' }}>
                    {{ $p->user->nama }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.pet') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
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

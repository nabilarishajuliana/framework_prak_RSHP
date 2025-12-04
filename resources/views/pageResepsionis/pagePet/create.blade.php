@extends('layouts.adminlte.app')

@section('title', 'Tambah Pet')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold mb-2"><i class="bi bi-plus-circle text-primary me-2"></i>Tambah Pet</h3>
    <p class="text-muted small">Isi data hewan peliharaan.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">

        <form action="{{ route('resepsionis.pet.store') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Nama Pet</label>
              <input type="text" name="nama" value="{{ old('nama') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
              <label>Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="P">Betina</option>
                <option value="L">Jantan</option>
              </select>
            </div>

            <div class="col-md-3 mb-3">
              <label>Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label>Warna / Tanda</label>
            <input type="text" name="warna_tanda" value="{{ old('warna_tanda') }}" class="form-control">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Ras Hewan</label>
              <select name="idras_hewan" class="form-select">
                @foreach ($rasHewan as $r)
                  <option value="{{ $r->idras_hewan }}">{{ $r->nama_ras }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Pemilik</label>
              <select name="idpemilik" class="form-select">
                @foreach ($pemilik as $p)
                  <option value="{{ $p->idpemilik }}">{{ $p->user->nama }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button class="btn btn-primary rounded-pill px-4">Simpan</button>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

@endsection

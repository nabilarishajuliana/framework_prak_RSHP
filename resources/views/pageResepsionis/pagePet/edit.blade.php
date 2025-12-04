@extends('layouts.adminlte.app')

@section('title', 'Edit Pet')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold mb-2"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Pet</h3>
    <p class="text-muted small">Perbarui data hewan peliharaan.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">

        <form action="{{ route('resepsionis.pet.update', $pet->idpet) }}" method="POST">
          @csrf @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Nama Pet</label>
              <input name="nama" value="{{ $pet->nama }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
              <label>Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="P" {{ $pet->jenis_kelamin=='P'?'selected':'' }}>Betina</option>
                <option value="L" {{ $pet->jenis_kelamin=='L'?'selected':'' }}>Jantan</option>
              </select>
            </div>

            <div class="col-md-3 mb-3">
              <label>Tgl Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ $pet->tanggal_lahir }}" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label>Warna / Tanda</label>
            <input name="warna_tanda" value="{{ $pet->warna_tanda }}" class="form-control">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Ras Hewan</label>
              <select name="idras_hewan" class="form-select">
                @foreach ($rasHewan as $r)
                  <option value="{{ $r->idras_hewan }}" {{ $pet->idras_hewan==$r->idras_hewan?'selected':'' }}>
                    {{ $r->nama_ras }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Pemilik</label>
              <select name="idpemilik" class="form-select">
                @foreach ($pemilik as $p)
                  <option value="{{ $p->idpemilik }}" {{ $pet->idpemilik==$p->idpemilik?'selected':'' }}>
                    {{ $p->user->nama }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button class="btn btn-warning rounded-pill px-4">Update</button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

@endsection

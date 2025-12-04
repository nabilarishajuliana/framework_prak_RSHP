@extends('layouts.adminlte.app')

@section('title', 'Tambah Antrian')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>Tambah Antrian Temu Dokter</h3>
    <p class="small text-muted">Pilih pet yang ingin didaftarkan.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">

        <form action="{{ route('resepsionis.temu.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label">Pilih Pet</label>
            <select name="idpet" class="form-select">
              @foreach($pets as $p)
                <option value="{{ $p->idpet }}">
                  {{ $p->nama }} — {{ $p->pemilik->user->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-end">
            <button class="btn btn-primary rounded-pill px-4">Tambah</button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

@endsection

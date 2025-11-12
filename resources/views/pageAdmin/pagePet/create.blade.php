@extends('layouts.adminlte.app')

@section('title', 'Tambah Pet')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2"><i class="bi bi-plus-circle text-primary me-2"></i>Tambah Pet Baru</h3>
    <p class="text-muted small mb-0">Isi data hewan peliharaan dengan lengkap.</p>
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
        <form action="{{ route('admin.pet.store') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Pet</label>
              <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
              @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                <option value="">-- Pilih --</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Betina</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Jantan</option>
              </select>
              @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Warna / Tanda</label>
            <input type="text" name="warna_tanda" value="{{ old('warna_tanda') }}" class="form-control @error('warna_tanda') is-invalid @enderror">
            @error('warna_tanda') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Ras Hewan</label>
              <select name="idras_hewan" class="form-select @error('idras_hewan') is-invalid @enderror">
                <option value="">-- Pilih Ras Hewan --</option>
                @foreach ($rasHewan as $r)
                  <option value="{{ $r->idras_hewan }}" {{ old('idras_hewan') == $r->idras_hewan ? 'selected' : '' }}>
                    {{ $r->nama_ras }}
                  </option>
                @endforeach
              </select>
              @error('idras_hewan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Pemilik</label>
              <select name="idpemilik" class="form-select @error('idpemilik') is-invalid @enderror">
                <option value="">-- Pilih Pemilik --</option>
                @foreach ($pemilik as $p)
                  <option value="{{ $p->idpemilik }}" {{ old('idpemilik') == $p->idpemilik ? 'selected' : '' }}>
                    {{ $p->user->nama }}
                  </option>
                @endforeach
              </select>
              @error('idpemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.pet') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
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

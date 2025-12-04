@extends('layouts.adminlte.app')

@section('title', 'Edit Dokter')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2">
      <i class="bi bi-person-video2 text-warning me-2"></i> Edit Dokter
    </h3>
    <p class="text-muted small mb-0">Perbarui data dokter beserta akun user-nya.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    {{-- ALERT ERROR --}}
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">

        <form action="{{ route('admin.dokter.update', $dokter->iddokter) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- ========================== USER DATA ========================== --}}
          <h5 class="fw-semibold mb-3 text-primary">Data User</h5>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="nama"
                     class="form-control @error('nama') is-invalid @enderror"
                     value="{{ old('nama', $dokter->user->nama) }}">
              @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email"
                     class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email', $dokter->user->email) }}">
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password Baru (opsional)</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Biarkan kosong jika tidak ingin mengubah password">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <hr class="my-4">

          {{-- ========================== DOKTER DATA ========================== --}}
          <h5 class="fw-semibold mb-3 text-primary">Data Dokter</h5>

          {{-- Jenis Kelamin --}}
          <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
              <option value="L" {{ old('jenis_kelamin', $dokter->jenis_kelamin) === 'L' ? 'selected' : '' }}>
                Laki-laki
              </option>
              <option value="P" {{ old('jenis_kelamin', $dokter->jenis_kelamin) === 'P' ? 'selected' : '' }}>
                Perempuan
              </option>
            </select>
            @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Alamat --}}
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat"
                      class="form-control @error('alamat') is-invalid @enderror"
                      rows="2">{{ old('alamat', $dokter->alamat) }}</textarea>
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- No HP --}}
          <div class="mb-3">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp"
                   class="form-control @error('no_hp') is-invalid @enderror"
                   value="{{ old('no_hp', $dokter->no_hp) }}">
            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Bidang Dokter --}}
          <div class="mb-3">
            <label class="form-label">Bidang Dokter</label>
            <input type="text" name="bidang_dokter"
                   class="form-control @error('bidang_dokter') is-invalid @enderror"
                   value="{{ old('bidang_dokter', $dokter->bidang_dokter) }}">
            @error('bidang_dokter') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- BUTTONS --}}
          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.dokter') }}" class="btn btn-outline-secondary rounded-pill px-4">
              Batal
            </a>
            <button type="submit" class="btn btn-warning rounded-pill px-4">
              Update
            </button>
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

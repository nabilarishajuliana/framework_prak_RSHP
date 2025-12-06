@extends('layouts.adminlte.app')

@section('title', 'Profil Dokter')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark">
      <i class="bi bi-person-circle text-primary me-2"></i>Profil Dokter
    </h3>
    <p class="text-muted small">Informasi akun dan data Dokter.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show auto-dismiss">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">

        {{-- ===================== DATA AKUN ===================== --}}
        <h5 class="fw-bold text-primary">Data Akun</h5>
        <hr>

        <p><strong>Nama:</strong> {{ $user->nama ?? '- Tidak tersedia -' }}</p>

        <p><strong>Email:</strong> 
          {{ $user->email ?? '- Tidak tersedia -' }}
        </p>

        {{-- ===================== DATA Dokter ===================== --}}
        <h5 class="fw-bold text-primary mt-4">Data Dokter</h5>
        <hr>

        <p><strong>Jenis Kelamin:</strong>
          @if ($dokter->jenis_kelamin)
              {{ $dokter->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
          @else
              - Belum diisi -
          @endif
        </p>

        <p><strong>Alamat:</strong> 
          {{ $dokter->alamat ? ucwords($dokter->alamat) : '- Belum diisi -' }}
        </p>

        <p><strong>No HP:</strong> 
          {{ $dokter->no_hp ?? '- Belum diisi -' }}
        </p>

        <p><strong>Bidang:</strong> 
          {{ $dokter->bidang_dokter ?? '- Belum diisi -' }}
        </p>

      </div>
    </div>

  </div>
</div>

{{-- Auto dismiss alert --}}
<script>
  setTimeout(() => {
    document.querySelectorAll('.auto-dismiss')
      .forEach(el => el.remove());
  }, 3000);
</script>

@endsection

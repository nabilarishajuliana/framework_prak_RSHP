@extends('layouts.adminlte.app')

@section('title', 'Profil Perawat')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark">
      <i class="bi bi-person-circle text-primary me-2"></i>Profil Perawat
    </h3>
    <p class="text-muted small">Informasi akun dan data perawat.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">

        <h5 class="fw-bold text-primary">Data Akun</h5>
        <hr>

        <p><strong>Nama:</strong> {{ $user->nama }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <h5 class="fw-bold text-primary mt-4">Data Perawat</h5>
        <hr>

        <p><strong>Jenis Kelamin:</strong>
          {{ $perawat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
        </p>

        <p><strong>Alamat:</strong> {{ $perawat->alamat ?? '-' }}</p>
        <p><strong>No HP:</strong> {{ $perawat->no_hp ?? '-' }}</p>
        <p><strong>Pendidikan:</strong> {{ $perawat->pendidikan ?? '-' }}</p>

        <!-- <div class="mt-4">
          <a href="{{ route('perawat.profile.edit') }}" class="btn btn-primary rounded-pill px-4">
            Edit Profil
          </a>
        </div> -->

      </div>
    </div>

  </div>
</div>

@endsection

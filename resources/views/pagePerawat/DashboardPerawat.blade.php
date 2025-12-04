@extends('layouts.adminlte.app')

@section('title', 'Dashboard Perawat')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold text-dark mb-0">
          <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard Perawat
        </h3>
        <p class="text-muted small mb-0">Selamat datang di sistem perawat.</p>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    {{-- Welcome --}}
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h4 class="fw-semibold">
          Hai, <strong>{{ session('user_name') }}</strong> 👋
        </h4>
        <p class="text-muted mb-0">Semoga harimu menyenangkan dan penuh semangat ✨</p>
      </div>
    </div>

    <div class="row">

      {{-- Pasien Hari Ini --}}
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <span class="badge bg-primary p-3 rounded-circle">
                <i class="bi bi-people fs-4"></i>
              </span>
            </div>
            <div>
              <h5 class="fw-bold mb-0">{{ $totalPasienHariIni }}</h5>
              <p class="text-muted small mb-0">Pasien Hari Ini</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Rekam Medis Hari Ini --}}
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <span class="badge bg-success p-3 rounded-circle">
                <i class="bi bi-journal-medical fs-4"></i>
              </span>
            </div>
            <div>
              <h5 class="fw-bold mb-0">{{ $rekamMedisHariIni }}</h5>
              <p class="text-muted small mb-0">Rekam Medis Hari Ini</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Total Pet --}}
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <span class="badge bg-info p-3 rounded-circle">
                <i class="bi bi-bug fs-4"></i>
              </span>
            </div>
            <div>
              <h5 class="fw-bold mb-0">{{ $totalPet }}</h5>
              <p class="text-muted small mb-0">Total Hewan Terdaftar</p>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection

@extends('layouts.adminlte.app')

@section('title', 'Dashboard Dokter')
@section('page_title', 'Dashboard Dokter')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card shadow-sm">
      <div class="card-body">

        <h4 class="fw-bold">Selamat datang, dr. {{ session('user_name') }}</h4>
        <p class="text-muted mb-4">Berikut ringkasan aktivitas hari ini</p>

        <div class="row">
          <div class="col-md-4">
            <div class="small-box bg-primary text-white p-3 rounded">
              <h3>{{ $totalAntrianHariIni }}</h3>
              <p>Antrian Hari Ini</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="small-box bg-success text-white p-3 rounded">
              <h3>{{ $totalPasienSelesai }}</h3>
              <p>Pasien Selesai</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="small-box bg-danger text-white p-3 rounded">
              <h3>{{ $totalBatal }}</h3>
              <p>Pasien Batal</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection

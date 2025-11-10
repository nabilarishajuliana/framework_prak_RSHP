@extends('layouts.adminlte.app')

@section('title', 'Dashboard Administrator')
@section('page_title', 'Dashboard')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4>Selamat datang, <strong>{{ session('user_name') }}</strong> 👋</h4>
          <p class="text-muted">Ini halaman dashboard utama </p>
        </div>
      </div>
    </div>
  </div>
@endsection

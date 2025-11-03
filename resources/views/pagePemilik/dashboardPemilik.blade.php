@extends('layouts.app')

@section('title', 'Dashboard pemilik')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Dashboard pemilik</h2>
        <div>
            <span class="text-muted">Halo, <strong>{{ session('user_name') }}</strong> 👋</span>
        </div>
    </div>

    <!-- Statistik Cards -->
  

    <!-- Footer -->
    <footer class="text-center text-muted small mt-4">
        &copy; {{ date('Y') }} Rumah Sakit Hewan | Developed by Princess Risha 👑
    </footer>
</div>
@endsection

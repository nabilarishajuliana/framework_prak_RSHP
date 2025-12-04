<?php

function isRole($roleName)
{
  return strtolower(session('user_role_name')) === strtolower($roleName);
}
?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="#" class="brand-link">
      <img src="{{ asset('assets/img/AdminLTELogo.png') }}" class="brand-image opacity-75 shadow">
      <span class="brand-text fw-light">RS Hewan Panel</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">

        {{-- ==================== ADMIN ==================== --}}
        @if (isRole('administrator'))
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">MASTER DATA</li>
        <li class="nav-item"><a href="{{ route('admin.user') }}" class="nav-link"><i class="bi bi-people nav-icon"></i>
            <p>User</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.role') }}" class="nav-link"><i class="bi bi-shield nav-icon"></i>
            <p>Role</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.pemilik') }}" class="nav-link"><i class="bi bi-person nav-icon"></i>
            <p>Pemilik</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.pet') }}" class="nav-link"><i class="bi bi-bug nav-icon"></i>
            <p>Pet</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.jenis.hewan') }}" class="nav-link"><i class="bi bi-tag nav-icon"></i>
            <p>Jenis Hewan</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.ras.hewan') }}" class="nav-link"><i class="bi bi-tags nav-icon"></i>
            <p>Ras Hewan</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.kategori') }}" class="nav-link"><i class="bi bi-folder nav-icon"></i>
            <p>Kategori</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.kategori.klinis') }}" class="nav-link"><i class="bi bi-journal nav-icon"></i>
            <p>Kategori Klinis</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.kode.tindakan') }}" class="nav-link"><i class="bi bi-clipboard2 nav-icon"></i>
            <p>Kode Tindakan</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.dokter') }}" class="nav-link"><i class="bi bi-people nav-icon"></i>
            <p>Dokter</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('admin.perawat') }}" class="nav-link"><i class="bi bi-people nav-icon"></i>
            <p>Perawat</p>
          </a></li>
        <li class="nav-item">
          <a href="{{ route('admin.temu') }}" class="nav-link">
            <i class="bi bi-calendar nav-icon"></i>
            <p>Temu Dokter</p>
          </a>
        </li>

        @endif


        {{-- ==================== DOKTER ==================== --}}
        @if (isRole('dokter'))
        <li class="nav-item">
          <a href="{{ route('dokter.dashboard') }}" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard Dokter</p>
          </a>
        </li>

        <li class="nav-header">MENU DOKTER</li>
        <li class="nav-item"><a href="{{ route('dokter.rekammedis') }}" class="nav-link"><i class="bi bi-journal-text"></i>
            <p>Rekam Medis</p>
          </a></li>
        @endif


        {{-- ==================== PERAWAT ==================== --}}
        @if (isRole('perawat'))
        <li class="nav-item">
          <a href="{{ route('perawat.dashboard') }}" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard Perawat</p>
          </a>
        </li>

        <li class="nav-header">MENU PERAWAT</li>
        <li class="nav-item"><a href="{{ route('perawat.rekammedis') }}" class="nav-link"><i class="bi bi-people"></i>
            <p>Rekam Medis</p>
          </a></li>

        @endif


        {{-- ==================== RESEPSIONIS ==================== --}}
        @if (isRole('resepsionis'))
        <li class="nav-item">
          <a href="{{ route('resepsionis.dashboard') }}" class="nav-link">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard Resepsionis</p>
          </a>
        </li>

        <li class="nav-header">MENU RESEPSIONIS</li>

        <li class="nav-item">
          <a href="{{ route('resepsionis.pemilik') }}" class="nav-link">
            <i class="bi bi-person nav-icon"></i>
            <p>Kelola Pemilik</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('resepsionis.pet') }}" class="nav-link">
            <i class="bi bi-bug nav-icon"></i>
            <p>Kelola Hewan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('resepsionis.temu') }}" class="nav-link">
            <i class="bi bi-calendar nav-icon"></i>
            <p>Temu Dokter</p>
          </a>
        </li>
        @endif


        {{-- ==================== PEMILIK ==================== --}}
        @if (isRole('pemilik'))
        <li class="nav-item">
          <a href="{{ route('pemilik.dashboard') }}" class="nav-link">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard Saya</p>
          </a>
        </li>

        <li class="nav-header">MENU PEMILIK</li>
        <li class="nav-item"><a href="{{ route('pemilik.jadwal') }}" class="nav-link"><i class="bi bi-calendar-event"></i>
            <p>Jadwal Temu Dokter</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('pemilik.rekam') }}" class="nav-link"><i class="bi bi-journal"></i>
            <p>Rekam Medis</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('pemilik.pet') }}" class="nav-link"><i class="bi bi-bug-fill"></i>
            <p>Hewan Saya</p>
          </a></li>
        <li class="nav-item"><a href="{{ route('pemilik.profil') }}" class="nav-link"><i class="bi bi-person-vcard"></i>
            <p>Profil Saya</p>
          </a></li>
        @endif

      </ul>
    </nav>
  </div>
</aside>
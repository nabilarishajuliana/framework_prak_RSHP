<!-- resources/views/layouts/adminlte/sidebar.blade.php -->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow">
      <span class="brand-text fw-light">RS Hewan Panel</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link active">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header text-uppercase small mt-3">Quick Access</li>

        <li class="nav-item"><a href="{{ route('admin.user') }}" class="nav-link"><i class="bi bi-people nav-icon"></i> <p>Users</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.role') }}" class="nav-link"><i class="bi bi-shield-lock nav-icon"></i> <p>Roles</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.pemilik') }}" class="nav-link"><i class="bi bi-person nav-icon"></i> <p>Pemilik</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.pet') }}" class="nav-link"><i class="bi bi-bug nav-icon"></i> <p>Pets</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.jenis.hewan') }}" class="nav-link"><i class="bi bi-tag nav-icon"></i> <p>Jenis Hewan</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.ras.hewan') }}" class="nav-link"><i class="bi bi-tags nav-icon"></i> <p>Ras Hewan</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.kategori') }}" class="nav-link"><i class="bi bi-folder nav-icon"></i> <p>Kategori</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.kategori.klinis') }}" class="nav-link"><i class="bi bi-journal-medical nav-icon"></i> <p>Kategori Klinis</p></a></li>
        <li class="nav-item"><a href="{{ route('admin.kode.tindakan') }}" class="nav-link"><i class="bi bi-clipboard2-pulse nav-icon"></i> <p>Kode Tindakan</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

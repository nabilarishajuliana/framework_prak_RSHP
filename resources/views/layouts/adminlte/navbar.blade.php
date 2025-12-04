@php
    $role = strtolower(session('user_role_name') ?? 'administrator');

    // Tentukan route dashboard berdasarkan role
    $dashboardRoute = match($role) {
        'administrator'        => 'admin.dashboard',
        'dokter'       => 'dokter.dashboard',
        'perawat'      => 'perawat.dashboard',
        'resepsionis'  => 'resepsionis.dashboard',
        'pemilik'      => 'pemilik.dashboard',
        default        => 'admin.dashboard'
    };

    // Tampilkan label role yang rapi
    $roleLabel = ucfirst($role);
@endphp

<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">

    <!-- Left menu -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>

      <li class="nav-item d-none d-md-block">
        <a href="{{ route($dashboardRoute) }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right menu -->
    <ul class="navbar-nav ms-auto">

      <!-- Fullscreen -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display:none"></i>
        </a>
      </li>

      <!-- User Dropdown -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img src="{{ asset('assets/img/user2-160x160.jpg') }}" 
               class="user-image rounded-circle shadow" alt="User Image">

          <span class="d-none d-md-inline">
            {{ session('user_name') ?? 'User' }}
          </span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
          
          <!-- User header -->
          <li class="user-header text-bg-primary">
            <p>
              {{ session('user_name') ?? 'User' }}  
              <br>
              <small>{{ "Logged in as $roleLabel" }}</small>
            </p>
          </li>

          <!-- Footer -->
          <li class="user-footer">
            <a class="btn btn-default btn-flat float-end"
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </li>

    </ul>

  </div>
</nav>

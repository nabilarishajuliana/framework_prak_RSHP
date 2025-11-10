<!-- resources/views/layouts/adminlte/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
@include('layouts.adminlte.head')

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">

    @include('layouts.adminlte.navbar')
    @include('layouts.adminlte.sidebar')

    <main class="app-main">
      <div class="app-content-header">
        <div class="container-fluid">
          <h3 class="mb-3">@yield('page_title', 'Dashboard')</h3>
        </div>
      </div>

      <div class="app-content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </main>

    @include('layouts.adminlte.footer')
  </div>

  {{-- Script bawaan AdminLTE --}}
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/adminlte.js') }}"></script>

  <script>
document.addEventListener("DOMContentLoaded", function () {
    // Cari semua alert dengan class .alert-dismissible
    const alerts = document.querySelectorAll('.alert-dismissible');
    
    alerts.forEach(alert => {
        // Setelah 4 detik (4000 ms), mulai fade out
        setTimeout(() => {
            alert.classList.add('fade');
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            
            // Setelah animasi selesai, hapus elementnya
            setTimeout(() => alert.remove(), 600);
        }, 4000); // ubah waktu di sini (4000 = 4 detik)
    });
});
</script>

</body>

</html>

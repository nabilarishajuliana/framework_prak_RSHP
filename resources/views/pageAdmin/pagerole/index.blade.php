@extends('layouts.adminlte.app')

@section('title', 'Data Role')

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-shield-lock text-primary me-2"></i>Data Role</h3>
        <p class="text-muted small mb-0">Kelola daftar role dan user yang memiliki role tersebut.</p>
      </div>
      <div class="d-flex gap-2">

        <a href="{{ route('admin.role.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
          + Tambah Role
        </a>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
  <div class="container-fluid">

    {{-- ✅ Alert Section --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
      <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
    @elseif (session('error'))
    <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
    </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive">
        <table class="table align-middle table-hover">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama Role</th>
              <th>Jumlah User</th>
              <th>Daftar User</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($roles as $index => $r)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td><span class="badge bg-primary">{{ $r->nama_role }}</span></td>
              <td>
                Aktif: {{ $r->users->whereNull('deleted_at')->count() }} <br>
                Total: {{ $r->users->count() }}
              </td>

              <td>
                @forelse ($r->users as $user)
                <span class="{{ $user->deleted_at ? 'text-muted fst-italic' : '' }}">
                  {{ $user->nama }}
                </span>
                @if(!$loop->last), @endif
                @empty
                <em class="text-muted">Tidak ada user</em>
                @endforelse
              </td>
              <td class="text-center">
                <a href="{{ route('admin.role.edit', $r->idrole) }}" class="btn btn-warning btn-sm rounded-pill px-3">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.role.destroy', $r->idrole) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" onclick="return confirm('Yakin ingin menghapus role ini?')"
                    class="btn btn-danger btn-sm rounded-pill px-3">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted fst-italic">Belum ada data role.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => document.querySelectorAll('.auto-dismiss').forEach(a => a.remove()), 3000);
</script>
@endsection
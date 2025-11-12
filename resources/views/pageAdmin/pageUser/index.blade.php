@extends('layouts.adminlte.app')

@section('title', 'Data User')

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Data User</h3>
        <p class="text-muted small mb-0">Kelola data user dan role aktif.</p>
      </div>
      <div class="d-flex gap-2">
       
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
          + Tambah User
        </a>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
  <div class="container-fluid">

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
        <table class="table table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role Aktif</th>
              <th>Pilih Role</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $index => $u)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $u->nama }}</td>
                <td>{{ $u->email }}</td>
                <td>
                  @if ($u->pemilik)
                    <span class="badge bg-info text-dark">Pemilik</span>
                  @else
                    <span class="badge bg-success-subtle text-success">{{ $u->activeRole()->nama_role ?? 'Tidak Ada' }}</span>
                  @endif
                </td>
                <td>
                  @if ($u->pemilik)
                    <span class="text-muted small">Tidak dapat diubah</span>
                  @else
                    <form action="{{ route('admin.user.switchRole', $u->iduser) }}" method="POST" class="d-flex gap-2">
                      @csrf
                      @method('PUT')
                      <select name="role_id" class="form-select form-select-sm w-auto">
                        @foreach ($roles as $r)
                          <option value="{{ $r->idrole }}"
                            {{ $u->activeRole() && $u->activeRole()->idrole == $r->idrole ? 'selected' : '' }}>
                            {{ $r->nama_role }}
                          </option>
                        @endforeach
                      </select>
                      <button type="submit" class="btn btn-outline-success btn-sm rounded-pill">Set</button>
                    </form>
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('admin.user.edit', $u->iduser) }}" class="btn btn-warning btn-sm rounded-pill px-3">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.user.destroy', $u->iduser) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus user ini?')"
                      class="btn btn-danger btn-sm rounded-pill px-3">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted">Belum ada data user.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => {
    document.querySelectorAll('.auto-dismiss').forEach(el => el.remove());
  }, 3000);
</script>
@endsection

@extends('layouts.app')
@section('title', 'Data User')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Data User</h2>

    {{-- ✅ Alert Success / Error --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="d-flex justify-content-end mb-3">

        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                + Tambah User
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
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
                    @foreach ($users as $index => $u)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $u->nama }}</td>
                        <td>{{ $u->email }}</td>

                        {{-- 🔹 Role aktif --}}
                        <td>
                            @if ($u->pemilik)
                            <span class="badge bg-info text-dark">Pemilik</span>
                            @else
                            <span class="badge bg-success">
                                {{ $u->activeRole()->nama_role ?? 'Tidak Ada' }}
                            </span>
                            @endif
                        </td>

                        {{-- 🔹 Dropdown pilih role --}}
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
                                <button type="submit" class="btn btn-sm btn-outline-success">Set</button>
                            </form>
                            @endif
                        </td>

                        {{-- 🔹 Tombol aksi --}}
                        <td class="text-center">
                            <a href="{{ route('admin.user.edit', $u->iduser) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.user.destroy', $u->iduser) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus user ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 small text-muted">
                Total User: {{ $users->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
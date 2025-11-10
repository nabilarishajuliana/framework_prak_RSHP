@extends('layouts.app')
@section('title', 'Data Role')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Role</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
            <a href="{{ route('admin.role.create') }}" class="btn btn-primary">+ Tambah Role</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
                            <td><span class="badge bg-info text-dark">{{ $r->nama_role }}</span></td>
                            <td>{{ $r->users->count() }}</td>
                            <td>
                                @forelse ($r->users as $user)
                                    <span>{{ $user->nama }}</span>@if(!$loop->last), @endif
                                @empty
                                    <em class="text-muted">Tidak ada user</em>
                                @endforelse
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.role.edit', $r->idrole) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.role.destroy', $r->idrole) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus role ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada data role.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

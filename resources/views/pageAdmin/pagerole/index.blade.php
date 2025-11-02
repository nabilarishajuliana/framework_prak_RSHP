@extends('layouts.app')

@section('title', 'Data Role')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Role</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="#" class="btn btn-primary disabled" title="Fitur belum tersedia">
                + Tambah Role
            </a>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <!-- <th>ID Role</th> -->
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
                                <!-- <td>{{ $r->idrole }}</td> -->
                                <td><span class="badge bg-primary">{{ $r->nama_role }}</span></td>
                                <td>{{ $r->users->count() }}</td>
                                <td>
                                    @if ($r->users->count() > 0)
                                        <ul class="mb-0">
                                            @foreach ($r->users as $user)
                                                <li>{{ $user->nama ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <em class="text-muted">Tidak ada user</em>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-warning disabled" title="Fitur belum tersedia">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger disabled" title="Fitur belum tersedia">Hapus</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data role.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="mt-3 text-muted small">
                Total Role: {{ $roles->count() }}
            </div>
        </div>
    </div>
</div>
@endsection

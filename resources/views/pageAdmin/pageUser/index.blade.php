@extends('layouts.app')

@section('title', 'Data User')

@section('content')

<style>
    ul.no-bullet {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data User</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="#" class="btn btn-primary disabled" title="Fitur belum tersedia">
                + Tambah User
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
                            <!-- <th>ID User</th> -->
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role / Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $u)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <!-- <td>{{ $u->iduser }}</td> -->
                            <td><span class="badge bg-primary">{{ $u->nama }}</span></td>
                            <td>{{ $u->email }}</td>
                            <td>
                                {{-- Jika user adalah Pemilik --}}
                                @if ($u->pemilik)
                                <span class="fw-semibold">
                                    Pemilik Hewan 
                                </span>
                                <br>
                                <!-- <small class="text-muted">
                                            {{ $u->pemilik->pet->count() ?? 0 }} hewan terdaftar
                                        </small> -->

                                {{-- Jika user punya role --}}
                                @elseif ($u->roles && $u->roles->count() > 0)
                                <ul style="list-style-type: none; padding-left: 0; margin-bottom: 0;">
                                    @foreach ($u->roles as $role)
                                    <li>
                                        @if ($role->pivot->status == 1)
                                        <span class="fw-semibold ">
                                            {{ $role->nama_role }} <span class="badge bg-success">Aktif</span>
                                        </span>
                                        @else
                                        <span class="text-muted">{{ $role->nama_role }}</span>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>

                                {{-- Jika tidak punya role sama sekali --}}
                                @else
                                <em class="text-muted">Belum memiliki role</em>
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
                                Belum ada data user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="mt-3 text-muted small">
                Total User: {{ $users->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
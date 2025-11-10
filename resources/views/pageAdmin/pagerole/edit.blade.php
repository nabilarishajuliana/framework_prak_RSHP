@extends('layouts.app')
@section('title', 'Edit Role')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Edit Role</h2>

    <form action="{{ route('admin.role.update', $role->idrole) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Role</label>
            <input type="text" name="nama_role" value="{{ old('nama_role', $role->nama_role) }}" class="form-control" required>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.role') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
</div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    @include('components.navbar')

    <div class="data-container">
        <div class="data-header">
            <h2>Data User</h2>
            <a href="#" class="btn-add">+ Tambah User</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                        <tr>
                            <td>{{ $u->iduser }}</td>
                            <td><span class="badge">{{ $u->nama }}</span></td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if ($u->roleUser->count() > 0)
                                    @foreach ($u->roleUser as $ru)
                                        <div class="user-role">
                                            {{ $ru->role->nama_role ?? '-' }}
                                        </div>
                                    @endforeach
                                @else
                                    <em>Tidak ada</em>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-edit">Edit</button>
                                    <button class="btn-delete">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer-info">
                <p>Total User: {{ $user->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Role - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    @include('components.navbar')

    <div class="data-container">
        <div class="data-header">
            <h2>Data Role</h2>
            <a href="#" class="btn-add">+ Tambah Role</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Role</th>
                        <th>Jumlah User</th>
                 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($role as $r)
                        <tr>
                            <td>{{ $r->idrole }}</td>
                            <td><span class="badge">{{ $r->nama_role }}</span></td>
                            <td>{{ $r->roleUser->count() }}</td>
                            
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
                <p>Total Role: {{ $role->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>

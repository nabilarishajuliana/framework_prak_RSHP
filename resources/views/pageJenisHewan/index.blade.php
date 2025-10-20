<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jenis Hewan</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    {{-- Navbar --}}
    @include('components.navbar')

    <div class="container">
        <div class="header">
            <h2>Jenis Hewan</h2>
            <a href="#" class="btn-add">+ Tambah Jenis</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Jenis Hewan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jenisHewan as $j)
                        <tr>
                            <td>{{ $j->idjenis_hewan }}</td>
                            <td><span class="badge">{{ $j->nama_jenis_hewan }}</span></td>
                            <td>
                                <button class="btn-edit">Edit</button>
                                <button class="btn-delete">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="footer-info">
                <p>Total data: {{ $jenisHewan->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>

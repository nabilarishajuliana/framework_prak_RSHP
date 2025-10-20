<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ras Hewan - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    @include('components.navbar')

    <div class="data-container">
        <div class="data-header">
            <h2>Ras Hewan</h2>
            <a href="#" class="btn-add">+ Tambah Ras</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Ras</th>
                        <th>Jenis Hewan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rasHewan as $r)
                        <tr>
                            <td>{{ $r->idras_hewan }}</td>
                            <td><span class="badge">{{ $r->nama_ras }}</span></td>
                            <td>{{ $r->jenisHewan->nama_jenis_hewan ?? '-' }}</td>
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
                <p>Total data: {{ $rasHewan->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Klinis - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    @include('components.navbar')

    <div class="data-container">
        <div class="data-header">
            <h2>Kategori Klinis</h2>
            <a href="#" class="btn-add">+ Tambah Kategori Klinis</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori Klinis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoriKlinis as $kk)
                        <tr>
                            <td>{{ $kk->idkategori_klinis }}</td>
                            <td><span class="badge">{{ $kk->nama_kategori_klinis }}</span></td>
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
                <p>Total data: {{ $kategoriKlinis->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>

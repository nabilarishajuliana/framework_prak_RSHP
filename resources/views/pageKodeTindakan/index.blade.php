<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Tindakan Terapi - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    @include('components.navbar')

    <div class="data-container">
        <div class="data-header">
            <h2>Kode Tindakan Terapi</h2>
            <a href="#" class="btn-add">+ Tambah Tindakan</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode </th>
                        <th>Nama Tindakan</th>
                        <th>Kategori</th>
                        <th>Kategori Klinis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kodeTindakan as $kt)
                        <tr>
                            <td>{{ $kt->idkode_tindakan_terapi }}</td>
                            <td><span class="badge">{{ $kt->kode }}</span></td>
                            <td>{{ $kt->deskripsi_tindakan_terapi }}</td>
                            <td>{{ $kt->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $kt->kategoriKlinis->nama_kategori_klinis ?? '-' }}</td>
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
                <p>Total data: {{ $kodeTindakan->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemilik - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    @include('components.navbar')

    <div class="data-container">
        <div class="data-header">
            <h2>Data Pemilik Hewan</h2>
            <a href="#" class="btn-add">+ Tambah Pemilik</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Pemilik</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Jumlah Hewan</th>
                        <th>Daftar Hewan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemilik as $p)
                        <tr>
                            <td>{{ $p->idpemilik }}</td>
                            <td><span class="badge">{{ $p->user->nama ?? '-' }}</span></td>
                            <td>{{ $p->alamat ?? '-' }}</td>
                            <td>{{ $p->no_wa ?? '-' }}</td>
                            <td>{{ $p->pet->count() }}</td>
                            <td>
                                @if ($p->pet->count() > 0)
                                    <ul>
                                        @foreach ($p->pet as $hewan)
                                            <li>{{ $hewan->nama }} ({{ $hewan->rasHewan->nama_ras ?? '-' }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <em>Tidak ada hewan</em>
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
                <p>Total Pemilik: {{ $pemilik->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>

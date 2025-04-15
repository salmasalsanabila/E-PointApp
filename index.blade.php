<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="{{ route('admin.dashboard') }}">Menu Utama</a> <br>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <br><br>

    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>

    <br><br>

    <!-- Form pencarian -->
    <form action="" method="GET">
        <label>Cari :</label>
        <input type="text" name="cari" value="{{ request()->get('cari') }}">
        <input type="submit" value="Cari">
    </form>

    <br><br>
    <a href="{{ route('akun.create') }}">Tambah User</a>

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
<!--Tabel Data User-->
<table border="1" cellpadding="10"cellspacing="0">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->usertype }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('akun.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <!-- Tombol Hapus -->
                        @if ($user->usertype == 'Siswa')
                            <form onsubmit="return confirm('Jika Akun Siswa dihapus, maka Data Siswa akan terhapus. Apakah Anda yakin?');" action="{{ route('akun.destroy', $user->id) }}" method="POST" style="display: inline;">
                        @else
                            <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');" action="{{ route('akun.destroy', $user->id) }}" method="POST" style="display: inline;">
                        @endif
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    <!-- Pagination -->
    {{ $users->links() }}
    
</body>
</html>
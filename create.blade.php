<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Akun</title>
</head>
<body>
    <h1>Register</h1>
    <br><br>

    <a href="{{ route('akun.index') }}">Kembali</a>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulir untuk membuat akun baru -->
    <form action="{{ route('akun.store') }}" method="POST">
        @csrf <!-- Ini untuk menambahkan token CSRF yang diperlukan oleh Laravel -->
        
        <br><br>
        <label>Nama Lengkap</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required><br>

        <br>
        <label>Email Address</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required><br>

        <br>
        <label>Password</label><br>
        <input type="password" id="password" name="password" required><br>

        <br>
        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label><br>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required><br>
        
        <br>

        <label>Hak Akses</label><br>
        <select name="usertype" required>
            <option value="">Pilih Hak Akses</option>
            <option value="Admin">Admin</option>
            <option value="PTK">PTK</option>
        </select>
        <br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
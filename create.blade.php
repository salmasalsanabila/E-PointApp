<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
</head>
<body>
    <h1>Tambah Siswa</h1>
    <br>
    <a href="{{ route('siswa.index') }}">Kembali</a>
    <br>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>Akun Siswa</h2>
    <label>Nama Lengkap</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}">
    <br><br>
    <label>Email Address</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}">
    <br><br>
    <label>Password</label>
    <input type="password" name="password" id="password">
    <br><br>

    <label for="password_confirmatiom" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
    <div class="col-md-6">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
    <br><br>

    <h2>Data Siswa</h2>
    <label>Foto Siswa</label>
    <input type="file" name="image" accept="image/*" required>
    <br><br>

    <label>Nis Siswa</label>
    <input type="text" name="nis" value="{{ old('nis') }}" required>
    <br><br>

    <label>Tingkatan</label>
    <select name="tingkatan" required>
        <option value="">Pilih Tingkatan</option>
        <option value="X">X</option>
        <option value="XI">XI</option>
        <option value="XII">XII</option>
    </select>
    <br><br>
    <label>Jurusan</label>
    <select name="jurusan" required>
        <option value="">Pilih Jurusan</option>
        <option value="TBSM">TBSM</option>
        <option value="TJKT">TJKT</option>
        <option value="PPLG">PPLG</option>
        <option value="DKV">DKV</option>
        <option value="TOI">TOI</option>
    </select>
    <br><br>
    
    <label>Kelas</label>
    <select name="kelas" required>
        <option value="">Pilih Kelas</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <br><br>

    <label>No Hp</label>
    <input type="text" name="hp" value="{{ old('hp') }}" required>
    <br><br>

    <button type="submit">SIMPAN DATA</button>
    <button type="reset">RESET DATA</button>
    </form>
</body>
</html>
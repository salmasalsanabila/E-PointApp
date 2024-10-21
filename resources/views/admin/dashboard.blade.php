<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <a href="{{ route('siswa.index') }}" class="nav-link">Data Siswa</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    <form action="{{ route('logout') }}" id="logout-form" method="POST">
        @csrf 
    </form>
    <h1>Dashboard Admin</h1>
    @if($message = Session::get('success'))
    <p>{{$message}}</p>
    @else
    <p>Kamu Telah Login</p>
    @endif
</body>
</html>
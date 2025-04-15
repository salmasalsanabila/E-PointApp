@extends ('auth.layouts')

@section ('content')
<h1>Daftar</h1>
<br>
<a href="{{ route('login') }}">Login</a>
<br>
<form action="{{ route('store') }}" method="post">
    @csrf
    <label>Nama Lengkap</label>
    <input type="text" name="name" id="name" value="{{ old('name')}}">
    @if ($errors->first('name'))
    <span class="text-danger">{{$errors->first('name')}}</span>
    @endif
    <br>

    <label>Email Address</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}">
    @if ($errors->first('email'))
    <span class="text-danger">{{$errors->first('email')}}</span>
    @endif
    <br>

    <label>Password</label>
    <input type="password" name="password" id="password">
    @if ($errors->first('password'))
    <span class="text-danger">{{$errors->first('password')}}</span>
    @endif
    <br>

    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
    <div class="col-md-6">
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
    </div>
    <input type="submit" value="Register">
</form>
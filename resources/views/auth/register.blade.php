@extends('layout')

@section('content')
    <h3>Register</h3>
    <form method="POST" action="/register">
        @csrf
        <p>Nama: <input type="text" name="name"></p>
        <p>Email: <input type="email" name="email"></p>
        <p>Password: <input type="password" name="password"></p>
        <p>Konfirmasi Password: <input type="password" name="password_confirmation"></p>
        <button type="submit">Daftar</button>
    </form>
@endsection

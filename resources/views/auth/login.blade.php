@extends('layout')

@section('content')
    <h3>Login</h3>
    <form method="POST" action="/login">
        @csrf
        <p>Email: <input type="email" name="email"></p>
        <p>Password: <input type="password" name="password"></p>
        <button type="submit">Login</button>
    </form>
@endsection

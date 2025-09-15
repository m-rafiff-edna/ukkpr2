@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Tambah User (Petugas/Pengunjung)</h2>
    <form action="{{ route('admin.tambah_user.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="petugas">Petugas</option>
                <option value="pengunjung">Pengunjung</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah User</button>
    </form>
</div>
@endsection

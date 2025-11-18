@extends('layout')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Kelola Pengguna</h2>
        <button onclick="showAdd()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Pengguna</button>
    </div>
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    <table class="min-w-full bg-white shadow rounded mb-8">
        <thead>
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Role</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">{{ ucfirst($user->role) }}</td>
                <td class="border px-4 py-2">
                    <button onclick="showEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Tambah User -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Tambah Pengguna</h3>
            <form action="{{ route('admin.tambah_user.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Nama</label>
                    <input type="text" name="name" class="w-full border px-2 py-1 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" class="w-full border px-2 py-1 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Role</label>
                    <select name="role" class="w-full border px-2 py-1 rounded" required>
                        <option value="petugas">Petugas</option>
                        <option value="pengunjung">Pengunjung</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Password</label>
                    <input type="password" name="password" class="w-full border px-2 py-1 rounded" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="hideAdd()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Edit Pengguna</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-3">
                    <label class="block mb-1">Nama</label>
                    <input type="text" name="name" id="edit_name" class="w-full border px-2 py-1 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" class="w-full border px-2 py-1 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Role</label>
                    <select name="role" id="edit_role" class="w-full border px-2 py-1 rounded">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="pengunjung">Pengunjung</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Password (kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" id="edit_password" class="w-full border px-2 py-1 rounded">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="hideEdit()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function showAdd() {
    document.getElementById('addModal').classList.remove('hidden');
}
function hideAdd() {
    document.getElementById('addModal').classList.add('hidden');
}
function showEdit(id, name, email, role) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    document.getElementById('edit_password').value = '';
    document.getElementById('editForm').action = '/admin/user/' + id;
    document.getElementById('editModal').classList.remove('hidden');
}
function hideEdit() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection

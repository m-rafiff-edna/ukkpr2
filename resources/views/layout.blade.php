<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Ruang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    <nav class="bg-white dark:bg-gray-800 shadow mb-6">
        <div class="max-w-4xl mx-auto px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <span class="font-bold text-lg text-blue-700 dark:text-blue-300">Sistem Peminjaman Ruang</span>
            </div>
            <div class="mt-2 sm:mt-0 flex flex-wrap gap-2 items-center">
                @auth
                    <span class="text-sm">Halo, <b>{{ auth()->user()->name }}</b> ({{ auth()->user()->role }})</span>
                    <a href="{{ route('home') }}" class="hover:underline">Home</a>
                    <a href="/jadwal" class="hover:underline">Jadwal</a>
                    @if(auth()->user()->role !== 'admin')
                        <a href="/peminjaman" class="hover:underline">Ajukan Pinjam</a>
                    @endif
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                        <a href="/ruang" class="hover:underline">Kelola Ruang</a>
                        <a href="/peminjaman/manage" class="hover:underline">Kelola Peminjaman</a>
                    @endif
                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('admin.tambah_user.create') }}" class="hover:underline">Tambah User</a>
                    @endif
                    <a href="{{ route('logout') }}" class="hover:underline text-red-500">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    <a href="/register" class="hover:underline">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4">
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>

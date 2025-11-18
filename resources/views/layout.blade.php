<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Ruang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-down': 'slideDown 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>
    <style>
        @keyframes gradientBg {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientBg 15s ease infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-white text-gray-800">
    <!-- Sidebar (desktop) and topbar (mobile) -->
    @if (! View::hasSection('hideSidebar'))
    <aside class="fixed inset-y-0 left-0 w-64 bg-blue-500 shadow-lg z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-200 sidebar-mobile">
        <div class="h-full overflow-y-auto px-4 py-6">
            <div class="flex items-center mb-6">
                <span class="text-xl font-bold text-white">Peminjaman Ruang</span>
            </div>

            @auth
            <div class="mb-6">
                <div class="flex items-center space-x-3">
                    <span class="h-10 w-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-white font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <div>
                        <div class="font-medium text-white">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-blue-100">{{ auth()->user()->role }}</div>
                    </div>
                </div>
            </div>
            @endauth

            <nav class="space-y-1">
                @auth
                <a href="{{ route('home') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-600 hover:text-white">
                    <svg class="h-5 w-5 mr-3 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.75z" />
                    </svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('peminjaman.jadwal') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-600 hover:text-white">
                    <svg class="h-5 w-5 mr-3 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Jadwal</span>
                </a>
                @endauth


                @if(auth()->user() && auth()->user()->role !== 'admin')
                    <a href="{{ route('peminjaman.create') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-600 hover:text-white">
                        <svg class="h-5 w-5 mr-3 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Ajukan Pinjam</span>
                    </a>
                @endif

                @if(auth()->user() && (auth()->user()->role == 'admin' || auth()->user()->role == 'petugas'))
                    <a href="{{ url('/ruang') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-600 hover:text-white">
                        <svg class="h-5 w-5 mr-3 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V8a2 2 0 012-2h3V3h6v3h3a2 2 0 012 2v13" />
                        </svg>
                        <span>Kelola Ruang</span>
                    </a>
                    <a href="{{ route('peminjaman.manage') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-600 hover:text-white">
                        <svg class="h-5 w-5 mr-3 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                        </svg>
                        <span>Kelola Peminjaman</span>
                    </a>
                @endif

                @if(auth()->user() && auth()->user()->role == 'admin')
                    <a href="{{ route('admin.tambah_user.create') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-600 hover:text-white">
                        <svg class="h-5 w-5 mr-3 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9a3 3 0 11-6 0 3 3 0 016 0zM6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                        </svg>
                        <span>Tambah User</span>
                    </a>
                @endif

                @auth
                    <a href="{{ route('logout') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-red-600">
                        <svg class="h-5 w-5 mr-3 text-red-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
                        </svg>
                        <span>Logout</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-600">
                        <svg class="h-5 w-5 mr-3 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m12 0l-4-4m4 4l-4 4M21 12v6a2 2 0 01-2 2H7" />
                        </svg>
                        <span>Login</span>
                    </a>
                    <a href="/register" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-blue-500 bg-white hover:bg-blue-50">
                        <svg class="h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                        <span>Register</span>
                    </a>
                @endauth
            </nav>
        </div>
    </aside>
    @endif


    <!-- Topbar for mobile with toggle -->
    <div class="fixed top-0 left-0 right-0 z-40 md:hidden bg-white shadow">
        <div class="flex items-center justify-between h-16 px-4">
            <button type="button" class="sidebar-toggle inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-expanded="false">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <span class="text-lg font-semibold">Peminjaman Ruang</span>
            <div></div>
        </div>
    </div>
    <!-- End Sidebar/Topbar -->

    <!-- Main Content -->
    @if(View::hasSection('hideSidebar'))
    <div class="min-h-screen">
    @else
    <div class="md:pl-64 pt-16 min-h-screen">
    @endif
        <!-- Notifications -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-lg bg-green-50 p-4 animate-fade-in">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-lg bg-red-50 p-4 animate-fade-in">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <script>
        // Sidebar toggle for mobile
        document.querySelectorAll('.sidebar-toggle').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelector('.sidebar-mobile').classList.toggle('-translate-x-full');
            });
        });
        // Ensure sidebar is visible on large screens
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.querySelector('.sidebar-mobile').classList.remove('-translate-x-full');
            } else {
                document.querySelector('.sidebar-mobile').classList.add('-translate-x-full');
            }
        });
        // initialize state
        if (window.innerWidth < 768) {
            document.querySelector('.sidebar-mobile').classList.add('-translate-x-full');
        }
    </script>
</body>
</html>


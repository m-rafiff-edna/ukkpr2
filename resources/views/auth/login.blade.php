@extends('layout')

@section('hideSidebar', true)

@section('content')
<div class="min-h-screen bg-gray-100 bg-white py-12 px-2 sm:px-4 lg:px-6 flex items-center justify-center">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-gray-900">
                Selamat Datang Di Peminjaman Ruang 
            </h2>
            <p class="mt-2 text-sm text-gray-600 text-gray-500">
                Silakan login untuk melanjutkan
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white bg-gray-50 py-8 px-4 shadow-xl rounded-lg sm:px-5 transform transition-all hover:scale-[1.01]">
            <form method="POST" action="/login" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 text-gray-600">
                        Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100 text-gray-900 transition-colors duration-200"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 text-gray-600">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm placeholder-gray-400
                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100 text-gray-900 transition-colors duration-200"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white 
                        bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-[1.02] transition-all duration-200">
                        Login
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-sm text-center">
                    <p class="text-gray-600 text-gray-500">
                        Belum punya akun?
                        <a href="/register" class="font-medium text-blue-600 hover:text-blue-500 text-blue-600 hover:text-blue-600">
                            Daftar disini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


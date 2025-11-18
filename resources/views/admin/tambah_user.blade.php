@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-gray-900">
                Tambah Pengguna Baru
            </h2>
            <p class="mt-2 text-sm text-gray-600 text-gray-500">
                Buat akun baru untuk petugas atau pengunjung
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white bg-gray-50 shadow-xl rounded-lg overflow-hidden transform transition-all hover:scale-[1.01]">
            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.tambah_user.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 text-gray-600">
                            Nama Lengkap
                        </label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm 
                                placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                                bg-gray-100 text-gray-900 transition-colors duration-200"
                                placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 text-gray-600">
                            Alamat Email
                        </label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm 
                                placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                                bg-gray-100 text-gray-900 transition-colors duration-200"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 text-gray-600">
                            Password
                        </label>
                        <div class="mt-1">
                            <input type="password" name="password" id="password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm 
                                placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                                bg-gray-100 text-gray-900 transition-colors duration-200"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 text-gray-600">
                            Tipe Pengguna
                        </label>
                        <div class="mt-1">
                            <select name="role" id="role" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 border-gray-300
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md
                                bg-gray-100 text-gray-900 transition-colors duration-200">
                                <option value="petugas">Petugas</option>
                                <option value="pengunjung">Pengunjung</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                            text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                            transform hover:scale-[1.02] transition-all duration-200">
                            Tambah Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


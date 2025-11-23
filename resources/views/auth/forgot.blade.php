@extends('layout')

@section('hideSidebar', true)
@section('content')
<div class="min-h-screen bg-gray-100 py-12 flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Reset Password</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Kirim Link Reset Password</button>
        </form>
    </div>
</div>
@endsection

@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 text-gray-900 sm:text-5xl">
                @if(auth()->user()->role === 'admin')
                    Dashboard Admin Peminjaman Ruangan
                @else
                    Riwayat Peminjaman Saya
                @endif
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 text-gray-500 sm:mt-4">
                @if(auth()->user()->role === 'admin')
                    Lihat semua pengajuan peminjaman dari petugas dan pengunjung.
                @else
                    Daftar dan status seluruh peminjaman ruangan yang Anda ajukan.
                @endif
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="mb-12">
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="px-4 py-5 bg-white bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6 transform transition-all hover:scale-[1.02]">
                    <dt class="text-sm font-medium text-gray-500 text-gray-500 truncate">
                        Total Peminjaman
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 text-gray-900">
                        {{ count($peminjaman) }}
                    </dd>
                </div>

                <div class="px-4 py-5 bg-white bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6 transform transition-all hover:scale-[1.02]">
                    <dt class="text-sm font-medium text-gray-500 text-gray-500 truncate">
                        Peminjaman Aktif
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-green-600 text-green-600">
                        {{ $peminjaman->where('status', 'disetujui')->count() }}
                    </dd>
                </div>

                <div class="px-4 py-5 bg-white bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6 transform transition-all hover:scale-[1.02]">
                    <dt class="text-sm font-medium text-gray-500 text-gray-500 truncate">
                        Menunggu Persetujuan
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-yellow-600 dark:text-yellow-400">
                        {{ $peminjaman->where('status', 'pending')->count() }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Booking List -->
        <div class="bg-white bg-gray-50 shadow-xl rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-gray-900">
                    @if(auth()->user()->role === 'admin')
                        Semua Peminjaman
                    @else
                        Peminjaman Saya
                    @endif
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 text-gray-500">
                    @if(auth()->user()->role === 'admin')
                        Seluruh data peminjaman ruangan yang diajukan oleh pengguna.
                    @else
                        Riwayat lengkap peminjaman ruangan yang Anda ajukan.
                    @endif
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 divide-gray-200">
                    <thead class="bg-gray-50 bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Ruang
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Jam
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Peminjam
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white bg-gray-50 divide-y divide-gray-200 divide-gray-200">
                        @foreach($peminjaman as $p)
                        <tr class="hover:bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-gray-900">
                                {{ $p->ruang->nama_ruang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-gray-600">
                                {{ $p->tanggal }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-gray-600">
                                {{ $p->jam_mulai }} - {{ $p->jam_selesai }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-gray-600">
                                {{ $p->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($p->status == 'pending') 
                                        bg-yellow-100 text-yellow-800 bg-yellow-100 text-yellow-700
                                    @elseif($p->status == 'disetujui')
                                        bg-green-100 text-green-800 bg-green-100 text-green-700
                                    @else
                                        bg-red-100 text-red-800 bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 flex justify-center space-x-4">
            @if(!(auth()->check() && auth()->user()->role == 'admin'))
            <a href="/peminjaman/create" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white 
                bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                transform hover:scale-[1.02] transition-all duration-200">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Ajukan Peminjaman
            </a>
            @endif

            <a href="/peminjaman/jadwal" 
                class="inline-flex items-center px-6 py-3 border border-gray-300 border-gray-300 text-base font-medium rounded-md 
                text-gray-700 text-gray-700 bg-white bg-gray-50 hover:bg-gray-50 hover:bg-gray-100
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                transform hover:scale-[1.02] transition-all duration-200">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Lihat Jadwal
            </a>
        </div>
    </div>
</div>
@endsection


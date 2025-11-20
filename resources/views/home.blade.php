@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="mb-8 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-white text-blue-600 h-16 w-16 rounded-full flex items-center justify-center font-bold text-2xl shadow">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h1>
                    <p class="mt-1 text-blue-100">
                        @if(auth()->user()->role === 'admin')
                            Dashboard Admin - Kelola semua peminjaman ruangan.
                        @elseif(auth()->user()->role === 'petugas')
                            Dashboard Admin - Kelola semua peminjaman ruangan.
                        @else
                            Statistik Peminjaman Saya
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 text-gray-900 sm:text-5xl">
                @if(auth()->user()->role === 'admin')
                    Dashboard Admin Peminjaman Ruangan
                @elseif(auth()->user()->role === 'petugas')
                    Dashboard Admin Peminjaman Ruangan
                @else
                    Statistik Peminjaman Saya
                @endif
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 text-gray-500 sm:mt-4">
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                    Lihat semua pengajuan peminjaman dari petugas dan pengunjung.
                @else
                    Ringkasan statistik peminjaman ruangan yang Anda ajukan.
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

        <!-- Daftar Ruang yang Tersedia (Only for petugas and pengunjung) -->
        @if(auth()->user()->role !== 'admin')
        <div class="mb-12 bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Daftar Ruangan
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Ruangan yang tersedia untuk dipinjam
                </p>
            </div>
            
            <div class="p-6">
                @if($ruangList->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Belum ada ruangan yang terdaftar</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($ruangList as $ruang)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $ruang->nama_ruang }}</h4>
                                    <p class="mt-1 text-sm text-gray-500">Kapasitas: {{ $ruang->kapasitas }} orang</p>
                                    @if($ruang->fasilitas)
                                    <div class="mt-2">
                                        <p class="text-xs font-medium text-gray-700">Fasilitas:</p>
                                        <p class="text-xs text-gray-600">{{ $ruang->fasilitas }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($ruang->status === 'tersedia') bg-green-100 text-green-800
                                        @elseif($ruang->status === 'tidak_tersedia') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $ruang->status)) }}
                                    </span>
                                </div>
                            </div>
                            @if($ruang->lokasi)
                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $ruang->lokasi }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @endif

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
                            <td class="px-6 py-4 text-sm">
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
                                @if($p->status == 'ditolak' && $p->alasan_penolakan)
                                <div class="mt-2 text-xs text-red-600">
                                    <span class="font-semibold">Alasan:</span> {{ $p->alasan_penolakan }}
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Informasi Pembatalan Peminjaman -->
        @if(auth()->user()->role !== 'admin')
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800">Ingin Membatalkan Peminjaman Ruang?</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Hubungi admin/petugas melalui WhatsApp untuk membatalkan peminjaman Anda:</p>
                        <a href="https://wa.me/6288232024968" target="_blank" 
                            class="inline-flex items-center mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-200">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Hubungi via WhatsApp: 0882-3202-4968
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

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


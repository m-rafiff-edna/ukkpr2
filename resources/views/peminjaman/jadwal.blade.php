@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="text-left">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    Jadwal Peminjaman Ruangan
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Daftar seluruh jadwal peminjaman ruangan yang telah diajukan
                </p>
            </div>
            <div class="text-right">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'petugas']))
                    <a href="{{ route('peminjaman.jadwal.report') }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700">
                        Generate Laporan
                    </a>
                @endif
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Ruang
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jam
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Peminjam
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($jadwal as $j)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 
                            @if($j->status == 'pending') bg-yellow-50 dark:bg-yellow-900/20 
                            @elseif($j->status == 'disetujui') bg-green-50 dark:bg-green-900/20 
                            @endif">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $j->ruang->nama_ruang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $j->tanggal }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $j->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($j->status == 'pending') 
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($j->status == 'disetujui')
                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @else
                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @endif">
                                        @if($j->status == 'pending')
                                            Menunggu
                                        @elseif($j->status == 'disetujui')
                                            Disetujui
                                        @else
                                            Ditolak
                                        @endif
                                    </span>

                                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'petugas']))
                                        <form method="POST" action="/peminjaman/{{ $j->id }}" class="inline-block" 
                                            onsubmit="return confirm('Yakin hapus jadwal peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 
                                                    transition-colors duration-200"
                                                title="Hapus jadwal">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

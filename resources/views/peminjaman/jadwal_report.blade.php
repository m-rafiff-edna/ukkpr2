@extends('layout')

@section('hideSidebar', true)

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900 py-8 px-6">
    <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Jadwal Peminjaman Ruangan</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Dicetak: {{ now()->format('d F Y H:i') }}</p>
            </div>
            <div class="space-x-2">
                <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded-md">Cetak</button>
                <a href="{{ route('peminjaman.jadwal') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-md">Kembali</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruang</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($jadwal as $j)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $j->ruang->nama_ruang }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">{{ $j->tanggal }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">{{ $j->user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">{{ $j->keperluan }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($j->status == 'pending')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Menunggu</span>
                                @elseif($j->status == 'disetujui')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Disetujui</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="text-xs text-gray-500 dark:text-gray-400 mt-6">Total: {{ $jadwal->count() }} entri</p>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .max-w-5xl, .max-w-5xl * { visibility: visible; }
        .max-w-5xl { position: absolute; left: 0; top: 0; width: 100%; }
        a { text-decoration: none; }
    }
</style>

@endsection

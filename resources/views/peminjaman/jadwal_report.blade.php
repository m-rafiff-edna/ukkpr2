@extends('layout')

@section('hideSidebar', true)

@section('content')
<div class="min-h-screen bg-white bg-white py-8 px-6">
    <div class="max-w-5xl mx-auto bg-white bg-gray-50 p-6 rounded-lg shadow">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 text-gray-900">Laporan Jadwal Peminjaman Ruangan</h1>
                <p class="text-sm text-gray-600 text-gray-600 mt-1">Dicetak: {{ now()->format('d F Y H:i') }}</p>
            </div>
            <div class="space-x-2">
                <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded-md">Cetak</button>
                <a href="{{ route('peminjaman.jadwal') }}" class="px-4 py-2 bg-gray-200 bg-gray-100 text-gray-800 text-gray-800 rounded-md">Kembali</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 divide-gray-200">
                <thead class="bg-gray-50 bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruang</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Mengajukan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Mulai Digunakan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white bg-gray-50 divide-y divide-gray-200 divide-gray-200">
                    @foreach($jadwal as $j)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900 text-gray-900">{{ $j->ruang->nama_ruang }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 text-gray-600">{{ $j->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 text-gray-600">{{ $j->jam_mulai }} ({{ $j->tanggal }})</td>
                            <td class="px-4 py-2 text-sm text-gray-500 text-gray-600">{{ $j->tanggal }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 text-gray-600">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 text-gray-600">{{ $j->user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500 text-gray-600">{{ $j->keperluan }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($j->status == 'pending')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 bg-yellow-100 text-yellow-700">Menunggu</span>
                                @elseif($j->status == 'disetujui')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 bg-green-100 text-green-700">Disetujui</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 bg-red-100 text-red-700">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="text-xs text-gray-500 text-gray-500 mt-6">Total: {{ $jadwal->count() }} entri</p>
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


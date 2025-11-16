@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                Peminjaman Ruangan
            </h2>
            <p class="mt-3 text-lg text-gray-500 dark:text-gray-400">
                Silakan isi form berikut untuk mengajukan peminjaman ruangan
            </p>
            <!-- Information Alert -->
            <div class="mt-4 mx-auto max-w-3xl">
                <div class="rounded-lg bg-blue-50 dark:bg-blue-900/50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 dark:text-blue-200">
                                Harap perhatikan: Terdapat jeda waktu 1 jam antara setiap peminjaman untuk persiapan dan perpindahan jadwal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form Column -->
            <div class="lg:col-span-2">
                <!-- Main Card -->
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden transform transition-all hover:scale-[1.01]">
                    <!-- Date Filter Section -->
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Cek Ketersediaan Ruangan</h3>
                        <form method="GET" action="{{ route('peminjaman.create') }}" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-white mb-2">Pilih Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                                        class="w-full px-4 py-2 rounded-lg border-0 focus:ring-2 focus:ring-white bg-opacity-50 bg-white backdrop-blur-lg text-white placeholder-white::placeholder transition-all duration-200"
                                        required>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit"
                                        class="w-full sm:w-auto px-6 py-2 rounded-lg bg-white text-blue-600 font-semibold hover:bg-opacity-90 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                                        Cek Ketersediaan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Booking Form -->
                    <div class="p-6">
                        <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Room Selection -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Ruangan</label>
                                <div class="relative">
                                    <select name="ruang_id" 
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm transition-all duration-200" 
                                        required>
                                        <option value="">-- Pilih Ruangan --</option>
                                        @foreach($ruangList as $r)
                                            <option value="{{ $r->id }}" 
                                                {{ request('ruang_id') == $r->id ? 'selected' : '' }}>
                                                {{ $r->nama_ruang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Date Selection -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Peminjaman</label>
                                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm transition-all duration-200"
                                    required />
                            </div>

                            <!-- Time Selection -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Mulai</label>
                                    <input type="time" name="jam_mulai"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm transition-all duration-200"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Selesai</label>
                                    <input type="time" name="jam_selesai"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm transition-all duration-200"
                                        required />
                                </div>
                            </div>

                            <!-- Purpose -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keperluan Peminjaman</label>
                                <textarea name="keperluan" rows="4"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm transition-all duration-200"
                                    placeholder="Jelaskan keperluan peminjaman ruangan..."
                                    required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold hover:from-blue-600 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg">
                                    Ajukan Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Schedule Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4">
                        <h3 class="text-lg font-semibold text-white">Jadwal Reguler</h3>
                        @if($selectedRuang)
                            <p class="mt-1 text-sm text-white opacity-90">
                                Jadwal Ruangan: {{ $selectedRuang->nama_ruang }}
                            </p>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Jadwal Mingguan</h4>
                            <div class="overflow-x-auto">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                                <tr>
                                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider sm:pl-6">
                                                        Waktu
                                                    </th>
                                                    @foreach($daysOfWeek as $day)
                                                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            {{ $day }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                                                @foreach($timeSlots as $timeSlot)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-6">
                                                            {{ $timeSlot }}
                                                        </td>
                                                        @foreach($daysOfWeek as $day)
                                                            <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                                @if(isset($regularSchedule[$day][$timeSlot]))
                                                                    @foreach($regularSchedule[$day][$timeSlot] as $booking)
                                                                        <div class="mb-2 last:mb-0">
                                                                            <div class="flex items-center space-x-2">
                                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                                    @if($booking['status'] === 'pending')
                                                                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                                                    @else
                                                                                        bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                                                    @endif">
                                                                                    {{ $booking['ruang'] }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="mt-1 text-xs">
                                                                                <p class="font-medium">{{ $booking['user'] }}</p>
                                                                                <p class="text-gray-400 dark:text-gray-500 truncate" title="{{ $booking['keperluan'] }}">
                                                                                    {{ \Illuminate\Support\Str::limit($booking['keperluan'], 30) }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                                        Tersedia
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daily Schedule -->
                        @if(request('tanggal'))
                            <div class="mt-6">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                    Jadwal {{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}
                                    @if($selectedRuang)
                                        - {{ $selectedRuang->nama_ruang }}
                                    @endif
                                </h4>
                                <div class="space-y-4">
                                    @forelse($bookedTimeSlots as $timeSlot => $booking)
                                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $timeSlot }}</span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($booking['status'] === 'pending')
                                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @else
                                                        bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @endif">
                                                    {{ $booking['status'] === 'pending' ? 'Menunggu Persetujuan' : 'Disetujui' }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        <p class="font-medium text-gray-900 dark:text-gray-100">Peminjam</p>
                                                        <p>{{ $booking['user'] }}</p>
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        <p class="font-medium text-gray-900 dark:text-gray-100">Ruangan</p>
                                                        <p>{{ $booking['ruang'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Keperluan</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking['keperluan'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium">Tidak ada peminjaman</h3>
                                            <p class="mt-1 text-sm">Semua slot waktu tersedia untuk peminjaman</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        
                        <!-- Daily Schedule -->
                        @if(request('tanggal') && request('ruang_id'))
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">
                                    Jadwal Hari Ini ({{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }})
                                </h4>
                                <div class="space-y-2">
                                    @forelse($bookedTimeSlots as $timeSlot => $booking)
                                        <div class="p-2 rounded-lg border border-gray-200 dark:border-gray-700">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $timeSlot }}</span>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        {{ $booking['keperluan'] }}
                                                    </p>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                    @if($booking['status'] === 'pending')
                                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @else
                                                        bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @endif">
                                                    {{ $booking['user'] }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-2">
                                            Tidak ada peminjaman untuk hari ini
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                        @endif

                        <!-- Schedule Legend -->
                        <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Keterangan:</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <span class="inline-block w-4 h-4 rounded-full bg-green-400 mr-2"></span>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Tersedia</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="inline-block w-4 h-4 rounded-full bg-red-400 mr-2"></span>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Terisi</span>
                                </div>
                            </div>
                            
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mt-4 mb-2">Informasi Waktu:</h4>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Jam istirahat: 12:00 - 13:00
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Jeda antar sesi: 1 jam
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Maksimal 2 jam per peminjaman
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="mt-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4">
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Tips Peminjaman:</h4>
                    <ul class="space-y-2 text-sm text-blue-600 dark:text-blue-300">
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Periksa jadwal reguler terlebih dahulu
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sediakan waktu untuk persiapan dan beres-beres
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Konfirmasi ketersediaan sebelum mengajukan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

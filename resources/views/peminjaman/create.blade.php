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
                                Ajukan peminjaman langsung tanpa perlu cek ketersediaan terlebih dahulu. Admin akan memproses pengajuan Anda.
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
                    <!-- Header Section -->
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Ajukan Peminjaman Ruangan</h3>
                        <p class="text-sm text-white opacity-90">Pilih ruangan dan tanggal untuk melihat ketersediaan secara otomatis</p>
                    </div>

                    <!-- Booking Form -->
                    <div class="p-6">
                        <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Room Selection -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Ruangan</label>
                                <div class="relative">
                                    <select name="ruang_id" id="ruang_id"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm transition-all duration-200" 
                                        required onchange="checkAvailability()">
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
                                <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm transition-all duration-200"
                                    required onchange="checkAvailability()" />
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
                        <h3 class="text-lg font-semibold text-white">Ruang Sedang Dipakai</h3>
                        <p class="mt-1 text-sm text-white opacity-90" id="selected-info">
                            @if($selectedRuang && request('tanggal'))
                                {{ $selectedRuang->nama_ruang }} - {{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}
                            @else
                                Pilih ruangan dan tanggal
                            @endif
                        </p>
                    </div>
                    <div class="p-4" id="schedule-container">
                        <!-- Initial Schedule Display -->
                        @if($selectedRuang && request('tanggal'))
                            <div class="space-y-4">
                                @forelse($ruangSchedule as $timeSlot => $booking)
                                    <div class="rounded-lg border border-red-200 dark:border-red-700 p-4 bg-red-50 dark:bg-red-900/20">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $timeSlot }}</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($booking['status'] === 'pending')
                                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else
                                                    bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @endif">
                                                {{ $booking['status'] === 'pending' ? 'Menunggu' : 'Disetujui' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-300"><span class="font-medium">Peminjam:</span> {{ $booking['user'] }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1"><span class="font-medium">Keperluan:</span> {{ \Illuminate\Support\Str::limit($booking['keperluan'], 40) }}</p>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">Ruang Tersedia</h3>
                                        <p class="mt-1 text-sm">Tidak ada peminjaman pada hari ini</p>
                                    </div>
                                @endforelse
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium">Pilih Ruangan & Tanggal</h3>
                                <p class="mt-1 text-sm">Untuk melihat ketersediaan</p>
                            </div>
                        @endif

                        <!-- Time Slots Info -->
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Jam Operasional:</h4>
                            <div class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                                <div class="flex items-center">
                                    <span class="inline-block w-2 h-2 rounded-full bg-green-400 mr-2"></span>
                                    <span>08:00 - 17:00</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="inline-block w-2 h-2 rounded-full bg-gray-400 mr-2"></span>
                                    <span>Istirahat: 12:00 - 13:00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="mt-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3 border border-blue-200 dark:border-blue-800">
                            <p class="text-xs text-blue-700 dark:text-blue-200">
                                <span class="font-medium">📌 Info:</span> Ajukan peminjaman langsung tanpa perlu cek ketersediaan terlebih dahulu.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkAvailability() {
    const ruangId = document.getElementById('ruang_id').value;
    const tanggal = document.getElementById('tanggal').value;
    
    if (!ruangId || !tanggal) {
        return;
    }
    
    // Update URL and reload to fetch new schedule
    const url = new URL(window.location.href);
    url.searchParams.set('ruang_id', ruangId);
    url.searchParams.set('tanggal', tanggal);
    window.location.href = url.toString();
}

// Auto-load schedule when page loads with parameters
document.addEventListener('DOMContentLoaded', function() {
    const ruangSelect = document.getElementById('ruang_id');
    const tanggalInput = document.getElementById('tanggal');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    tanggalInput.setAttribute('min', today);
    
    // If both are selected, ensure they match URL params
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('ruang_id')) {
        ruangSelect.value = urlParams.get('ruang_id');
    }
    if (urlParams.get('tanggal')) {
        tanggalInput.value = urlParams.get('tanggal');
    }
});
</script>
@endsection

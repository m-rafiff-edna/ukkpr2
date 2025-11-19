@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-gray-900">
                Kelola Peminjaman
            </h2>
            <p class="mt-2 text-sm text-gray-600 text-gray-500">
                Daftar peminjaman yang menunggu persetujuan
            </p>
        </div>

        <!-- Table Card -->
        <div class="bg-white bg-gray-50 shadow-xl rounded-lg overflow-hidden">
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
                                Keperluan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Aksi
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
                            <td class="px-6 py-4 text-sm text-gray-500 text-gray-600">
                                <p class="max-w-xs overflow-hidden text-ellipsis">{{ $p->keperluan }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 flex items-center">
                                <form method="POST" action="/peminjaman/{{ $p->id }}/approve">
                                    @csrf
                                    <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                        text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                                        dark:bg-green-500 dark:hover:bg-green-600 transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Setujui
                                    </button>
                                </form>

                                <button type="button" onclick="showRejectModal({{ $p->id }})"
                                    class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                    text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500
                                    dark:bg-yellow-500 dark:hover:bg-yellow-600 transition-colors duration-200">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>

                                <form method="POST" action="/peminjaman/{{ $p->id }}" 
                                    onsubmit="return confirm('Yakin hapus booking ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium 
                                        text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                        dark:bg-red-500 dark:hover:bg-red-600 transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak Peminjaman -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tolak Peminjaman</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        Tolak Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(id) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/peminjaman/${id}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    document.getElementById('alasan_penolakan').value = '';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection


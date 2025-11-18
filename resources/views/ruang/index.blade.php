@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-gray-900">
                Kelola Ruangan
            </h2>
            <p class="mt-2 text-sm text-gray-600 text-gray-500">
                Tambah dan kelola ruangan yang tersedia untuk peminjaman
            </p>
        </div>

        <!-- Add Room Form Card -->
        <div class="bg-white bg-gray-50 shadow-xl rounded-lg overflow-hidden mb-8 transform transition-all hover:scale-[1.01]">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 text-gray-900 mb-4">Tambah Ruangan Baru</h3>
                <form method="POST" action="/ruang" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <!-- Nama Ruang Field -->
                        <div>
                            <label for="nama_ruang" class="block text-sm font-medium text-gray-700 text-gray-600 mb-1">
                                Nama Ruang
                            </label>
                            <input type="text" name="nama_ruang" id="nama_ruang" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm 
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100 text-gray-900 
                                transition-colors duration-200"
                                placeholder="Contoh: Ruang Rapat A">
                        </div>

                        <!-- Deskripsi Field -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 text-gray-600 mb-1">
                                Deskripsi
                            </label>
                            <input type="text" name="deskripsi" id="deskripsi" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm 
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100 text-gray-900 
                                transition-colors duration-200"
                                placeholder="Deskripsi singkat ruangan">
                        </div>

                        <!-- Kapasitas Field -->
                        <div>
                            <label for="kapasitas" class="block text-sm font-medium text-gray-700 text-gray-600 mb-1">
                                Kapasitas
                            </label>
                            <input type="number" name="kapasitas" id="kapasitas" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 border-gray-300 rounded-md shadow-sm 
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100 text-gray-900 
                                transition-colors duration-200"
                                placeholder="Jumlah orang">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" 
                            class="w-full sm:w-auto px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white 
                            bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                            transform hover:scale-[1.02] transition-all duration-200">
                            Tambah Ruangan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Room List Card -->
        <div class="bg-white bg-gray-50 shadow-xl rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 divide-gray-200">
                    <thead class="bg-gray-50 bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Nama Ruang
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Kapasitas
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white bg-gray-50 divide-y divide-gray-200 divide-gray-200">
                        @foreach($ruang as $r)
                        <tr class="hover:bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-gray-900">
                                {{ $r->nama_ruang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-gray-600">
                                {{ $r->deskripsi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 bg-blue-100 text-blue-700">
                                    {{ $r->kapasitas }} Orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-gray-600">
                                <div class="flex items-center gap-3">
                                    <button onclick="openEditModal({{ $r->id }}, '{{ $r->nama_ruang }}', '{{ $r->deskripsi }}', {{ $r->kapasitas }})" 
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200 flex items-center gap-1">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </button>
                                    <form method="POST" action="/ruang/{{ $r->id }}" 
                                        onsubmit="return confirm('Yakin hapus ruang ini? Semua booking juga akan terhapus!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200 flex items-center gap-1">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
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

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Ruangan</h3>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_nama_ruang" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Ruang
                    </label>
                    <input type="text" name="nama_ruang" id="edit_nama_ruang" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi
                    </label>
                    <input type="text" name="deskripsi" id="edit_deskripsi" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_kapasitas" class="block text-sm font-medium text-gray-700 mb-1">
                        Kapasitas
                    </label>
                    <input type="number" name="kapasitas" id="edit_kapasitas" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(id, nama, deskripsi, kapasitas) {
    document.getElementById('editForm').action = '/ruang/' + id;
    document.getElementById('edit_nama_ruang').value = nama;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_kapasitas').value = kapasitas;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endsection


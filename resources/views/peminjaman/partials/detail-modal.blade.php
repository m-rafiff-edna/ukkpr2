<!-- Detail Sliding Panel -->
<div id="detailModal" class="fixed inset-0 z-50 hidden">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeModal()"></div>

    <!-- Sliding panel -->
    <div class="fixed inset-y-0 right-0 w-full max-w-lg bg-white bg-gray-50 shadow-xl transform transition-transform duration-300 translate-x-full" 
         id="slidePanel">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 text-gray-900">
                Detail Peminjaman
            </h3>
            <button onclick="closeModal()" class="p-2 text-gray-400 hover:text-gray-500 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="h-full overflow-y-auto px-6 py-4">
            <div class="space-y-6">
                        <div class="mt-4 space-y-4">
                            <!-- User Info -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 text-gray-500">Informasi Peminjam</h4>
                                <p class="mt-1 text-sm text-gray-900 text-gray-900" id="userName"></p>
                                <p class="text-sm text-gray-500 text-gray-500" id="userEmail"></p>
                            </div>

                            <!-- Booking Info -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 text-gray-500">Informasi Ruangan</h4>
                                <p class="mt-1 text-sm text-gray-900 text-gray-900" id="roomName"></p>
                                <div class="mt-1">
                                    <span class="text-sm text-gray-500 text-gray-500">Tanggal: </span>
                                    <span class="text-sm text-gray-900 text-gray-900" id="bookingDate"></span>
                                </div>
                                <div class="mt-1">
                                    <span class="text-sm text-gray-500 text-gray-500">Jam: </span>
                                    <span class="text-sm text-gray-900 text-gray-900" id="bookingTime"></span>
                                </div>
                                <div class="mt-1">
                                    <span class="text-sm text-gray-500 text-gray-500">Keperluan: </span>
                                    <span class="text-sm text-gray-900 text-gray-900" id="bookingPurpose"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('layout')

@section('content')
<div class="max-w-lg mx-auto mt-8 p-6 rounded-lg shadow-lg bg-white dark:bg-gray-800">
    <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Ajukan Peminjaman</h3>

    {{-- Filter tanggal dulu --}}
    <form method="GET" action="/peminjaman" class="mb-6 space-y-2">
        <label class="block mb-1 text-gray-700 dark:text-gray-200">Pilih Tanggal:</label>
        <div class="flex gap-2">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                class="flex-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
            <button type="submit"
                class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
                Cek
            </button>
        </div>
    </form>

    {{-- Form ajukan peminjaman --}}
    <form method="POST" action="/peminjaman" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-200">Pilih Ruang:</label>
            <select name="ruang_id" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
                @foreach($ruang as $r)
                    @php
                        $isBooked = isset($booked) && in_array($r->id, $booked);
                    @endphp
                    <option value="{{ $r->id }}" 
                        @if($isBooked) disabled class="bg-gray-300 dark:bg-gray-600 text-gray-400" @endif>
                        {{ $r->nama_ruang }} 
                        @if($isBooked) (Sudah dibooking) @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-200">Tanggal:</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required />
        </div>

        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block mb-1 text-gray-700 dark:text-gray-200">Jam Mulai:</label>
                <input type="time" name="jam_mulai"
                    class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required />
            </div>
            <div class="flex-1">
                <label class="block mb-1 text-gray-700 dark:text-gray-200">Jam Selesai:</label>
                <input type="time" name="jam_selesai"
                    class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required />
            </div>
        </div>

        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-200">Keperluan:</label>
            <textarea name="keperluan"
                class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required></textarea>
        </div>

        <button type="submit"
            class="w-full py-2 px-4 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
            Ajukan
        </button>
    </form>
</div>
@endsection

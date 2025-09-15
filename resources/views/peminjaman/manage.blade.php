@extends('layout')

@section('content')
    <h3>Kelola Peminjaman (Menunggu Persetujuan)</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Ruang</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Peminjam</th>
            <th>Keperluan</th>
            <th>Aksi</th>
        </tr>
        @foreach($peminjaman as $p)
        <tr>
            <td>{{ $p->ruang->nama_ruang }}</td>
            <td>{{ $p->tanggal }}</td>
            <td>{{ $p->jam_mulai }} - {{ $p->jam_selesai }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->keperluan }}</td>
            <td>
                <form method="POST" action="/peminjaman/{{ $p->id }}/approve" style="display:inline">
                    @csrf
                    <button type="submit">Setujui</button>
                </form>
                <form method="POST" action="/peminjaman/{{ $p->id }}/reject" style="display:inline">
                    @csrf
                    <button type="submit">Tolak</button>
                </form>
                <form method="POST" action="/peminjaman/{{ $p->id }}" style="display:inline" onsubmit="return confirm('Yakin hapus booking ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection

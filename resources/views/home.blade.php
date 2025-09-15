@extends('layout')

@section('content')
    <h3>Daftar Peminjaman</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Ruang</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Peminjam</th>
            <th>Status</th>
        </tr>
        @foreach($peminjaman as $p)
        <tr>
            <td>{{ $p->ruang->nama_ruang }}</td>
            <td>{{ $p->tanggal }}</td>
            <td>{{ $p->jam_mulai }} - {{ $p->jam_selesai }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->status }}</td>
        </tr>
        @endforeach
    </table>
@endsection

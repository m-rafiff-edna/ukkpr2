@extends('layout')

@section('content')
    <h3>Jadwal Peminjaman</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Ruang</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Peminjam</th>
            <th>Status</th>
        </tr>
        @foreach($jadwal as $j)
        <tr @if($j->status == 'pending' || $j->status == 'disetujui') style="background:#ffe0e0" @endif>
            <td>{{ $j->ruang->nama_ruang }}</td>
            <td>{{ $j->tanggal }}</td>
            <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
            <td>{{ $j->user->name }}</td>
            <td>
                @if($j->status == 'pending')
                    <span style="color:orange">Menunggu</span>
                @elseif($j->status == 'disetujui')
                    <span style="color:green">Disetujui</span>
                @else
                    <span style="color:red">Ditolak</span>
                @endif
                @if(auth()->check() && auth()->user()->role == 'admin')
                    <form method="POST" action="/peminjaman/{{ $j->id }}" style="display:inline" onsubmit="return confirm('Yakin hapus booking ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
@endsection

@extends('layout')

@section('content')
    <h3>Kelola Ruang</h3>

    <form method="POST" action="/ruang">
        @csrf
        <p>Nama Ruang: <input type="text" name="nama_ruang"></p>
        <p>Deskripsi: <input type="text" name="deskripsi"></p>
        <p>Kapasitas: <input type="number" name="kapasitas"></p>
        <button type="submit">Tambah Ruang</button>
    </form>

    <hr>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nama Ruang</th>
            <th>Deskripsi</th>
            <th>Kapasitas</th>
        </tr>
        @foreach($ruang as $r)
        <tr>
            <td>{{ $r->nama_ruang }}</td>
            <td>{{ $r->deskripsi }}</td>
            <td>{{ $r->kapasitas }}</td>
            <td>
                <form method="POST" action="/ruang/{{ $r->id }}" onsubmit="return confirm('Yakin hapus ruang ini? Semua booking juga akan terhapus!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection

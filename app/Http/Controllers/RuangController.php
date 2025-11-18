<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function destroy($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();
        return back()->with('success', 'Ruang berhasil dihapus');
    }
    public function index()
    {
        $ruang = Ruang::all();
        return view('ruang.index', compact('ruang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required',
            'deskripsi' => 'nullable',
            'kapasitas' => 'required|integer',
        ]);

        Ruang::create($request->all());

        return back()->with('success', 'Ruang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruang' => 'required',
            'deskripsi' => 'nullable',
            'kapasitas' => 'required|integer',
        ]);

        $ruang = Ruang::findOrFail($id);
        $ruang->update($request->all());

        return back()->with('success', 'Ruang berhasil diperbarui');
    }
}

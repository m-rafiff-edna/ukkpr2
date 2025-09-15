<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('ruang', 'user')->latest()->get();
        return view('home', compact('peminjaman'));
    }

    public function create(Request $request)
    {
        // Cegah admin mengajukan peminjaman
        if (auth()->user()->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat mengajukan peminjaman ruang!');
        }
        $ruang = Ruang::all();

        // Ambil semua ruang yang sudah dipinjam di tanggal yang dipilih (jika ada input tanggal)
        $booked = [];
        if ($request->has('tanggal')) {
            $booked = Peminjaman::where('tanggal', $request->tanggal)
                ->whereIn('status', ['pending', 'disetujui'])
                ->pluck('ruang_id')
                ->toArray();
        }

        return view('peminjaman.create', compact('ruang', 'booked'));
    }

    public function store(Request $request)
    {
        // Cegah admin mengajukan peminjaman
        if (auth()->user()->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat mengajukan peminjaman ruang!');
        }
        $request->validate([
            'ruang_id' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keperluan' => 'required',
        ]);

        // Cek apakah ruang sudah dibooking pada waktu yang sama dan statusnya belum selesai
        $bentrok = Peminjaman::where('ruang_id', $request->ruang_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function($q) use ($request) {
                $q->where(function($q2) use ($request) {
                    $q2->where('jam_mulai', '<', $request->jam_selesai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                });
            })
            ->exists();
        if ($bentrok) {
            return back()->with('error', 'Ruang sudah dibooking pada waktu tersebut!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'ruang_id' => $request->ruang_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keperluan' => $request->keperluan,
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', 'Pengajuan peminjaman berhasil dibuat!');
    }

    public function jadwal()
    {
        $jadwal = Peminjaman::with('ruang', 'user')->get();
        return view('peminjaman.jadwal', compact('jadwal'));
    }

    public function manage()
    {
        $peminjaman = Peminjaman::with('ruang', 'user')->where('status', 'pending')->get();
        return view('peminjaman.manage', compact('peminjaman'));
    }

    public function approve($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update(['status' => 'disetujui']);
        return back()->with('success', 'Peminjaman disetujui');
    }

    public function reject($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update(['status' => 'ditolak']);
        return back()->with('success', 'Peminjaman ditolak');
    }

    public function destroy($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->delete();
        return back()->with('success', 'Booking berhasil dihapus');
    }
}

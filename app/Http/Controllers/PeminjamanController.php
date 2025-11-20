<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Ruang;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,petugas')->only(['manage', 'approve', 'reject']);
    }

    private $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    private $timeSlots = [
        '08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00', 
        '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00'
    ];

    private function generateWeeklySchedule($ruang)
    {
        $schedule = [];
        foreach ($this->daysOfWeek as $day) {
            $schedule[$day] = [];
            foreach ($this->timeSlots as $timeSlot) {
                $schedule[$day][$timeSlot] = [
                    'available' => true,
                    'booking' => null
                ];
            }
        }

        // Get all bookings for this room for the current week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        $bookings = Peminjaman::where('ruang_id', $ruang->id)
            ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->get();

        // Mark booked slots
        foreach ($bookings as $booking) {
            $day = date('l', strtotime($booking->tanggal));
            $dayIndo = $this->getDayInIndonesian($day);
            
            $timeSlot = $booking->jam_mulai . '-' . $booking->jam_selesai;
            if (isset($schedule[$dayIndo][$timeSlot])) {
                $schedule[$dayIndo][$timeSlot] = [
                    'available' => false,
                    'booking' => $booking
                ];
            }
        }

        return $schedule;
    }

    private function getDayInIndonesian($englishDay)
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        return $days[$englishDay] ?? $englishDay;
    }
    public function index()
    {
        // Admin melihat semua peminjaman, selain admin hanya melihat miliknya sendiri
        if (auth()->user()->role === 'admin') {
            $peminjaman = Peminjaman::with('ruang', 'user')->latest()->get();
        } else {
            $peminjaman = Peminjaman::with('ruang', 'user')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        }
        
        // Ambil semua ruang untuk ditampilkan di dashboard
        $ruangList = Ruang::all();
        
        return view('home', compact('peminjaman', 'ruangList'));
    }

    public function create(Request $request)
    {
        // Cegah admin mengajukan peminjaman
        if (auth()->user()->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat mengajukan peminjaman ruang!');
        }

        $ruangList = Ruang::all();
        $selectedRuang = null;
        $ruangSchedule = [];

        // Get bookings for specific date and room if selected
        if ($request->has('tanggal') && $request->has('ruang_id')) {
            $selectedRuang = Ruang::find($request->ruang_id);
            
            $query = Peminjaman::with(['ruang', 'user'])
                ->where('tanggal', $request->tanggal)
                ->where('ruang_id', $request->ruang_id)
                ->whereIn('status', ['pending', 'disetujui']);

            $bookings = $query->get();
            
            foreach ($bookings as $booking) {
                $startTime = strtotime($booking->jam_mulai);
                $endTime = strtotime($booking->jam_selesai);
                
                while ($startTime < $endTime) {
                    $timeSlot = date('H:i', $startTime) . '-' . date('H:i', strtotime('+1 hour', $startTime));
                    $ruangSchedule[$timeSlot] = [
                        'ruang' => $booking->ruang->nama_ruang,
                        'status' => $booking->status,
                        'user' => $booking->user->name,
                        'keperluan' => $booking->keperluan
                    ];
                    $startTime = strtotime('+1 hour', $startTime);
                }
            }
        }

        return view('peminjaman.create', [
            'ruangList' => $ruangList,
            'selectedRuang' => $selectedRuang,
            'ruangSchedule' => $ruangSchedule,
            'timeSlots' => $this->timeSlots,
            'daysOfWeek' => $this->daysOfWeek,
        ]);
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

        // Validasi jam peminjaman (08:00 - 17:00) dan format hanya jam penuh
        $allowedStart = '08:00';
        $allowedEnd = '17:00';
        $start = $request->jam_mulai;
        $end = $request->jam_selesai;

        // Pastikan menit adalah 00
        if (!preg_match('/^\d{2}:00$/', $start) || !preg_match('/^\d{2}:00$/', $end)) {
            return back()->withInput()->with('error', 'Gunakan hanya jam penuh (contoh 09:00, 13:00).');
        }

        if ($start < $allowedStart || $start > $allowedEnd || $end < $allowedStart || $end > $allowedEnd) {
            return back()->withInput()->with('error', 'Jam peminjaman harus di antara 08:00 - 17:00.');
        }
        if ($start >= $end) {
            return back()->withInput()->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'ruang_id' => $request->ruang_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keperluan' => $request->keperluan,
            'status' => 'pending',
        ]);

        // Kirim notifikasi ke semua admin dan petugas
        $ruang = Ruang::find($request->ruang_id);
        $adminPetugas = User::whereIn('role', ['admin', 'petugas'])->get();
        
        foreach ($adminPetugas as $user) {
            Notification::create([
                'user_id' => $user->id,
                'peminjaman_id' => $peminjaman->id,
                'type' => 'new_booking',
                'title' => 'Pengajuan Peminjaman Baru',
                'message' => Auth::user()->name . ' mengajukan peminjaman ruang ' . $ruang->nama_ruang . ' pada tanggal ' . date('d/m/Y', strtotime($request->tanggal)) . ' jam ' . $request->jam_mulai . '-' . $request->jam_selesai,
                'is_read' => false,
            ]);
        }

        return redirect()->route('home')->with('success', 'Pengajuan peminjaman berhasil dibuat!');
    }

    public function jadwal(Request $request)
    {
        $query = Peminjaman::with('ruang', 'user');

        // Filter tanggal (format YYYY-MM-DD)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter nama ruang (partial match)
        if ($request->filled('nama_ruang')) {
            $query->whereHas('ruang', function($q) use ($request) {
                $q->where('nama_ruang', 'like', '%'.$request->nama_ruang.'%');
            });
        }

        // Filter nama peminjam (user name)
        if ($request->filled('nama_peminjam')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->nama_peminjam.'%');
            });
        }

        $jadwal = $query->orderBy('tanggal', 'desc')->orderBy('jam_mulai')->get();
        return view('peminjaman.jadwal', compact('jadwal'));
    }

    public function report()
    {
        // server-side role check: only admin and petugas can generate report
        if (! auth()->check() || ! in_array(auth()->user()->role, ['admin', 'petugas'])) {
            abort(403);
        }

        $jadwal = Peminjaman::with('ruang', 'user')->get();
        return view('peminjaman.jadwal_report', compact('jadwal'));
    }

    public function manage()
    {
        $peminjaman = Peminjaman::with('ruang', 'user')
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('peminjaman.manage', compact('peminjaman'));
    }

    public function approve($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update(['status' => 'disetujui']);
        
        // Buat notifikasi untuk user
        Notification::create([
            'user_id' => $pinjam->user_id,
            'peminjaman_id' => $pinjam->id,
            'type' => 'approved',
            'title' => 'Peminjaman Disetujui',
            'message' => 'Peminjaman ruang ' . $pinjam->ruang->nama_ruang . ' pada tanggal ' . date('d/m/Y', strtotime($pinjam->tanggal)) . ' telah disetujui.',
            'is_read' => false,
        ]);
        
        return back()->with('success', 'Peminjaman disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ]);

        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);
        
        // Buat notifikasi untuk user
        Notification::create([
            'user_id' => $pinjam->user_id,
            'peminjaman_id' => $pinjam->id,
            'type' => 'rejected',
            'title' => 'Peminjaman Ditolak',
            'message' => 'Peminjaman ruang ' . $pinjam->ruang->nama_ruang . ' pada tanggal ' . date('d/m/Y', strtotime($pinjam->tanggal)) . ' ditolak. Alasan: ' . $request->alasan_penolakan,
            'is_read' => false,
        ]);
        
        return back()->with('success', 'Peminjaman ditolak');
    }

    public function detail($id)
    {
        $peminjaman = Peminjaman::with(['ruang', 'user'])
            ->findOrFail($id);
        return response()->json($peminjaman);
    }

    public function destroy($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->delete();
        return back()->with('success', 'Booking berhasil dihapus');
    }
}

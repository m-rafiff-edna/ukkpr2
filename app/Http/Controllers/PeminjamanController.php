<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Ruang;
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
        $peminjaman = Peminjaman::with('ruang', 'user')->latest()->get();
        return view('home', compact('peminjaman'));
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

        $peminjaman = Peminjaman::create([
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
            ->where('status', '!=', 'disetujui')
            ->latest()
            ->get();
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

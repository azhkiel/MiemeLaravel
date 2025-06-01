<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function showAttendanceForm()
    {
        $mejas = Meja::all();
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('attendance_date', now('Asia/Jakarta')->toDateString())
            ->first();

        $history = Attendance::with('user')->where('user_id', Auth::id())
            ->orderByDesc('attendance_date')
            ->limit(10)
            ->get();

        return view('dashboard.staff.dashboard', compact('attendance', 'history','mejas'));
    }

    public function storeAttendance(Request $request)
    {
        $now = now('Asia/Jakarta');
        $currentTime = $now->format('H:i');

        // Blokir absen sebelum jam 07:00 WIB
        if ($currentTime < '07:00') {
            return redirect()->route('staff.dashboard')->with('error', 'Absensi hanya bisa dilakukan setelah jam 07:00 WIB.');
        }

        $validated = $request->validate([
            'shift' => 'required|in:Pagi,Siang,Sore',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $shiftDeadlines = [
            'Pagi' => '07:00',
            'Siang' => '14:00',
            'Sore' => '18:00',
        ];

        $status = $currentTime <= $shiftDeadlines[$validated['shift']] ? 'present' : 'late';

        if ($request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('attendance_images', 'public');
        } else {
            return redirect()->route('staff.dashboard')->with('error', 'Upload gambar gagal.');
        }

        // Cek sudah absen masuk dan pulang
        $existing = Attendance::where('user_id', Auth::id())
            ->whereDate('attendance_date', $now->toDateString())
            ->first();

        if ($existing) {
            if ($existing->checkout_time) {
                return redirect()->route('staff.dashboard')->with('error', 'Kamu sudah absen masuk dan pulang hari ini.');
            }

            return redirect()->route('staff.dashboard')->with('error', 'Kamu sudah absen masuk untuk hari ini.');
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'shift' => $validated['shift'],
            'status' => $status,
            'attendance_date' => $now->toDateString(),
            'attendance_time' => $now->format('H:i:s'),
            'image' => $imagePath,
        ]);

        return redirect()->route('staff.dashboard')->with('success', "Absensi $status untuk shift {$validated['shift']} berhasil dicatat.");
    }

    public function checkoutAttendance(Request $request)
    {
        $now = now('Asia/Jakarta');

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('attendance_date', $now->toDateString())
            ->first();

        if (!$attendance) {
            return redirect()->route('staff.dashboard')->with('error', 'Kamu belum absen masuk hari ini.');
        }

        if ($attendance->checkout_time) {
            return redirect()->route('staff.dashboard')->with('error', 'Kamu sudah absen pulang hari ini.');
        }

        $start = \Carbon\Carbon::parse($attendance->attendance_time);
        $end = \Carbon\Carbon::parse($now->format('H:i:s'));

        $diffHours = $end->diffInMinutes($start) / 60; // Durasi kerja dalam jam (desimal)
        $gajiPerJam = 10000;
        $gajiHarian = round($diffHours * $gajiPerJam);

        $checkoutPath = $request->file('image')->store('checkout_images', 'public');

        $attendance->update([
            'checkout_time' => $now->format('H:i:s'),
            'checkout_image' => $checkoutPath,
            'duration' => round($diffHours, 2), // Simpan durasi kerja (misalnya: 7.5 jam)
            'salary' => $gajiHarian,
        ]);

        return redirect()->route('staff.dashboard')->with('success', "Absen pulang berhasil dicatat. Durasi kerja: " . round($diffHours, 2) . " jam. Gaji hari ini: Rp " . number_format($gajiHarian, 0, ',', '.'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function showAttendanceForm()
    {
        $today = now('Asia/Jakarta')->toDateString();

        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('attendance_date', $today)
            ->first();

        $history = Attendance::where('user_id', Auth::id())
            ->orderByDesc('attendance_date')
            ->limit(10)
            ->get();

        return view('dashboard.staff.dashboard', compact('attendance', 'history'));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'shift' => 'required|in:Pagi,Siang,Sore',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $now = now('Asia/Jakarta');
        $time = $now->format('H:i');
        $shift = $validated['shift'];

        $shiftDeadlines = [
            'Pagi' => '07:00',
            'Siang' => '14:00',
            'Sore' => '18:00',
        ];

        $status = $time <= $shiftDeadlines[$shift] ? 'present' : 'late';

        $imagePath = $request->file('image')->store('attendance_images', 'public');

        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('attendance_date', $now->toDateString())
            ->where('shift', $shift)
            ->first();

        if ($attendance) {
            return redirect()->route('staff.dashboard')->with('error', "You have already submitted attendance for shift $shift today.");
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'shift' => $shift,
            'status' => $status,
            'attendance_date' => $now->toDateString(),
            'attendance_time' => $now->format('H:i:s'),
            'image' => $imagePath,
        ]);

        return redirect()->route('staff.dashboard')->with('success', ($status === 'present' ? 'Attendance recorded as Present' : 'Attendance recorded as Late') . " for shift $shift.");
    }

    public function checkoutAttendance(Request $request)
    {
        $request->validate([
            'shift' => 'required|in:Pagi,Siang,Sore',
        ]);

        $today = now('Asia/Jakarta')->toDateString();

        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('attendance_date', $today)
            ->where('shift', $request->shift)
            ->first();

        if (!$attendance) {
            return redirect()->route('staff.dashboard')->with('error', 'You have not submitted attendance for this shift.');
        }

        if ($attendance->checkout_time) {
            return redirect()->route('staff.dashboard')->with('error', 'You have already checked out.');
        }

        $attendance->update([
            'checkout_time' => now('Asia/Jakarta')->format('H:i:s'),
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Successfully checked out for shift ' . $request->shift . '.');
    }
}

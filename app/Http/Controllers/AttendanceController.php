<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function toggleAttendance()
    {
        $today = now()->toDateString();
        $now = now();
        $hour = $now->hour;

        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', $today)
            ->first();

        if ($attendance) {
            // Check-out logic
            if ($attendance->check_out === null) {
                $attendance->update(['check_out' => $now->toTimeString()]);
                return redirect()->route('dashboard')->with('success', 'Berhasil check-out.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Anda sudah melakukan check-out hari ini.');
            }
        } else {
            // Check-in logic
            if ($hour >= 7 && $hour < 17) {
                Attendance::create([
                    'user_id' => Auth::id(),
                    'date' => $today,
                    'check_in' => $now->toTimeString(),
                ]);
                return redirect()->route('dashboard')->with('success', 'Berhasil check-in.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Check-in hanya diizinkan antara pukul 07:00 dan 17:00.');
            }
        }
    }
}

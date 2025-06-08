<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $staffUsers = User::where('role', 'staff')->get();

        $statusOptions = ['present', 'late', 'absent'];
        $shiftOptions = ['morning', 'afternoon'];
        $data = [];

        foreach ($staffUsers as $user) {
            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::today()->subDays($i);
                $status = $statusOptions[array_rand($statusOptions)];
                $shift = $shiftOptions[array_rand($shiftOptions)];
                $image = 'dummy_in.jpg';
                $checkoutImage = 'dummy_out.jpg';
                $attendanceTime = null;
                $checkoutTime = null;
                $duration = null;
                $salary = null;

                // Logika hanya untuk present/late
                if ($status !== 'absent') {
                    if ($status === 'present') {
                        $attendanceTime = Carbon::createFromTime(rand(7, 8), rand(0, 59), 0);
                    } else {
                        $attendanceTime = Carbon::createFromTime(rand(9, 10), rand(0, 59), 0);
                    }

                    $checkoutTime = (clone $attendanceTime)->addHours(rand(7, 9))->addMinutes(rand(0, 30));
                    $duration = round($attendanceTime->diffInMinutes($checkoutTime) / 60, 2);
                    $salary = intval($duration * 15000); // contoh: Rp15.000 per jam
                }

                $data[] = [
                    'user_id'         => $user->id,
                    'attendance_date' => $date,
                    'status'          => $status,
                    'image'           => $status !== 'absent' ? $image : null,
                    'checkout_image'  => $status !== 'absent' ? $checkoutImage : null,
                    'shift'           => $shift,
                    'attendance_time' => $attendanceTime,
                    'checkout_time'   => $checkoutTime,
                    'duration'        => $duration,
                    'salary'          => $salary,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }
        }

        DB::table('attendance')->insert($data);
    }
}

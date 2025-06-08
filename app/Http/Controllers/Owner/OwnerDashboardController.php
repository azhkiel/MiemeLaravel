<?php
namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\Attendance;
use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // Fitur 1: Statistik Pesanan
        $totalOrdersToday = Order::whereDate('created_at', Carbon::today())->count();
        $totalIncomeToday = Order::whereDate('created_at', Carbon::today())->sum('total_price');
        $orderStatusSummary = Order::select('status', DB::raw('count(*) as jumlah'))->groupBy('status')->get();
        $orderTypeSummary = Order::select('type_pesanan', DB::raw('count(*) as jumlah'))->groupBy('type_pesanan')->get();

        // Fitur 2: Statistik Pengguna
        $userRoleCount = User::select('role', DB::raw('count(*) as jumlah'))->groupBy('role')->get();
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->get();

        // Fitur 4: Menu Terlaris
        $topMenus = OrderDetail::join('menus', 'order_details.kode_menu', '=', 'menus.kode_menu')
            ->select('menus.nama_menu', DB::raw('SUM(order_details.quantity) as total_dipesan'))
            ->groupBy('menus.nama_menu')
            ->orderByDesc('total_dipesan')
            ->limit(5)
            ->get();

        // Fitur 5: Pesanan Terbaru
        $latestOrders = Order::orderByDesc('created_at')->limit(10)->get();

        // Fitur 6: Kehadiran Hari Ini
        $todayAttendance = Attendance::whereDate('attendance_date', Carbon::today())
            ->join('users', 'attendance.user_id', '=', 'users.id')
            ->where('users.role', 'staff')
            ->select('users.fullname', 'attendance.status', 'attendance.shift', 'attendance.attendance_time')
            ->get();

        // Fitur 8: Grafik Pendapatan Mingguan
        $weeklyIncome = Order::where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_price) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();

        // Gaji Staff (tambahkan jika tabel `salaries` tersedia)
        $salaryData = DB::table('attendance')
            ->join('users', 'attendance.user_id', '=', 'users.id')
            ->whereYear('attendance.attendance_date', Carbon::now()->year)
            ->whereMonth('attendance.attendance_date', Carbon::now()->month)
            ->where('users.role', 'staff')
            ->whereNotNull('attendance.salary')
            ->select(
                'users.fullname',
                DB::raw('SUM(attendance.salary) as total_salary'),
                DB::raw('MONTH(attendance.attendance_date) as month'),
                DB::raw('YEAR(attendance.attendance_date) as year')
            )
            ->groupBy('users.id', 'users.fullname', DB::raw('MONTH(attendance.attendance_date)'), DB::raw('YEAR(attendance.attendance_date)'))
            ->get();

        return view('dashboard.owner.dashboard', compact(
            'totalOrdersToday', 'totalIncomeToday', 'orderStatusSummary', 'orderTypeSummary',
            'userRoleCount', 'newUsers', 'topMenus', 'latestOrders',
            'todayAttendance', 'weeklyIncome', 'salaryData'
        ));
    }
}

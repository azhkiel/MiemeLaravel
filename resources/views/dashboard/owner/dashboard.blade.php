@extends('layout.owner')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6" x-data="dashboardData()">
    <!-- Header -->
    <div class="mb-8 animate-fade-in">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">Dashboard Admin</h1>
        <p class="text-blue-600">Selamat datang kembali! Berikut ringkasan aktivitas hari ini.</p>
        <div class="flex items-center mt-4 text-sm text-blue-700">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
            </svg>
            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders Today -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 transform hover:scale-105 transition-transform duration-300"
             x-data="{ count: 0 }" 
             x-init="animateNumber(count, {{ $totalOrdersToday }}, 2000, (val) => count = val)">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-medium">Pesanan Hari Ini</p>
                    <p class="text-3xl font-bold text-blue-900" x-text="Math.floor(count)">0</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Income Today -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 transform hover:scale-105 transition-transform duration-300"
             x-data="{ count: 0 }" 
             x-init="animateNumber(count, {{ $totalIncomeToday }}, 2000, (val) => count = val)">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium">Pendapatan Hari Ini</p>
                    <p class="text-3xl font-bold text-green-900">Rp <span x-text="formatNumber(Math.floor(count))">0</span></p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- New Users This Week -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 transform hover:scale-105 transition-transform duration-300"
             x-data="{ count: 0 }" 
             x-init="animateNumber(count, {{ $newUsers->count() }}, 2000, (val) => count = val)">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-600 text-sm font-medium">Pengguna Baru (7 hari)</p>
                    <p class="text-3xl font-bold text-purple-900" x-text="Math.floor(count)">0</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Top Menu -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 transform hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-600 text-sm font-medium">Menu Terlaris</p>
                    <p class="text-lg font-bold text-orange-900">{{ $topMenus->first()->nama_menu ?? 'Tidak ada data' }}</p>
                    <p class="text-sm text-orange-700">{{ $topMenus->first()->total_dipesan ?? 0 }} terjual</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Order Status Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-blue-900 mb-4">Status Pesanan</h3>
            <div class="relative h-64">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>

        <!-- Weekly Income Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-blue-900 mb-4">Pendapatan Mingguan</h3>
            <div class="relative h-64">
                <canvas id="weeklyIncomeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Menus Table -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-blue-900 mb-4">Menu Terlaris</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Menu</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-100">
                        @foreach($topMenus as $menu)
                        <tr class="hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-blue-900">{{ $menu->nama_menu }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-blue-700">{{ $menu->total_dipesan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Orders -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-blue-900 mb-4">Pesanan Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-100">
                        @foreach($latestOrders->take(5) as $order)
                        <tr class="hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-blue-900">#{{ $order->id }}</td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-blue-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Staff Attendance -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-xl font-bold text-blue-900 mb-4">Kehadiran Staff Hari Ini</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($todayAttendance as $attendance)
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-blue-900">{{ $attendance->fullname }}</p>
                        <p class="text-sm text-blue-600">Shift: {{ $attendance->shift }}</p>
                        <p class="text-xs text-blue-500">{{ \Carbon\Carbon::parse($attendance->attendance_time)->format('H:i') }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        @if($attendance->status == 'present') bg-green-100 text-green-800
                        @elseif($attendance->status == 'late') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-blue-600">
                Tidak ada data kehadiran hari ini
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function dashboardData() {
    return {
        init() {
            this.initCharts();
        },
        
        animateNumber(current, target, duration, callback) {
            const start = performance.now();
            const animate = (timestamp) => {
                const elapsed = timestamp - start;
                const progress = Math.min(elapsed / duration, 1);
                const value = current + (target - current) * this.easeOutQuart(progress);
                callback(value);
                if (progress < 1) requestAnimationFrame(animate);
            };
            requestAnimationFrame(animate);
        },
        
        easeOutQuart(t) {
            return 1 - (--t) * t * t * t;
        },
        
        formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        
        initCharts() {
            // Order Status Chart
            const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(orderStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($orderStatusSummary->pluck('status')) !!},
                    datasets: [{
                        data: {!! json_encode($orderStatusSummary->pluck('jumlah')) !!},
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        duration: 2000
                    }
                }
            });

            // Weekly Income Chart
            const weeklyIncomeCtx = document.getElementById('weeklyIncomeChart').getContext('2d');
            new Chart(weeklyIncomeCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($weeklyIncome->pluck('tanggal')) !!},
                    datasets: [{
                        label: 'Pendapatan',
                        data: {!! json_encode($weeklyIncome->pluck('total')) !!},
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(59, 130, 246, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }
    }
}

// CSS Animation Classes
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
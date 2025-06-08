@extends('layout.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<!-- Enhanced Header with Gradient Background -->
<header class="bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 shadow-xl border-b border-blue-100 sticky top-0 z-20 backdrop-blur-sm animate-fade-down animate-duration-500"
        x-data="{ scrolled: false }"
        @scroll.window="scrolled = window.pageYOffset > 10"
        :class="{ 'bg-white/95 backdrop-blur-md shadow-2xl': scrolled }">
    <div class="max-w-7xl mx-auto px-4 py-6 transition-all duration-300">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
            <!-- Title Section -->
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg animate-pulse">
                    <i class="fas fa-clipboard-list text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        Daftar Pesanan Pending
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Kelola pesanan yang menunggu konfirmasi</p>
                </div>
            </div>
            
            <!-- Stats Cards -->
            @if($orders->isNotEmpty())
            <div class="flex space-x-4">
                <div class="bg-white/70 backdrop-blur-sm rounded-xl px-4 py-3 shadow-lg border border-white/50">
                    <div class="text-sm text-gray-600">Total Pesanan</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $orders->count() }}</div>
                </div>
                <div class="bg-white/70 backdrop-blur-sm rounded-xl px-4 py-3 shadow-lg border border-white/50">
                    <div class="text-sm text-gray-600">Total Nilai</div>
                    <div class="text-lg font-bold text-green-600">Rp{{ number_format($orders->sum('total_price'), 0, ',', '.') }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</header>

<!-- Main Content with Enhanced Styling -->
<main class="max-w-7xl mx-auto px-4 py-8 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30">
    @if($orders->isNotEmpty())
        <!-- Filter Bar -->
        <div class="mb-8 animate-fade-up animate-delay-200" x-data="{ filterOpen: false }">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-white/50">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-filter text-blue-500"></i>
                        <span class="font-medium text-gray-700">Filter & Urutan</span>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button class="px-4 py-2 rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200 transition-all duration-300 text-sm font-medium">
                            <i class="fas fa-clock mr-2"></i>Terbaru
                        </button>
                        <button class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-300 text-sm font-medium">
                            <i class="fas fa-sort-amount-up mr-2"></i>Nilai Tertinggi
                        </button>
                        <button class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-300 text-sm font-medium">
                            <i class="fas fa-table mr-2"></i>Meja
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Grid -->
        <div class="grid grid-cols-1 gap-8" x-data="{ updatingStatus: false }">
            @foreach($orders as $order)
                <div class="group bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 ease-out transform hover:-translate-y-2 border border-white/50 overflow-hidden animate-fade-up animate-delay-{{ $loop->index * 100 }}"
                     x-data="{ expanded: false, isHovered: false }"
                     @mouseenter="isHovered = true"
                     @mouseleave="isHovered = false">
                    
                    <!-- Gradient Header Strip -->
                    <div class="h-1.5 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 animate-gradient-x"></div>
                    
                    <div class="p-8 relative overflow-hidden">
                        <!-- Background Decoration -->
                        <div class="absolute top-0 right-0 w-32 h-32 opacity-5 transform translate-x-8 -translate-y-8">
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-400 to-purple-400"></div>
                        </div>
                        
                        <!-- Order Header -->
                        <div class="relative z-10 flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 cursor-pointer group/header"
                             @click="expanded = !expanded">
                            <div class="mb-4 lg:mb-0">
                                <!-- Order ID with Enhanced Styling -->
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center mr-4 transform transition-transform duration-300 group/header-hover:scale-110">
                                        <i class="fas fa-receipt text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                            <span class="mr-3">Pesanan {{ $order->name_order }}</span>
                                            <i class="fas fa-chevron-down text-sm text-gray-400 transform transition-all duration-500 ease-out"
                                               :class="{ 'rotate-180 text-blue-500': expanded }"></i>
                                        </h3>
                                        <div class="flex items-center text-sm text-gray-600 mt-1 space-x-4">
                                            <div class="flex items-center">
                                                <i class="far fa-clock mr-2 text-orange-500"></i>
                                                <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                            @if(isset($order->meja_id))
                                            <div class="flex items-center">
                                                <i class="fas fa-chair mr-2 text-green-500"></i>
                                                <span>Meja {{ $order->meja_id }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price & Status Section -->
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                                <!-- Total Price -->
                                <div class="text-right">
                                    <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">Total Pembayaran</div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="relative">
                                    <span class="status-badge px-5 py-3 rounded-xl text-sm font-bold shadow-xl transition-all duration-500 transform hover:scale-105 border-2
                                        @if($order->status === 'pending') 
                                            bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border-amber-300 shadow-amber-200/50
                                        @elseif($order->status === 'processed') 
                                            bg-gradient-to-r from-blue-50 to-cyan-50 text-blue-800 border-blue-300 shadow-blue-200/50
                                        @elseif($order->status === 'completed') 
                                            bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-800 border-emerald-300 shadow-emerald-200/50
                                        @elseif($order->status === 'cancelled') 
                                            bg-gradient-to-r from-red-50 to-rose-50 text-red-800 border-red-300 shadow-red-200/50
                                        @endif"
                                        data-status="{{ $order->status }}">
                                        
                                        <!-- Status Icon -->
                                        @if($order->status === 'pending')
                                            <i class="fas fa-hourglass-half mr-2 animate-pulse"></i>
                                        @elseif($order->status === 'processed')
                                            <i class="fas fa-cog mr-2 animate-spin"></i>
                                        @elseif($order->status === 'completed')
                                            <i class="fas fa-check-circle mr-2"></i>
                                        @elseif($order->status === 'cancelled')
                                            <i class="fas fa-times-circle mr-2"></i>
                                        @endif
                                        
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    
                                    <!-- Glow Effect -->
                                    <div class="absolute inset-0 rounded-xl blur-lg opacity-30 transition-opacity duration-500
                                        @if($order->status === 'pending') bg-yellow-400
                                        @elseif($order->status === 'processed') bg-blue-400
                                        @elseif($order->status === 'completed') bg-green-400
                                        @elseif($order->status === 'cancelled') bg-red-400
                                        @endif"
                                        :class="{ 'opacity-60': isHovered }"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Expandable Order Details -->
                        <div class="border-t border-gray-200 pt-6 overflow-hidden transition-all duration-700 ease-out"
                             x-ref="details"
                             x-bind:style="expanded ? 'max-height: ' + $refs.details.scrollHeight + 'px; opacity: 1' : 'max-height: 0px; opacity: 0'">
                            
                            <!-- Items Header -->
                            <div class="flex items-center mb-6">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center mr-3">
                                    <i class="fas fa-list-ul text-white text-sm"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg">Daftar Pesanan ({{ $order->orderDetails->count() }} item)</h4>
                            </div>
                            
                            <!-- Order Items -->
                            <div class="space-y-4 mb-8">
                                @foreach($order->orderDetails as $item)
                                    <div class="flex justify-between items-center p-5 rounded-2xl bg-gradient-to-r from-gray-50 to-blue-50 hover:from-blue-50 hover:to-indigo-50 transition-all duration-500 border border-gray-200 hover:border-blue-300 hover:shadow-lg transform hover:scale-[1.02] animate-fade-in animate-delay-{{ $loop->index * 100 }}"
                                         x-intersect="$el.classList.add('animate-slide-in-left')">
                                        
                                        <div class="flex items-center">
                                            <!-- Menu Image -->
                                            <div class="w-20 h-20 rounded-2xl overflow-hidden mr-5 shadow-lg ring-2 ring-white">
                                                <img src="{{ asset('storage/' . $item->menu->gambar) }}" 
                                                     alt="{{ $item->menu->nama_menu }}"
                                                     class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                                            </div>
                                            
                                            <!-- Menu Details -->
                                            <div>
                                                <span class="text-gray-800 font-bold text-lg">{{ $item->menu->nama_menu }}</span>
                                                <div class="flex items-center text-sm text-gray-600 mt-2 space-x-4">
                                                    <div class="flex items-center bg-white px-3 py-1.5 rounded-lg shadow-sm">
                                                        <i class="fas fa-times text-blue-500 mr-2"></i>
                                                        <span class="font-semibold">{{ $item->quantity }}</span>
                                                    </div>
                                                    <div class="flex items-center bg-white px-3 py-1.5 rounded-lg shadow-sm">
                                                        <i class="fas fa-tag text-green-500 mr-2"></i>
                                                        <span class="font-semibold">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Item Total -->
                                        <div class="text-right">
                                            <div class="text-xl font-bold text-gray-800">
                                                Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">Subtotal</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 animate-fade-in">
                                <a href="{{ route('order.status', $order->id) }}" 
                                   class="group flex items-center justify-center px-8 py-4 text-sm font-bold text-white bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-500 hover:from-blue-600 hover:via-purple-600 hover:to-indigo-600 rounded-xl transition-all duration-500 transform hover:scale-105 shadow-lg hover:shadow-xl hover:shadow-blue-200/50 animate-gradient-x">
                                    <i class="fas fa-edit mr-3 transition-transform duration-300 group-hover:rotate-12"></i>
                                    <span>Update Status Pesanan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Enhanced Empty State -->
        <div class="text-center py-20 animate-fade-up animate-delay-300">
            <div class="relative inline-block mb-8">
                <!-- Animated Background Circle -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full animate-pulse"></div>
                <div class="relative p-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full shadow-2xl">
                    <i class="fas fa-clipboard-list text-6xl text-blue-400 animate-bounce"></i>
                </div>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Pesanan Pending</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-8 leading-relaxed">
                Halaman ini akan menampilkan pesanan yang menunggu konfirmasi. 
                Periksa kembali secara berkala untuk memastikan tidak ada pesanan yang terlewat.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-8 py-4 rounded-xl transition-all duration-500 shadow-lg hover:shadow-xl transform hover:-translate-y-1 animate-gradient-x">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Kembali ke Dashboard
                </a>
                <button onclick="location.reload()" 
                        class="inline-flex items-center justify-center bg-white text-gray-700 font-bold px-8 py-4 rounded-xl border-2 border-gray-300 hover:border-blue-300 hover:text-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-sync-alt mr-3"></i>
                    Refresh Halaman
                </button>
            </div>
        </div>
    @endif
</main>

<!-- Custom Styles -->
<style>
@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes slide-in-left {
    0% { transform: translateX(-100%); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 3s ease infinite;
}

.animate-slide-in-left {
    animation: slide-in-left 0.6s ease-out;
}

/* Smooth scrolling enhancement */
html {
    scroll-behavior: smooth;
}

/* Custom backdrop blur for better browser support */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.backdrop-blur-md {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
</style>

@endsection
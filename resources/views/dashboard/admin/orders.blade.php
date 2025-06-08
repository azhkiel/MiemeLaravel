@extends('layout.admin')
@section('title','Dashboard - Pesanan Saya')
@section('content')
<header class="bg-white shadow-sm sticky top-0 z-10 animate-fade-down animate-duration-300">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Judul Halaman -->
        <div class="flex items-center space-x-3">
            <h1 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-history text-blue-500 mr-2"></i>
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Riwayat Pesanan
                </span>
            </h1>
        </div>

        <!-- Navigasi Kanan -->
        <div class="flex items-center space-x-4">
            <!-- Link ke Keranjang -->
            <a href="{{ route('admin.chart') }}" class="relative p-2 rounded-full hover:bg-gray-100 transition-colors duration-200 group">
                <i class="fas fa-shopping-cart text-gray-600 group-hover:text-blue-600 transition-colors"></i>
                <span class="cart-count absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full flex items-center justify-center min-w-[20px] h-5 transform scale-0 group-hover:scale-100 transition-transform duration-200 {{ $cartCount > 0 ? 'scale-100' : 'scale-0' }}">
                    {{ $cartCount }}
                </span>
            </a>

            <!-- Tombol Kembali -->
            <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2 transition-transform duration-300 group-hover:-translate-x-1"></i>
                <span>Kembali ke Menu</span>
            </a>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 py-8">
    @if($orders->isNotEmpty())
        <div class="grid grid-cols-1 gap-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-700 ease-out transform hover:-translate-y-2 animate-fade-up animate-delay-{{ $loop->index * 100 }} border border-gray-100"
                x-data="{ expanded: false, isHovered: false }"
                @mouseenter="isHovered = true"
                @mouseleave="isHovered = false">
                
                <!-- Gradient Header Strip -->
                <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 animate-gradient-x"></div>
                
                <div class="p-6 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50"></div>
                        <svg class="absolute top-0 right-0 w-32 h-32 transform translate-x-8 -translate-y-8" viewBox="0 0 100 100" fill="none">
                            <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="0.5" class="text-blue-200"/>
                            <circle cx="50" cy="50" r="25" stroke="currentColor" stroke-width="0.5" class="text-purple-200"/>
                        </svg>
                    </div>
                    
                    <!-- Header Pesanan -->
                    <div class="relative z-10 flex flex-col md:flex-row md:justify-between md:items-center mb-6 cursor-pointer group"
                        @click="expanded = !expanded">
                        <div class="mb-4 md:mb-0">
                            <!-- Order Name with Icon -->
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center mr-3 transform transition-transform duration-300 group-hover:scale-110">
                                    <i class="fas fa-receipt text-white text-sm"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                    <span class="mr-3">{{ $order->name_order }}</span>
                                    <i class="fas fa-chevron-down text-sm text-gray-400 transform transition-all duration-500 ease-out"
                                    :class="{ 'rotate-180 text-blue-500': expanded }"></i>
                                </h3>
                            </div>
                            
                            <!-- Order Details -->
                            <div class="space-y-1">
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-tag text-blue-500 mr-2 text-sm"></i>
                                    <span class="font-medium">{{ $order->type_pesanan }}</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-chair text-green-500 mr-2 text-sm"></i>
                                    <span class="font-medium">Meja {{ $order->meja_id }}</span>
                                </div>
                                <div class="flex items-center text-gray-500 text-sm mt-2">
                                    <i class="far fa-clock mr-2 text-orange-500"></i>
                                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price and Status -->
                        <div class="flex flex-col items-end space-y-3">
                            <!-- Total Price -->
                            <div class="text-right">
                                <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-pulse">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500">Total Pembayaran</div>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="relative">
                                <span class="status-badge px-4 py-2 rounded-full text-sm font-semibold shadow-lg transition-all duration-500 transform hover:scale-105 border-2
                                    @if($order->status === 'pending') 
                                        bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border-amber-200 shadow-amber-200/50
                                    @elseif($order->status === 'processed') 
                                        bg-gradient-to-r from-blue-50 to-cyan-50 text-blue-800 border-blue-200 shadow-blue-200/50
                                    @elseif($order->status === 'completed') 
                                        bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-800 border-emerald-200 shadow-emerald-200/50
                                    @elseif($order->status === 'cancelled') 
                                        bg-gradient-to-r from-red-50 to-rose-50 text-red-800 border-red-200 shadow-red-200/50
                                    @endif"
                                    data-status="{{ $order->status }}"
                                    data-order-id="{{ $order->id }}"
                                    x-intersect="$el.classList.add('animate-bounce-in')">
                                    
                                    <!-- Status Icon -->
                                    @if($order->status === 'pending')
                                        <i class="fas fa-hourglass-half mr-2 animate-spin-slow"></i>
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
                                <div class="absolute inset-0 rounded-full blur-lg opacity-30 transition-opacity duration-500
                                    @if($order->status === 'pending') bg-yellow-400
                                    @elseif($order->status === 'processed') bg-blue-400
                                    @elseif($order->status === 'completed') bg-green-400
                                    @elseif($order->status === 'cancelled') bg-red-400
                                    @endif"
                                    :class="{ 'opacity-60': isHovered }"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Expandable Content -->
                    <div class="border-t border-gray-200 pt-6 overflow-hidden transition-all duration-700 ease-out"
                        x-ref="details"
                        x-bind:style="expanded ? 'max-height: ' + $refs.details.scrollHeight + 'px; opacity: 1' : 'max-height: 0px; opacity: 0'">
                        
                        <!-- Section Header -->
                        <div class="flex items-center mb-4">
                            <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center mr-3">
                                <i class="fas fa-list-ul text-white text-xs"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg">Daftar Pesanan</h4>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($order->orderDetails as $item)
                                <div class="flex justify-between items-center p-4 rounded-xl bg-gradient-to-r from-gray-50 to-blue-50 hover:from-blue-50 hover:to-indigo-50 transition-all duration-500 border border-gray-200 hover:border-blue-300 hover:shadow-md transform hover:scale-[1.02] animate-fade-in animate-delay-{{ $loop->index * 100 }}"
                                    x-intersect="$el.classList.add('animate-slide-in-left')">
                                    
                                    <div class="flex items-center">
                                        <!-- Menu Image -->
                                        <div class="w-16 h-16 rounded-xl overflow-hidden mr-4 shadow-lg ring-2 ring-white">
                                            <img src="{{ asset('storage/' . $item->menu->gambar) }}" 
                                                alt="{{ $item->menu->nama_menu }}"
                                                class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                                        </div>
                                        
                                        <!-- Menu Details -->
                                        <div>
                                            <span class="text-gray-800 font-bold text-lg">{{ $item->menu->nama_menu }}</span>
                                            <div class="flex items-center text-sm text-gray-600 mt-2 space-x-4">
                                                <div class="flex items-center bg-white px-2 py-1 rounded-lg shadow-sm">
                                                    <i class="fas fa-times text-blue-500 mr-1"></i>
                                                    <span class="font-semibold">{{ $item->quantity }}</span>
                                                </div>
                                                <div class="flex items-center bg-white px-2 py-1 rounded-lg shadow-sm">
                                                    <i class="fas fa-at text-green-500 mr-1"></i>
                                                    <span class="font-semibold">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Item Total -->
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-gray-800">
                                            Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-500">Subtotal</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Action Buttons (if pending) -->
                        @if($order->status === 'pending')
                            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4 border-t border-gray-200 animate-fade-in">
                                <button class="group flex items-center justify-center px-6 py-3 text-sm font-bold text-red-600 hover:text-white border-2 border-red-500 rounded-xl hover:bg-red-500 transition-all duration-500 transform hover:scale-105 hover:shadow-lg hover:shadow-red-200/50">
                                    <i class="fas fa-times-circle mr-2 transition-transform duration-300 group-hover:rotate-180"></i>
                                    <span>Batalkan Pesanan</span>
                                </button>
                                
                                <button class="group flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 hover:from-blue-600 hover:via-purple-600 hover:to-pink-600 rounded-xl transition-all duration-500 transform hover:scale-105 shadow-lg hover:shadow-xl hover:shadow-purple-200/50 animate-gradient-x">
                                    <i class="fas fa-headset mr-2 transition-transform duration-300 group-hover:bounce"></i>
                                    <span>Hubungi Kami</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Tampilan jika tidak ada pesanan -->
        <div class="text-center py-16 animate-fade-in">
            <div class="inline-block p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full mb-6 animate-bounce animate-duration-2000 animate-iteration-count-3">
                <i class="fas fa-shopping-cart text-5xl text-blue-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-800 mb-3">Belum ada riwayat pesanan</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-8">
                Pesanan Anda akan muncul di sini setelah melakukan pembelian. Mari mulai berbelanja!
            </p>
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium px-8 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-utensils mr-2"></i>
                Jelajahi Menu
            </a>
        </div>
    @endif
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        simulateStatusUpdates();
        
        // Initialize tooltips
        tippy('[data-tippy-content]', {
            animation: 'scale-subtle',
            theme: 'light-border',
            arrow: true,
            duration: [200, 200]
        });
    });
</script>

<style>
    @keyframes confetti {
        0% { transform: translateY(0) rotate(0deg); }
        100% { transform: translateY(100vh) translateX(var(--random-x)) rotate(var(--random-rotate))); }
    }
    .animate-confetti {
        animation: confetti linear forwards;
    }
    @keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes bounce-in {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes slide-in-left {
    0% { transform: translateX(-100%); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 3s ease infinite;
}

.animate-bounce-in {
    animation: bounce-in 0.6s ease-out;
}

.animate-slide-in-left {
    animation: slide-in-left 0.6s ease-out;
}

.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}
</style>
@endpush
@endsection
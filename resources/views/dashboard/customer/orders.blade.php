@extends('layout.dash')
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
            <a href="{{ route('customer.chart') }}" class="relative p-2 rounded-full hover:bg-gray-100 transition-colors duration-200 group">
                <i class="fas fa-shopping-cart text-gray-600 group-hover:text-blue-600 transition-colors"></i>
                <span class="cart-count absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full flex items-center justify-center min-w-[20px] h-5 transform scale-0 group-hover:scale-100 transition-transform duration-200 {{ $cartCount > 0 ? 'scale-100' : 'scale-0' }}">
                    {{ $cartCount }}
                </span>
            </a>

            <!-- Tombol Kembali -->
            <a href="{{ route('customer.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
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
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-500 animate-fade-up animate-delay-{{ $loop->index * 50 }}"
                     x-data="{ expanded: false }">
                    <div class="p-6">
                        <!-- Header Pesanan -->
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 cursor-pointer"
                             @click="expanded = !expanded">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                                    <span class="mr-2">Pesanan #{{ $order->id }}</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-400 transform transition-transform duration-300"
                                       :class="{ 'rotate-180': expanded }"></i>
                                </h3>
                                <p class="text-sm text-gray-500 flex items-center mt-1">
                                    <i class="far fa-clock mr-1.5"></i>
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                                <span class="status-badge px-3 py-1 rounded-full text-xs font-semibold shadow-sm transition-all duration-300
                                    @if($order->status === 'pending') bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800 border border-yellow-200
                                    @elseif($order->status === 'processed') bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 border border-blue-200
                                    @elseif($order->status === 'completed') bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200
                                    @elseif($order->status === 'cancelled') bg-gradient-to-r from-red-100 to-red-50 text-red-800 border border-red-200
                                    @endif"
                                    data-status="{{ $order->status }}"
                                    data-order-id="{{ $order->id }}"
                                    x-intersect="$el.classList.add('animate-rubber-band')">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Item Pesanan (Collapsible) -->
                        <div class="border-t border-gray-200 pt-4 overflow-hidden transition-all duration-500 ease-in-out"
                             x-ref="details"
                             x-bind:style="expanded ? 'max-height: ' + $refs.details.scrollHeight + 'px' : 'max-height: 0px'">
                            <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-list-ul mr-2 text-blue-500"></i>
                                Daftar Pesanan
                            </h4>
                            
                            <div class="space-y-3">
                                @foreach($order->orderDetails as $item)
                                    <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 border border-gray-100 animate-fade-in animate-delay-{{ $loop->index * 50 }}">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-md overflow-hidden mr-3">
                                                <img src="{{ asset('storage/' . $item->menu->gambar) }}" 
                                                     alt="{{ $item->menu->nama_menu }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <span class="text-gray-800 font-medium">{{ $item->menu->nama_menu }}</span>
                                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                                    <span class="mr-2">x{{ $item->quantity }}</span>
                                                    <span>@ Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-gray-800 font-medium">
                                            Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Aksi (jika status pending) -->
                            @if($order->status === 'pending')
                                <div class="flex justify-end space-x-3 mt-5 animate-fade-in">
                                    <button class="text-sm text-red-600 hover:text-red-800 font-medium px-4 py-2 rounded-lg border border-red-200 hover:bg-red-50 transition-all duration-300 flex items-center transform hover:scale-105">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Batalkan Pesanan
                                    </button>
                                    <button class="text-sm bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium px-4 py-2 rounded-lg transition-all duration-300 flex items-center shadow-md hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-headset mr-2"></i>
                                        Hubungi Kami
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
            <a href="{{ route('customer.dashboard') }}" 
               class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium px-8 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-utensils mr-2"></i>
                Jelajahi Menu
            </a>
        </div>
    @endif
</main>

@push('scripts')
<script>
    // Function to update status with delays
    function simulateStatusUpdates() {
        const statusElements = document.querySelectorAll('.status-badge');
        
        statusElements.forEach(element => {
            const currentStatus = element.dataset.status;
            const orderId = element.dataset.orderId;
            
            if (currentStatus === 'pending') {
                // Update to processed after 5 seconds
                setTimeout(() => {
                    updateStatus(orderId, 'processed');
                    
                    // Then update to completed after another 10 seconds (15 seconds total from start)
                    setTimeout(() => {
                        updateStatus(orderId, 'completed');
                    }, 10000);
                    
                }, 5000);
            }
        });
    }
    
    // Function to update status via AJAX
    function updateStatus(orderId, newStatus) {
        fetch(`/customer/orders/${orderId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const statusElement = document.querySelector(`.status-badge[data-order-id="${orderId}"]`);
                if (statusElement) {
                    // Animate status change
                    statusElement.classList.add('animate-ping');
                    setTimeout(() => {
                        statusElement.classList.remove('animate-ping');
                        
                        // Update status text and style
                        statusElement.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        statusElement.dataset.status = newStatus;
                        updateStatusBadgeStyle(statusElement, newStatus);
                        
                        // Celebration effect for completed orders
                        if (newStatus === 'completed') {
                            const confetti = document.createElement('div');
                            confetti.className = 'fixed inset-0 z-50 pointer-events-none';
                            document.body.appendChild(confetti);
                            
                            // Simple confetti effect
                            for (let i = 0; i < 50; i++) {
                                setTimeout(() => {
                                    const particle = document.createElement('div');
                                    particle.className = 'absolute w-2 h-2 bg-blue-500 rounded-full animate-confetti';
                                    particle.style.left = `${Math.random() * 100}vw`;
                                    particle.style.top = '-10px';
                                    particle.style.setProperty('--random-x', (Math.random() - 0.5) * 20);
                                    particle.style.setProperty('--random-rotate', Math.random() * 360);
                                    particle.style.animationDuration = `${Math.random() * 3 + 2}s`;
                                    confetti.appendChild(particle);
                                    
                                    // Remove after animation
                                    setTimeout(() => particle.remove(), 3000);
                                }, i * 100);
                            }
                            
                            setTimeout(() => confetti.remove(), 3000);
                        }
                    }, 300);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error notification
            Toastify({
                text: "Gagal memperbarui status pesanan",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                stopOnFocus: true
            }).showToast();
        });
    }

    function updateStatusBadgeStyle(element, status) {
        // Remove all existing classes
        element.className = 'status-badge px-3 py-1 rounded-full text-xs font-semibold shadow-sm transition-all duration-300';
        
        // Add appropriate classes based on status
        switch (status) {
            case 'pending':
                element.classList.add('bg-gradient-to-r', 'from-yellow-100', 'to-yellow-50', 'text-yellow-800', 'border', 'border-yellow-200');
                break;
            case 'processed':
                element.classList.add('bg-gradient-to-r', 'from-blue-100', 'to-blue-50', 'text-blue-800', 'border', 'border-blue-200');
                break;
            case 'completed':
                element.classList.add('bg-gradient-to-r', 'from-green-100', 'to-green-50', 'text-green-800', 'border', 'border-green-200');
                break;
            case 'cancelled':
                element.classList.add('bg-gradient-to-r', 'from-red-100', 'to-red-50', 'text-red-800', 'border', 'border-red-200');
                break;
            default:
                element.classList.add('bg-gradient-to-r', 'from-gray-100', 'to-gray-50', 'text-gray-800', 'border', 'border-gray-200');
        }
    }

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
</style>
@endpush
@endsection
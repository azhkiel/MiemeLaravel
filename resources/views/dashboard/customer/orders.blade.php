@extends('layouts.app')

@section('content')
<div class="md:ml-64">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10 animate-slide-up">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Pesanan Saya</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('customer.cart') }}" class="relative text-gray-700 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span id="header-cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full {{ $total_items > 0 ? '' : 'hidden' }}">
                        {{ $total_items }}
                    </span>
                </a>
                <a href="{{ route('customer.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Order Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @if($orders->count() > 0)
            <div class="grid grid-cols-1 gap-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 animate-fade-in">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
                                <div class="mb-4 md:mb-0">
                                    <h3 class="text-lg font-bold text-gray-800">Pesanan #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="text-lg font-bold text-blue-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    <span class="status-badge px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'processed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}"
                                        data-status="{{ $order->status }}"
                                        data-order-id="{{ $order->id }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Order Items -->
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="font-medium text-gray-700 mb-3">Item Pesanan</h4>
                                @foreach($order->details as $item)
                                    <div class="flex justify-between py-2 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center">
                                            <span class="text-gray-700">{{ $item->menu->nama_menu }}</span>
                                            <span class="text-xs text-gray-500 ml-2">x{{ $item->quantity }}</span>
                                        </div>
                                        <span class="text-gray-600">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Order Actions -->
                            @if($order->status === 'pending')
                                <div class="flex justify-end space-x-3 mt-4">
                                    <button class="text-sm text-red-600 hover:text-red-800 font-medium px-3 py-1 rounded border border-red-200 hover:bg-red-50 transition-colors">
                                        Batalkan Pesanan
                                    </button>
                                    <button class="text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium px-3 py-1 rounded transition-colors">
                                        Hubungi Kami
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 animate-fade-in">
                <div class="mx-auto w-24 h-24 mb-4 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-6">Pesanan Anda akan muncul di sini setelah melakukan pembelian</p>
                <a href="{{ route('customer.dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition-colors">
                    Lihat Menu
                </a>
            </div>
        @endif
    </main>
</div>
@endsection

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
        fetch(`{{ route('customer.orders.update-status') }}?order_id=${orderId}&status=${newStatus}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const statusElement = document.querySelector(`.status-badge[data-order-id="${orderId}"]`);
                    if (statusElement) {
                        statusElement.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        statusElement.dataset.status = newStatus;
                        updateStatusBadgeStyle(statusElement, newStatus);
                        
                        // Add animation
                        statusElement.classList.add('animate-pulse-slow');
                        setTimeout(() => statusElement.classList.remove('animate-pulse-slow'), 3000);
                    }
                }
            });
    }

    // Function to update badge style based on status
    function updateStatusBadgeStyle(element, status) {
        // Reset classes
        element.className = 'status-badge px-3 py-1 rounded-full text-xs font-semibold';
        
        // Add status-specific classes
        switch(status) {
            case 'pending':
                element.classList.add('bg-yellow-100', 'text-yellow-800');
                break;
            case 'processed':
                element.classList.add('bg-blue-100', 'text-blue-800');
                break;
            case 'completed':
                element.classList.add('bg-green-100', 'text-green-800');
                break;
            case 'cancelled':
                element.classList.add('bg-red-100', 'text-red-800');
                break;
            default:
                element.classList.add('bg-gray-100', 'text-gray-800');
        }
    }

    // Start the status updates when page loads
    document.addEventListener('DOMContentLoaded', function() {
        simulateStatusUpdates();
    });
</script>
@endpush
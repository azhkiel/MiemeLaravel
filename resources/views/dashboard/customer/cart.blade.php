@extends('layouts.app')

@section('content')
<div class="md:ml-64">
    <div class="container mx-auto p-6 animate-fade-in">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Keranjang Belanja</h1>
                <p class="text-gray-600">Total {{ $total_items }} item dalam keranjang ({{ $item_count }} jenis)</p>
            </div>
            <button onclick="window.location.href='{{ route('customer.dashboard') }}'" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Lanjutkan Belanja
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Daftar item dalam keranjang -->
            <div class="lg:w-2/3 bg-white p-6 rounded-xl shadow-sm animate-slide-up">
                <h2 class="text-xl font-bold mb-6 text-gray-800">Item dalam Keranjang ({{ $item_count }} jenis)</h2>
                
                @if($item_count > 0)
                    <div class="space-y-4">
                        @foreach($items as $item)
                            <div class="flex items-center border-b border-gray-100 pb-4 group hover:bg-gray-50 transition-colors duration-200 p-3 rounded-lg">
                                <img src="{{ asset('assets/img/menu/' . $item->menu->gambar) }}" 
                                     class="w-20 h-20 rounded-lg object-cover mr-4 shadow-sm transition-transform duration-300 group-hover:scale-105">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $item->menu->nama_menu }}</p>
                                    <p class="text-gray-600 text-sm">Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button onclick="updateQuantity('decrease', {{ $item->id }})" 
                                       class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">
                                        -
                                    </button>
                                    <span id="quantity-{{ $item->id }}" class="mx-2 font-medium">{{ $item->quantity }}</span>
                                    <button onclick="updateQuantity('increase', {{ $item->id }})" 
                                       class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">
                                        +
                                    </button>
                                </div>
                                <p class="w-24 text-right font-semibold text-gray-800">
                                    Rp <span id="total-{{ $item->id }}">{{ number_format($item->quantity * $item->menu->harga, 0, ',', '.') }}</span>
                                </p>
                                <button onclick="updateQuantity('remove', {{ $item->id }})" 
                                   class="ml-4 text-red-500 hover:text-red-700 transition-colors p-2 rounded-full hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-700">Keranjang belanja kosong</h3>
                        <p class="mt-1 text-gray-500">Tambahkan beberapa item menu untuk memulai</p>
                        <button onclick="window.location.href='{{ route('customer.dashboard') }}'" class="mt-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Lihat Menu
                        </button>
                    </div>
                @endif
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="lg:w-1/3">
                <div class="bg-white p-6 rounded-xl shadow-sm sticky top-6 animate-slide-up">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Ringkasan Pesanan</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <p class="text-gray-600">Subtotal (<span id="summary-quantity">{{ $total_items }}</span> item)</p>
                            <p class="font-medium">Rp <span id="summary-subtotal">{{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        </div>
                        <div class="border-t border-gray-200 my-2"></div>
                        <div class="flex justify-between font-bold text-lg">
                            <p>Total</p>
                            <p class="text-blue-600">Rp <span id="summary-total">{{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('customer.cart.checkout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors duration-300 
                                       {{ $item_count == 0 ? 'opacity-50 cursor-not-allowed' : 'hover:shadow-md' }}"
                                {{ $item_count == 0 ? 'disabled' : '' }}>
                            Checkout Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update quantity and sync with sidebar
    function updateQuantity(action, id) {
        fetch(`{{ route('customer.cart.update') }}?action=${action}&id=${id}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update sidebar count (if exists on this page)
                    const sidebarCount = document.getElementById('sidebar-cart-count');
                    if (sidebarCount) {
                        sidebarCount.textContent = data.item_count;
                        sidebarCount.classList.add('animate-pulse');
                        setTimeout(() => {
                            sidebarCount.classList.remove('animate-pulse');
                        }, 1000);
                    }

                    // Update header count (if exists on this page)
                    const headerCount = document.getElementById('header-cart-count');
                    if (headerCount) {
                        headerCount.textContent = data.item_count;
                        headerCount.classList.add('animate-bounce');
                        setTimeout(() => {
                            headerCount.classList.remove('animate-bounce');
                        }, 1000);
                    }

                    // Reload page to update all data
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Animation for cart items
    document.querySelectorAll('.flex.items-center.border-b').forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
</script>
@endpush
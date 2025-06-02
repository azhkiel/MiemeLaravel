@extends('layout.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<header class="bg-white shadow-sm sticky top-0 z-10 animate-fade-down animate-duration-300">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <h1 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-history text-blue-500 mr-2"></i>
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Daftar Pesanan Pending
                </span>
            </h1>
        </div>


    </div>
</header>

<main class="max-w-7xl mx-auto px-4 py-8">
    @if($orders->isNotEmpty())
        <div class="grid grid-cols-1 gap-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-500 animate-fade-up animate-delay-{{ $loop->index * 50 }}">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 cursor-pointer">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                                    <span class="mr-2">Pesanan #{{ $order->id }}</span>
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
                                    data-status="{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-list-ul mr-2 text-blue-500"></i>
                                Daftar Pesanan
                            </h4>
                            
                            <div class="space-y-3">
                                @foreach($order->orderDetails as $item)
                                    <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 border border-gray-100">
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

                            <div class="flex justify-end space-x-3 mt-5">
                                <a href="{{ route('order.status', $order->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium px-4 py-2 rounded-lg border border-blue-200 hover:bg-blue-50 transition-all duration-300 flex items-center">
                                    <i class="fas fa-edit mr-2"></i>
                                    Update Status
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <div class="inline-block p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full mb-6">
                <i class="fas fa-shopping-cart text-5xl text-blue-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-800 mb-3">Belum ada pesanan pending</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-8">
                Pesanan pending akan muncul di sini setelah dipesan. Pastikan untuk memeriksa status pesanan.
            </p>
            <a href="{{ route('customer.dashboard') }}" 
               class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium px-8 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-utensils mr-2"></i>
                Jelajahi Menu
            </a>
        </div>
    @endif
</main>
@endsection

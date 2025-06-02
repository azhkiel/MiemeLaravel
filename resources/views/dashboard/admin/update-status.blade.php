@extends('layout.admin')

@section('title', 'Update Status Pesanan')

@section('content')
<header class="bg-white shadow-sm sticky top-0 z-10 animate-fade-down animate-duration-300">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <h1 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-history text-blue-500 mr-2"></i>
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Update Status Pesanan #{{ $order->id }}
                </span>
            </h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i class="fas fa-arrow-left mr-2 transition-transform duration-300 group-hover:-translate-x-1"></i>
                    <span>Kembali ke dashboard</span>
                </a>
            </div>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Update Status Pesanan #{{ $order->id }}</h2>
        
        <form action="{{ route('order.status.update', $order->id) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <label for="status" class="text-gray-800 font-medium">Pilih Status:</label>
                    <select name="status" id="status" class="w-1/2 p-2 border border-gray-300 rounded-lg">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ $order->status === 'processed' ? 'selected' : '' }}>Processed</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold transition-all duration-300 hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</main>
@endsection

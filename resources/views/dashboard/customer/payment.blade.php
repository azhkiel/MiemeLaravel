@extends('layout.dash')
@section('title','Pembayaran Pesanan')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8 mt-8">
    <h1 class="text-2xl font-bold mb-4">Konfirmasi & Pembayaran</h1>

    <!-- Tipe Pesanan -->
    <div class="mb-4">
        <p><strong>Tipe Pesanan:</strong> {{ $order_type === 'dine_in' ? 'Dine In' : 'Takeaway' }}</p>
        
        <!-- Menampilkan Meja jika Dine In -->
        @if($order_type === 'dine_in' && $meja)
            <p><strong>Meja:</strong> {{ $meja->nomor_meja }} (Kapasitas: {{ $meja->kapasitas }})</p>
        @elseif($order_type === 'dine_in' && !$meja)
            <p class="text-red-500">Meja belum dipilih!</p> <!-- Menampilkan pesan jika meja_id kosong -->
        @endif
    </div>

    <!-- Ringkasan Pesanan -->
    <div class="mb-4">
        <h2 class="font-semibold mb-2">Ringkasan Pesanan:</h2>
        <ul>
            @foreach($items as $item)
                <li>{{ $item->menu->nama_menu }} x{{ $item->quantity }} - Rp{{ number_format($item->menu->harga * $item->quantity, 0, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Total Harga -->
    <div class="mb-4">
        <strong>Total:</strong> Rp{{ number_format($subtotal, 0, ',', '.') }}
    </div>

    <!-- Formulir Pembayaran -->
    <form method="POST" action="{{ route('customer.checkout.store') }}">
        @csrf
        <input type="hidden" name="order_type" value="{{ $order_type }}">

        <!-- Kirimkan meja_id hanya jika order_type adalah dine_in -->
        @if($order_type === 'dine_in')
            <input type="hidden" name="meja_id" value="{{ $meja_id }}">
        @endif

        <!-- Tombol Konfirmasi -->
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Konfirmasi & Bayar
        </button>
    </form>
</div>
@endsection

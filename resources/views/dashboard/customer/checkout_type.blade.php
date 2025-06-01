@extends('layout.dash')
@section('title','Pilih Tipe Pesanan')
@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pilih Tipe Pesanan</h1>
    <form method="POST" action="{{ route('customer.checkout.type.post') }}">
        @csrf
        <div class="flex gap-6">
            <label class="block cursor-pointer">
                <input type="radio" name="order_type" value="dine_in" required>
                <span class="ml-2">Dine In (Makan di Tempat)</span>
            </label>
            <label class="block cursor-pointer">
                <input type="radio" name="order_type" value="takeaway" required>
                <span class="ml-2">Takeaway (Bawa Pulang)</span>
            </label>
        </div>
        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg">Lanjutkan</button>
    </form>
</div>
@endsection
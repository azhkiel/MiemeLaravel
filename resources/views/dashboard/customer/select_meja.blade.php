@extends('layout.dash')
@section('title','Pilih Meja')
@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pilih Meja</h1>
    <form method="POST" action="{{ route('customer.checkout.payment') }}">
        @csrf
        <input type="hidden" name="order_type" value="{{ $order_type }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($mejas as $meja)
            <label class="block border rounded-lg p-4 cursor-pointer hover:border-blue-500">
                <input type="radio" name="meja_id" value="{{ $meja->id }}" required>
                <div class="font-bold">Meja {{ $meja->nomor_meja }}</div>
                <div>Kapasitas: {{ $meja->kapasitas }}</div>
            </label>
            @endforeach
        </div>
        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg">Lanjutkan ke Pembayaran</button>
    </form>
</div>
@endsection
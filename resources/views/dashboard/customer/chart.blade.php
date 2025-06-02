@extends('layout.dash')
@section('title','Dashboard - Keranjang Belanja')
@section('content')
<div class="container mx-auto p-4 md:p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <div class="space-y-2">
            <h1 class="text-3xl font-bold text-gray-800 animate-fade-in-down">Keranjang Belanja</h1>
            <p class="text-gray-600 animate-fade-in-down delay-75">Total {{ $totalItems }} item dalam keranjang ({{ $items->count() }} jenis)</p>
        </div>
        <button onclick="window.location.href='{{ route('customer.dashboard') }}'" 
                class="flex items-center px-4 py-2 bg-white border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 animate-fade-in-down delay-100">
            <i class="fas fa-arrow-left mr-2"></i>
            Lanjutkan Belanja
        </button>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Cart Items Section -->
        <div class="lg:w-2/3 bg-white p-6 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-md animate-fade-in-up">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Item dalam Keranjang ({{ $items->count() }} jenis)</h2>
                @if($items->isNotEmpty())
                <form action="{{ route('customer.chart.clear') }}" method="POST" class="d-inline delete-form" id="clearCartForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmClearCart()" 
                        class="text-sm text-red-500 hover:text-red-700 transition-colors flex items-center">
                        <i class="fas fa-trash-alt mr-1"></i> Kosongkan Keranjang
                    </button>
                </form>
                @endif
            </div>
            
            @if($items->isNotEmpty())
            <div class="space-y-4">
                @foreach($items as $item)
                <div class="flex flex-col sm:flex-row items-center border border-gray-100 rounded-xl p-4 group hover:bg-gray-50/50 transition-all duration-300 animate-fade-in-right delay-{{ $loop->index * 50 }}">
                    <img src="{{ asset('storage/' . $item->menu->gambar) }}" 
                         class="w-24 h-24 rounded-xl object-cover mr-4 shadow-md transition-transform duration-300 group-hover:scale-105">
                    
                    <div class="flex-1 w-full sm:w-auto mt-4 sm:mt-0">
                        <p class="font-semibold text-gray-800 text-lg">{{ $item->menu->nama_menu }}</p>
                        <p class="text-gray-600">Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex items-center justify-between w-full sm:w-auto mt-4 sm:mt-0">
                        <div class="flex items-center space-x-2 bg-gray-100 rounded-full px-2 py-1">
                            <button onclick="updateQuantity('decrease', {{ $item->id }})" 
                                    class="w-8 h-8 flex items-center justify-center bg-white text-gray-700 rounded-full hover:bg-gray-200 transition-all duration-200 shadow-sm">
                                -
                            </button>
                            <span id="quantity-{{ $item->id }}" class="mx-2 font-medium text-gray-800 min-w-[20px] text-center">{{ $item->quantity }}</span>
                            <button onclick="updateQuantity('increase', {{ $item->id }})" 
                                    class="w-8 h-8 flex items-center justify-center bg-white text-gray-700 rounded-full hover:bg-gray-200 transition-all duration-200 shadow-sm">
                                +
                            </button>
                        </div>
                        
                        <p class="ml-4 w-24 text-right font-semibold text-gray-800 text-lg">
                            Rp <span id="total-{{ $item->id }}">{{ number_format($item->menu->harga * $item->quantity, 0, ',', '.') }}</span>
                        </p>
                        
                        <button onclick="updateQuantity('remove', {{ $item->id }})" 
                                class="ml-4 text-red-500 hover:text-red-700 transition-colors p-2 rounded-full hover:bg-red-50">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 animate-pulse">
                <div class="inline-block p-6 bg-blue-50 rounded-full mb-4">
                    <i class="fas fa-shopping-cart text-5xl text-blue-400"></i>
                </div>
                <h3 class="mt-4 text-xl font-medium text-gray-700">Keranjang belanja kosong</h3>
                <p class="mt-2 text-gray-500">Tambahkan beberapa item menu untuk memulai</p>
                <button onclick="window.location.href='{{ route('customer.dashboard') }}'" 
                        class="mt-6 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    Lihat Menu
                </button>
            </div>
            @endif
        </div>
        @if($items->isNotEmpty())
        <div class="lg:w-1/3">
            <div class="bg-white p-6 rounded-2xl shadow-sm sticky top-6 transition-all duration-300 hover:shadow-md animate-fade-in-up delay-100">
                <h2 class="text-xl font-bold mb-6 text-gray-800">Ringkasan Pesanan</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <p class="text-gray-600">Subtotal (<span id="summary-quantity">{{ $totalItems }}</span> item)</p>
                        <p class="font-medium">Rp <span id="summary-subtotal">{{ number_format($subtotal, 0, ',', '.') }}</span></p>
                    </div>
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between font-bold text-lg">
                        <p class="text-gray-800">Total</p>
                        <p class="text-blue-600">Rp <span id="summary-total">{{ number_format($subtotal, 0, ',', '.') }}</span></p>
                    </div>
                </div>

                <div x-data="{
                    openTypePesanan: false,
                    openMejaModal: false,
                    selectedMeja: null,
                    
                    // Submit untuk takeaway langsung
                    submitTakeaway() {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('customer.chart.checkout') }}';
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);
                        
                        const type = document.createElement('input');
                        type.type = 'hidden';
                        type.name = 'type_pesanan';
                        type.value = 'takeaway';
                        form.appendChild(type);
                        
                        document.body.appendChild(form);
                        form.submit();
                    },
                    
                    // Submit untuk dine in dengan meja
                    submitDineIn() {
                        if (!this.selectedMeja) {
                            alert('Silakan pilih meja terlebih dahulu');
                            return;
                        }
                        
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('customer.chart.checkout') }}';
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);
                        
                        const type = document.createElement('input');
                        type.type = 'hidden';
                        type.name = 'type_pesanan';
                        type.value = 'dine_in';
                        form.appendChild(type);
                        
                        const meja = document.createElement('input');
                        meja.type = 'hidden';
                        meja.name = 'meja_id';
                        meja.value = this.selectedMeja;
                        form.appendChild(meja);
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                }">
                    <!-- Checkout Button -->
                    <button type="button"
                        x-on:click="openTypePesanan = true"
                        class="w-full mt-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1 flex items-center justify-center">
                        <i class="fas fa-credit-card mr-2"></i>
                        Checkout Sekarang
                    </button>
                    
                    <!-- Type Pesanan Modal -->
                    <div x-show="openTypePesanan" x-cloak
                        class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 z-50"
                        x-transition>
                        <div class="bg-white p-8 rounded-lg w-full max-w-md mx-4">
                            <h3 class="text-xl font-semibold mb-6 text-center">Pilih Tipe Pesanan</h3>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                                <button type="button"
                                    x-on:click="openTypePesanan = false; submitTakeaway();"
                                    class="flex-1 px-6 py-3 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
                                    Takeaway
                                </button>
                                <button type="button"
                                    x-on:click="openTypePesanan = false; openMejaModal = true;"
                                    class="flex-1 px-6 py-3 rounded-lg bg-green-600 text-white font-semibold shadow hover:bg-green-700 transition">
                                    Dine In
                                </button>
                            </div>
                            <button type="button"
                                x-on:click="openTypePesanan = false"
                                class="w-full px-6 py-2 bg-gray-400 text-white rounded-lg">
                                Batal
                            </button>
                        </div>
                    </div>

                    <!-- Meja Modal -->
                    <div x-show="openMejaModal" x-cloak
                        class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 z-50"
                        x-transition>
                        <div class="bg-white p-8 rounded-lg w-full max-w-lg mx-4">
                            <h3 class="text-xl font-semibold mb-4">Pilih Meja (Dine-in)</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                                @foreach(\App\Models\Meja::where('ketersediaan', 'available')->get() as $meja)
                                    <button type="button"
                                            :class="selectedMeja === {{ $meja->id }} ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-100 text-gray-700 border-gray-300'"
                                            x-on:click="selectedMeja = {{ $meja->id }}"
                                            class="meja-option border p-4 rounded-md w-full text-center font-semibold transition-all duration-200">
                                        <div>{{ $meja->nomor_meja }}</div>
                                        <div class="text-sm text-gray-600">Kapasitas: {{ $meja->kapasitas }}</div> <!-- Menampilkan kapasitas meja -->
                                    </button>
                                @endforeach
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button"
                                        x-on:click="openMejaModal = false; selectedMeja = null;"
                                        class="px-6 py-2 bg-gray-500 text-white rounded-lg">
                                    Batal
                                </button>
                                <button type="button"
                                        x-bind:class="selectedMeja ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed'"
                                        :disabled="!selectedMeja"
                                        x-on:click="openMejaModal = false; submitDineIn();"
                                        class="px-6 py-2 text-white rounded-lg">
                                    Lanjutkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-500">Dengan melanjutkan, Anda menyetujui Syarat & Ketentuan kami</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@push('styles')
<style>
    .meja-option {
        transition: background-color 0.3s ease;
    }

    .meja-option:hover {
        background-color: #4CAF50;
        color: white;
    }

    .meja-option.selected {
        background-color: #2196F3;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function updateQuantity(action, id) {
        // Add loading animation
        const quantityElement = document.getElementById(`quantity-${id}`);
        quantityElement.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
        
        fetch(`{{ route('customer.chart.update') }}?action=${action}&id=${id}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animate the update
                if (action === 'remove') {
                    // Fade out and remove the item row
                    const itemRow = document.querySelector(`[onclick*="updateQuantity('remove', ${id})"]`).closest('.flex.flex-col');
                    itemRow.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                    setTimeout(() => {
                        itemRow.remove();
                        // Reload if cart is empty
                        if (document.querySelectorAll('[onclick*="updateQuantity"]').length <= 1) {
                            window.location.reload();
                        }
                    }, 300);
                }
                
                // Update all quantities and totals
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            quantityElement.textContent = quantityElement.textContent; // revert to original value
        });
    }
    
    function confirmClearCart() {
        Swal.fire({
            title: 'Kosongkan Keranjang?',
            text: "Semua item dalam keranjang akan dihapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kosongkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('clearCartForm').submit();
            }
        });
    }
    
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(el => {
            el.textContent = count;
            el.classList.add('animate-bounce', 'inline-block');
            setTimeout(() => {
                el.classList.remove('animate-bounce');
            }, 1000);
        });
    }
</script>
@endpush

@push('styles')
<style>
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out forwards;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .animate-fade-in-right {
        animation: fadeInRight 0.5s ease-out forwards;
    }
    .delay-75 {
        animation-delay: 75ms;
    }
    .delay-100 {
        animation-delay: 100ms;
    }
    .delay-150 {
        animation-delay: 150ms;
    }
    .delay-200 {
        animation-delay: 200ms;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@endpush
@endsection
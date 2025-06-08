@extends('layout.admin')
@section('title','Dashboard - Keranjang Belanja')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 relative">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #3B82F6 2px, transparent 2px), radial-gradient(circle at 75% 75%, #1D4ED8 2px, transparent 2px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="container mx-auto p-4 md:p-8 relative z-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-6 md:space-y-0">
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg animate-pulse">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent animate-fade-in-down">
                            Keranjang Belanja
                        </h1>
                        <div class="flex items-center space-x-2 mt-1 animate-fade-in-down delay-75">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                            <p class="text-blue-600 font-medium">
                                Total {{ $totalItems }} item dalam keranjang ({{ $items->count() }} jenis)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <button onclick="window.location.href='{{ route('admin.dashboard') }}'" 
                    class="group flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm border-2 border-blue-200 text-blue-600 rounded-2xl hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition-all duration-300 animate-fade-in-down delay-100 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
                <span class="font-semibold">Lanjutkan Belanja</span>
            </button>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items Section -->
            <div class="lg:w-2/3">
                <div class="bg-white/70 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-white/50 transition-all duration-500 hover:shadow-2xl hover:bg-white/80 animate-fade-in-up">
                    <!-- Card Header -->
                    <div class="flex justify-between items-center mb-8 pb-6 border-b border-blue-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-list text-white"></i>
                            </div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                Item dalam Keranjang ({{ $items->count() }} jenis)
                            </h2>
                        </div>
                        
                        @if($items->isNotEmpty())
                        <form action="{{ route('admin.chart.clear') }}" method="POST" class="d-inline delete-form" id="clearCartForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmClearCart()" 
                                class="group flex items-center text-sm text-red-500 hover:text-red-600 transition-all duration-300 px-4 py-2 rounded-xl hover:bg-red-50 border border-red-200 hover:border-red-300">
                                <i class="fas fa-trash-alt mr-2 group-hover:animate-bounce"></i> 
                                <span class="font-medium">Kosongkan Keranjang</span>
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    @if($items->isNotEmpty())
                    <div class="space-y-6">
                        @foreach($items as $item)
                        <div class="group flex flex-col sm:flex-row items-center bg-gradient-to-r from-white to-blue-50/30 border-2 border-blue-100 hover:border-blue-200 rounded-2xl p-6 transition-all duration-500 hover:shadow-lg hover:-translate-y-1 animate-fade-in-right delay-{{ $loop->index * 50 }}">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden rounded-2xl shadow-lg">
                                <img src="{{ asset('storage/' . $item->menu->gambar) }}" 
                                     class="w-28 h-28 object-cover transition-all duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 w-full sm:w-auto mt-6 sm:mt-0 sm:ml-6">
                                <h3 class="font-bold text-gray-800 text-xl mb-2 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $item->menu->nama_menu }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    <p class="text-blue-600 font-semibold text-lg">
                                        Rp {{ number_format($item->menu->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center justify-between w-full sm:w-auto mt-6 sm:mt-0 space-x-6">
                                <div class="flex items-center bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-2 shadow-inner">
                                    <button onclick="updateQuantity('decrease', {{ $item->id }})" 
                                            class="w-10 h-10 flex items-center justify-center bg-white text-blue-600 rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 font-bold">
                                        −
                                    </button>
                                    <span id="quantity-{{ $item->id }}" class="mx-4 font-bold text-blue-800 min-w-[30px] text-center text-lg">
                                        {{ $item->quantity }}
                                    </span>
                                    <button onclick="updateQuantity('increase', {{ $item->id }})" 
                                            class="w-10 h-10 flex items-center justify-center bg-white text-blue-600 rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 font-bold">
                                        +
                                    </button>
                                </div>
                                
                                <!-- Total Price -->
                                <div class="text-right">
                                    <p class="text-sm text-blue-500 font-medium">Total</p>
                                    <p class="font-bold text-blue-700 text-xl">
                                        Rp <span id="total-{{ $item->id }}">{{ number_format($item->menu->harga * $item->quantity, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                                
                                <!-- Delete Button -->
                                <button onclick="updateQuantity('remove', {{ $item->id }})" 
                                        class="w-12 h-12 flex items-center justify-center text-red-500 hover:text-white hover:bg-red-500 transition-all duration-300 rounded-xl hover:shadow-lg transform hover:scale-105 border-2 border-red-200 hover:border-red-500">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <!-- Empty Cart -->
                    <div class="text-center py-16 animate-fade-in-up">
                        <div class="relative inline-block mb-8">
                            <div class="absolute -inset-4 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full blur opacity-20 animate-pulse"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-r from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto shadow-xl">
                                <i class="fas fa-shopping-cart text-5xl text-blue-500 animate-bounce"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">Keranjang belanja kosong</h3>
                        <p class="text-gray-500 mb-8 text-lg">Tambahkan beberapa item menu untuk memulai</p>
                        <button onclick="window.location.href='{{ route('admin.dashboard') }}'" 
                                class="group px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 font-semibold text-lg">
                            <i class="fas fa-utensils mr-3 group-hover:animate-bounce"></i>
                            Lihat Menu
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            
            @if($items->isNotEmpty())
            <!-- Order Summary Section -->
            <div class="lg:w-1/3">
                <div class="bg-white/70 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-white/50 sticky top-6 transition-all duration-500 hover:shadow-2xl hover:bg-white/80 animate-fade-in-up delay-100">
                    <!-- Summary Header -->
                    <div class="flex items-center space-x-3 mb-8 pb-6 border-b border-blue-100">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-receipt text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                            Ringkasan Pesanan
                        </h2>
                    </div>
                    
                    <!-- Summary Details -->
                    <div class="space-y-6 mb-8">
                        <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-xl">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <p class="text-blue-700 font-medium">Subtotal (<span id="summary-quantity">{{ $totalItems }}</span> item)</p>
                            </div>
                            <p class="font-bold text-blue-800 text-lg">Rp <span id="summary-subtotal">{{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        </div>
                        
                        <div class="border-t-2 border-dashed border-blue-200 my-4"></div>
                        
                        <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl text-white">
                            <p class="font-bold text-xl">Total</p>
                            <p class="font-bold text-2xl">Rp <span id="summary-total">{{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <div x-data="{
                        openTypePesanan: false,
                        openMejaModal: false,
                        selectedMeja: null,
                        customerName: '',
                        
                        // Submit untuk takeaway langsung
                        submitTakeaway() {
                            if (!this.customerName.trim()) {
                                alert('Silakan masukkan nama customer terlebih dahulu');
                                return;
                            }
                            
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('admin.chart.checkout') }}';
                            
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
                            
                            const name = document.createElement('input');
                            name.type = 'hidden';
                            name.name = 'customer_name';
                            name.value = this.customerName;
                            form.appendChild(name);
                            
                            document.body.appendChild(form);
                            form.submit();
                        },
                        
                        // Submit untuk dine in dengan meja
                        submitDineIn() {
                            if (!this.customerName.trim()) {
                                alert('Silakan masukkan nama customer terlebih dahulu');
                                return;
                            }
                            
                            if (!this.selectedMeja) {
                                alert('Silakan pilih meja terlebih dahulu');
                                return;
                            }
                            
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('admin.chart.checkout') }}';
                            
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
                            
                            const name = document.createElement('input');
                            name.type = 'hidden';
                            name.name = 'customer_name';
                            name.value = this.customerName;
                            form.appendChild(name);
                            
                            const meja = document.createElement('input');
                            meja.type = 'hidden';
                            meja.name = 'meja_id';
                            meja.value = this.selectedMeja;
                            form.appendChild(meja);
                            
                            document.body.appendChild(form);
                            form.submit();
                        }
                    }">
                        <!-- Customer Name Input -->
                        <div class="mb-6">
                            <label for="customerName" class="block text-sm font-medium text-gray-700 mb-2">Nama Customer</label>
                            <input type="text" id="customerName" x-model="customerName"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 shadow-sm"
                                   placeholder="Masukkan nama customer" required>
                        </div>

                        <!-- Enhanced Checkout Button -->
                        <button type="button"
                            x-on:click="if(customerName.trim()) { openTypePesanan = true } else { alert('Silakan masukkan nama customer terlebih dahulu') }"
                            class="group w-full bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 text-white py-4 rounded-2xl font-bold text-lg transition-all duration-500 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 flex items-center justify-center relative overflow-hidden">
                            <!-- Animated background -->
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                            <i class="fas fa-credit-card mr-3 group-hover:animate-bounce"></i>
                            <span class="relative z-10">Checkout Sekarang</span>
                        </button>
                        
                        <!-- Enhanced Type Pesanan Modal -->
                        <div x-show="openTypePesanan" x-cloak
                            class="fixed inset-0 flex justify-center items-center bg-black/60 backdrop-blur-sm z-50"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100">
                            <div class="bg-white/95 backdrop-blur-sm p-10 rounded-3xl w-full max-w-md mx-4 shadow-2xl border border-white/50 transform transition-all duration-300"
                                x-transition:enter="transition ease-out duration-300 transform"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                <div class="text-center mb-8">
                                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <i class="fas fa-utensils text-white text-2xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                        Pilih Tipe Pesanan
                                    </h3>
                                </div>
                                
                                <div class="space-y-4 mb-8">
                                    <button type="button"
                                        x-on:click="openTypePesanan = false; submitTakeaway();"
                                        class="group w-full px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center">
                                        <i class="fas fa-shopping-bag mr-3 group-hover:animate-bounce"></i>
                                        Takeaway
                                    </button>
                                    <button type="button"
                                        x-on:click="openTypePesanan = false; openMejaModal = true;"
                                        class="group w-full px-8 py-4 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center">
                                        <i class="fas fa-utensils mr-3 group-hover:animate-bounce"></i>
                                        Dine In
                                    </button>
                                </div>
                                
                                <button type="button"
                                    x-on:click="openTypePesanan = false"
                                    class="w-full px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-2xl font-semibold transition-all duration-300">
                                    Batal
                                </button>
                            </div>
                        </div>

                        <!-- Enhanced Meja Modal -->
                        <div x-show="openMejaModal" x-cloak
                            class="fixed inset-0 flex justify-center items-center bg-black/60 backdrop-blur-sm z-50"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100">
                            <div class="bg-white/95 backdrop-blur-sm p-10 rounded-3xl w-full max-w-2xl mx-4 shadow-2xl border border-white/50 max-h-[90vh] overflow-y-auto"
                                x-transition:enter="transition ease-out duration-300 transform"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                <div class="text-center mb-8">
                                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <i class="fas fa-table text-white text-2xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                                        Pilih Meja (Dine-in)
                                    </h3>
                                </div>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                                    @foreach(\App\Models\Meja::where('ketersediaan', 'available')->get() as $meja)
                                        <button type="button"
                                                :class="selectedMeja === {{ $meja->id }} ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white border-blue-500 shadow-xl scale-105' : 'bg-white/80 text-gray-700 border-blue-200 hover:border-blue-300 hover:bg-blue-50'"
                                                x-on:click="selectedMeja = {{ $meja->id }}"
                                                class="meja-option border-2 p-6 rounded-2xl text-center font-bold transition-all duration-300 transform hover:scale-105 hover:shadow-lg backdrop-blur-sm">
                                            <div class="text-2xl mb-2">{{ $meja->nomor_meja }}</div>
                                            <div class="text-sm opacity-80">Kapasitas: {{ $meja->kapasitas }} orang</div>
                                        </button>
                                    @endforeach
                                </div>
                                
                                <div class="flex justify-center space-x-4">
                                    <button type="button"
                                            x-on:click="openMejaModal = false; selectedMeja = null;"
                                            class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-2xl font-semibold transition-all duration-300">
                                        Batal
                                    </button>
                                    <button type="button"
                                            x-bind:class="selectedMeja ? 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transform hover:-translate-y-1 shadow-lg hover:shadow-xl' : 'bg-gray-400 cursor-not-allowed'"
                                            :disabled="!selectedMeja"
                                            x-on:click="openMejaModal = false; submitDineIn();"
                                            class="px-8 py-3 text-white rounded-2xl font-semibold transition-all duration-300">
                                        Lanjutkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <div class="flex items-center justify-center space-x-2 text-sm text-blue-600">
                            <i class="fas fa-shield-alt"></i>
                            <p>Dengan melanjutkan, Anda menyetujui <span class="font-semibold">Syarat & Ketentuan</span> kami</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .meja-option {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .meja-option:hover {
        transform: translateY(-4px) scale(1.02);
    }

    .meja-option.selected {
        animation: selectedPulse 2s infinite;
    }

    @keyframes selectedPulse {
        0%, 100% { 
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
        }
        50% { 
            box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
        }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    .animate-fade-in-right {
        animation: fadeInRight 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
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
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(59, 130, 246, 0.1);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3B82F6, #1D4ED8);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #1D4ED8, #1E40AF);
    }
</style>
@endpush

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function updateQuantity(action, id) {
        // Add loading animation
        const quantityElement = document.getElementById(`quantity-${id}`);
        const originalText = quantityElement.textContent;
        quantityElement.innerHTML = `<i class="fas fa-spinner fa-spin text-blue-500"></i>`;
        
        fetch(`{{ route('admin.chart.update') }}?action=${action}&id=${id}`, {
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
                    const itemRow = document.querySelector(`[onclick*="updateQuantity('remove', ${id})"]`).closest('.group');
                    itemRow.classList.add('opacity-0', 'scale-95', 'transition-all', 'duration-500');
                    setTimeout(() => {
                        itemRow.remove();
                        // Reload if cart is empty
                        if (document.querySelectorAll('[onclick*="updateQuantity"]').length <= 1) {
                            window.location.reload();
                        }
                    }, 500);
                }
                
                // Update all quantities and totals with smooth reload
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            quantityElement.textContent = originalText; // revert to original value
        });
    }
    
    function confirmClearCart() {
        Swal.fire({
            title: 'Kosongkan Keranjang?',
            text: "Semua item dalam keranjang akan dihapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3B82F6',
            cancelButtonColor: '#EF4444',
            confirmButtonText: 'Ya, Kosongkan',
            cancelButtonText: 'Batal',
            background: 'rgba(255, 255, 255, 0.95)',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            customClass: {
                popup: 'backdrop-blur-sm rounded-2xl shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                cancelButton: 'rounded-xl px-6 py-3 font-semibold'
            }
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

    // Add smooth page transitions
    document.addEventListener('DOMContentLoaded', function() {
        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe all cart items
        document.querySelectorAll('.group').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endpush
@endsection
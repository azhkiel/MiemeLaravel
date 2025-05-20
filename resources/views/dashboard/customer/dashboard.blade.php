@extends('layouts.app')

@section('content')
<div class="md:ml-64 transition-all duration-300">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <div class="flex items-center space-x-6">
                <a href="{{ route('customer.cart') }}" class="relative text-gray-700 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                        {{ $total_items }}
                    </span>
                </a>
                <div class="relative group">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4 text-gray-500 group-hover:text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 hidden group-hover:block">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Selamat Datang, {{ Auth::user()->name }}!</h1>
        
        @foreach($categories as $category)
            <section class="mb-12">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b-2 border-blue-100 pb-2 inline-block">{{ $category }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($menus->where('kategori', $category) as $menu)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ asset('assets/img/menu/' . $menu->gambar) }}" 
                                    alt="{{ $menu->nama_menu }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $menu->nama_menu }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $menu->deskripsi }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-blue-600">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
                                    <form class="flex items-center add-to-cart-form">
                                        <div class="flex items-center bg-gray-100 rounded-lg mr-3">
                                            <button type="button" class="decrease-btn px-2 py-1 text-gray-600 hover:text-blue-600 transition-colors">
                                                -
                                            </button>
                                            <input type="number" name="quantity" value="1" min="1" 
                                                   class="quantity-input w-10 text-center border-none bg-transparent">
                                            <button type="button" class="increase-btn px-2 py-1 text-gray-600 hover:text-blue-600 transition-colors">
                                                +
                                            </button>
                                        </div>
                                        <input type="hidden" name="kode_menu" value="{{ $menu->kode_menu }}">
                                        <button type="submit" class="add-to-cart-btn bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg flex items-center transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </main>
</div>

<!-- Notification Element -->
<div id="notification" class="notification">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 notification-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span id="notification-text"></span>
</div>

@endsection

@push('scripts')
<script>
    // Quantity controls
    document.querySelectorAll('.increase-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            input.value = parseInt(input.value) + 1;
        });
    });

    document.querySelectorAll('.decrease-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });

    // Fungsi untuk update semua cart count di halaman
    function updateAllCartCounts(count) {
        // Update header cart count
        const headerCartCount = document.getElementById("cart-count");
        if (headerCartCount) {
            headerCartCount.textContent = count;
            headerCartCount.classList.add('animate-bounce');
            setTimeout(() => headerCartCount.classList.remove('animate-bounce'), 1000);
        }
        
        // Update sidebar cart count
        const sidebarCartCount = document.getElementById("sidebar-cart-count");
        if (sidebarCartCount) {
            sidebarCartCount.textContent = count;
            sidebarCartCount.classList.add('animate-pulse');
            setTimeout(() => sidebarCartCount.classList.remove('animate-pulse'), 1000);
        }
    }

    // Fungsi untuk get cart count dari server
    function fetchCartCount() {
        fetch("{{ route('customer.cart.count') }}")
            .then(response => response.json())
            .then(data => {
                updateAllCartCounts(data.total_items);
            });
    }

    // Panggil saat pertama load
    document.addEventListener('DOMContentLoaded', function() {
        fetchCartCount();
    });

    // Modifikasi fungsi addToCart
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('.add-to-cart-btn');
            const quantityInput = this.querySelector('.quantity-input');
            
            // Ubah state tombol
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Menambahkan...
            `;
            
            fetch("{{ route('customer.cart.add') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update semua cart count
                    updateAllCartCounts(data.total_items);
                    
                    // Tampilkan notifikasi
                    showNotification(data.menu_name, data.quantity);
                    
                    // Reset form
                    quantityInput.value = 1;
                    
                    // Kembalikan state tombol
                    setTimeout(() => {
                        submitBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah
                        `;
                        submitBtn.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Gagal
                `;
                setTimeout(() => {
                    submitBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah
                    `;
                    submitBtn.disabled = false;
                }, 2000);
            });
        });
    });

    // Show notification function
    function showNotification(menuName, quantity) {
        const notification = document.getElementById('notification');
        const notificationText = document.getElementById('notification-text');
        
        notificationText.textContent = `Added ${quantity}x ${menuName} to cart`;
        notification.classList.add('show');
        
        // Hide after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }

    // Toggle sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('md:-translate-x-0');
    }
</script>
@endpush
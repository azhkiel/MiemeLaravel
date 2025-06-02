@extends('layout.dash')
@section('title','Menu')
@section('content')
<main class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Hero Introduction -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-green-500 to-lime-500 bg-clip-text text-transparent">
            Jelajahi Menu Kami
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Temukan hidangan favoritmu dari berbagai pilihan lezat yang kami sajikan. Cukup pilih, pesan, dan nikmati — semua jadi lebih mudah!
        </p>
    </div>


    @foreach(['Makanan', 'Minuman', 'Dessert'] as $category)
    @if($menus->has($category))
    <!-- Category Section with Unique Styling -->
    <section class="mb-16 p-8 rounded-3xl 
        @if($category === 'Makanan') bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-100
        @elseif($category === 'Minuman') bg-gradient-to-br from-purple-50 to-blue-50 border-2 border-purple-100
        @else bg-gradient-to-br from-pink-50 to-purple-50 border-2 border-pink-100 @endif"
        x-data="{ isHovered: false }">
        
        <!-- Category Header with Persuasive Copy -->
        <div class="relative mb-8 group text-center" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
            <h2 class="text-3xl font-bold inline-block relative pb-2 mx-auto
                @if($category === 'Makanan') text-blue-800
                @elseif($category === 'Minuman') text-purple-800
                @else text-pink-800 @endif">
                <span class="relative z-10">
                    @if($category === 'Makanan')
                        Menu Andalan Kami
                    @elseif($category === 'Minuman')
                        Minuman Menyegarkan
                    @else
                        Hidangan Penutup Lezat
                    @endif
                </span>
                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-20 h-1 rounded-full
                    @if($category === 'Makanan') bg-blue-300
                    @elseif($category === 'Minuman') bg-purple-300
                    @else bg-pink-300 @endif"></span>
            </h2>

            <p class="mt-4 text-lg text-gray-700 max-w-2xl mx-auto">
                @if($category === 'Makanan')
                    Chef kami menghadirkan kreasi terbaik dari bahan pilihan, menghasilkan hidangan utama yang tak terlupakan. Setiap suapan penuh rasa dan kenikmatan!
                @elseif($category === 'Minuman')
                    Dari kopi artisan hingga racikan tropis yang menyegarkan — semua minuman kami dibuat dengan sepenuh hati untuk menyegarkan hari Anda.
                @else
                    Akhiri santapan Anda dengan manis. Pencuci mulut kami siap memanjakan lidah dan hati Anda dengan cita rasa surgawi.
                @endif
            </p>
        </div>


        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
            x-data="{
                init() {
                    this.$nextTick(() => {
                        const items = this.$el.children;
                        items.forEach((item, index) => {
                            item.style.opacity = '0';
                            item.style.transform = 'translateY(30px) scale(0.95)';
                            item.style.transition = `all 0.6s ease ${index * 0.1}s`;
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0) scale(1)';
                            }, 100);
                        });
                    });
                }
            }">
            @foreach($menus[$category] as $menu)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group relative"
                 x-data="{ showQuickView: false }">

                <!-- Image -->
                <div class="relative h-64 overflow-hidden cursor-pointer" @click="showQuickView = true">
                    <img src="{{ asset('storage/' . $menu->gambar) }}" 
                         alt="{{ $menu->nama_menu }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">
                            {{ $menu->nama_menu }}
                        </h3>
                        <span class="text-lg font-semibold 
                            @if($category === 'Makanan') text-blue-600
                            @elseif($category === 'Minuman') text-purple-600
                            @else text-pink-600 @endif">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $menu->deskripsi }}
                        @if(strlen($menu->deskripsi) > 100)
                        <span class="text-indigo-500 cursor-pointer hover:underline" @click="showQuickView = true">Read more</span>
                        @endif
                    </p>
                    
                    <!-- Add to Cart Form -->
                    <form class="flex justify-between items-center" 
                            x-data="{
                                quantity: 1, 
                                isAdding: false,
                                addToCart() {
                                    this.isAdding = true;
                                    fetch('{{ route('customer.chart.add') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content
                                        },
                                        body: JSON.stringify({
                                            kode_menu: '{{ $menu->kode_menu }}',
                                            quantity: this.quantity
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            updateCartCount(data.total_items);
                                            Alpine.store('notification').show(
                                                'Added to your order!', 
                                                `You've added ${data.quantity}x ${data.menu_name} to your cart`,
                                                'success'
                                            );
                                            this.quantity = 1;
                                        }
                                        this.isAdding = false;
                                    })
                                }
                            }"
                            @submit.prevent="addToCart()">
                            
                            <!-- Quantity Selector -->
                            <div class="flex items-center bg-gray-100 rounded-full mr-3 overflow-hidden border border-gray-200">
                                <button type="button" @click="quantity > 1 ? quantity-- : null" 
                                    class="px-3 py-1 text-gray-600 hover:text-indigo-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" x-model="quantity" min="1" 
                                        class="quantity-input w-10 text-center border-none bg-transparent focus:ring-0 text-gray-700 font-medium">
                                <button type="button" @click="quantity++" 
                                        class="px-3 py-1 text-gray-600 hover:text-indigo-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Add Button -->
                            <button type="submit" 
                                    class="px-4 py-2 rounded-full font-medium transition-all shadow-md hover:shadow-lg
                                    @if($category === 'Makanan') bg-blue-600 hover:bg-blue-700
                                    @elseif($category === 'Minuman') bg-purple-600 hover:bg-purple-700
                                    @else bg-pink-600 hover:bg-pink-700 @endif
                                    text-white flex items-center"
                                    :disabled="isAdding">
                                <span x-show="!isAdding" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add to Order
                                </span>
                                <span x-show="isAdding" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Adding...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
          
          <!-- Category CTA -->
          <div class="mt-10 text-center">
              <p class="text-lg text-gray-700 mb-4">
                @if($category === 'Makanan')
                    Masih lapar? Jelajahi menu lengkap kami untuk lebih banyak pilihan lezat yang menggoda selera!
                @elseif($category === 'Minuman')
                    Haus? Temukan berbagai minuman segar dan spesial yang siap memanjakan harimu!
                @else
                    Bingung memilih? Coba paket pencuci mulut kami dan nikmati sedikit dari semuanya!
                @endif
            </p>

              <button class="px-6 py-3 rounded-full font-bold transition-all shadow-lg hover:shadow-xl
                  @if($category === 'Makanan') bg-blue-600 hover:bg-blue-700
                  @elseif($category === 'Minuman') bg-purple-600 hover:bg-purple-700
                  @else bg-pink-600 hover:bg-pink-700 @endif
                  text-white inline-flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  View All {{ $category }}
              </button>
          </div>
    </section>
    @endif
    @endforeach
</main>
@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('notification', () => ({
                show: false,
                message: '',
                type: 'success',
                
                init() {
                    window.Echo.private(`user.${this.userId}`)
                        .listen('OrderStatusUpdated', (e) => {
                            this.showNotification(`Status pesanan #${e.orderId} diperbarui ke ${e.status}`, 'success');
                        });
                },
                
                showNotification(message, type = 'success') {
                    this.message = message;
                    this.type = type;
                    this.show = true;
                    
                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                }
            }));
        });
        
        // Live update cart count
        function updateCartCount(count) {
            const elements = document.querySelectorAll('.cart-count');
            elements.forEach(el => {
                el.textContent = count;
                el.classList.add('animate-pulse');
                setTimeout(() => el.classList.remove('animate-pulse'), 1000);
            });
        }
    </script>
@endpush
@endsection
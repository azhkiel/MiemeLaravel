@extends('layout.admin')
@section('title','Menu')
@section('content')
<main class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
    <!-- Background Decorations -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-blue-100/40 rounded-full blur-2xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-16 relative" 
             x-data="{ isVisible: false }" 
             x-init="setTimeout(() => isVisible = true, 100)"
             :class="{ 'opacity-100 translate-y-0': isVisible, 'opacity-0 translate-y-10': !isVisible }"
             class="transition-all duration-1000 ease-out">
            
            <div class="relative inline-block mb-6">
                <h1 class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 mb-4 relative">
                    Jelajahi Menu Kami
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur opacity-20 animate-pulse"></div>
                </h1>
            </div>
            
            <p class="text-xl md:text-2xl text-slate-600 max-w-4xl mx-auto font-light leading-relaxed mb-8">
                Temukan hidangan favoritmu dari berbagai pilihan lezat yang kami sajikan. 
                <span class="text-blue-600 font-semibold">Cukup pilih, pesan, dan nikmati</span> — semua jadi lebih mudah!
            </p>

            <!-- Search Section -->
            <div class="max-w-2xl mx-auto mb-8" x-data="{ searchQuery: '', isSearching: false }">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300"></div>
                    <div class="relative bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-blue-100/50 p-2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 pl-4">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                x-model="searchQuery"
                                @input="filterMenus($event.target.value)"
                                placeholder="Cari menu favorit Anda..." 
                                class="w-full px-4 py-4 text-lg text-slate-700 bg-transparent border-none focus:outline-none focus:ring-0 placeholder-slate-400"
                            >
                            <button 
                                type="button"
                                @click="searchQuery = ''; filterMenus('')"
                                x-show="searchQuery.length > 0"
                                class="flex-shrink-0 pr-4 text-slate-400 hover:text-blue-600 transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Filter Badges -->
            <div class="flex flex-wrap justify-center gap-3 mb-8" x-data="{ activeFilter: 'semua' }">
                <button 
                    @click="activeFilter = 'semua'; filterByCategory('semua')"
                    :class="activeFilter === 'semua' ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-white/60 text-slate-600 hover:bg-blue-50'"
                    class="px-6 py-3 rounded-full font-semibold transition-all duration-300 border border-blue-100 backdrop-blur-sm"
                >
                    Semua Menu
                </button>
                @foreach(['Makanan', 'Minuman', 'Dessert'] as $category)
                <button 
                    @click="activeFilter = '{{ strtolower($category) }}'; filterByCategory('{{ $category }}')"
                    :class="activeFilter === '{{ strtolower($category) }}' ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-white/60 text-slate-600 hover:bg-blue-50'"
                    class="px-6 py-3 rounded-full font-semibold transition-all duration-300 border border-blue-100 backdrop-blur-sm"
                >
                    {{ $category }}
                </button>
                @endforeach
            </div>
        </div>

        @foreach(['Makanan', 'Minuman', 'Dessert'] as $category)
        @if($menus->has($category))
        <!-- Category Section -->
        <section class="mb-20 category-section" data-category="{{ $category }}">
            <div class="relative">
                <!-- Background Card -->
                <div class="absolute inset-4 bg-gradient-to-br from-white/40 to-blue-50/60 backdrop-blur-sm rounded-3xl border border-white/20"></div>
                
                <div class="relative bg-white/70 backdrop-blur-md rounded-3xl shadow-2xl border border-blue-100/50 p-8 md:p-12">
                    <!-- Floating Decoration -->
                    <div class="absolute -top-3 -right-3 w-24 h-24 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full blur-xl"></div>
                    
                    <!-- Category Header -->
                    <div class="text-center mb-12" x-data="{ isHovered: false }">
                        <div class="relative inline-block" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
                            <h2 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4 relative">
                                @if($category === 'Makanan')
                                    🍽️ Menu Andalan Kami
                                @elseif($category === 'Minuman')
                                    🥤 Minuman Menyegarkan
                                @else
                                    🍰 Hidangan Penutup Lezat
                                @endif
                                
                                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full"
                                     :class="{ 'w-40': isHovered }"
                                     class="transition-all duration-300"></div>
                            </h2>
                        </div>

                        <p class="mt-6 text-lg md:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                            @if($category === 'Makanan')
                                Chef kami menghadirkan kreasi terbaik dari bahan pilihan, menghasilkan hidangan utama yang tak terlupakan. 
                                <span class="text-blue-600 font-semibold">Setiap suapan penuh rasa dan kenikmatan!</span>
                            @elseif($category === 'Minuman')
                                Dari kopi artisan hingga racikan tropis yang menyegarkan — semua minuman kami dibuat dengan sepenuh hati untuk 
                                <span class="text-blue-600 font-semibold">menyegarkan hari Anda.</span>
                            @else
                                Akhiri santapan Anda dengan manis. Pencuci mulut kami siap memanjakan lidah dan hati Anda dengan 
                                <span class="text-blue-600 font-semibold">cita rasa surgawi.</span>
                            @endif
                        </p>
                    </div>

                    <!-- Menu Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 menu-grid"
                         x-data="{
                             init() {
                                 this.$nextTick(() => {
                                     const items = this.$el.children;
                                     items.forEach((item, index) => {
                                         item.style.opacity = '0';
                                         item.style.transform = 'translateY(50px) scale(0.9)';
                                         item.style.transition = `all 0.8s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.1}s`;
                                         setTimeout(() => {
                                             item.style.opacity = '1';
                                             item.style.transform = 'translateY(0) scale(1)';
                                         }, 200);
                                     });
                                 });
                             }
                         }">
                        
                        @foreach($menus[$category] as $menu)
                        <div class="menu-card group relative" data-menu-name="{{ strtolower($menu->nama_menu) }}" data-menu-description="{{ strtolower($menu->deskripsi) }}">
                            <!-- Card Background with Glassmorphism -->
                            <div class="absolute inset-0 bg-gradient-to-br from-white/80 to-blue-50/60 backdrop-blur-lg rounded-2xl border border-white/30 group-hover:border-blue-300/50 transition-all duration-500"></div>
                            
                            <div class="relative bg-white/60 backdrop-blur-sm rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-[1.02] overflow-hidden border border-blue-100/50"
                                 x-data="{ showQuickView: false, isHovered: false }"
                                 @mouseenter="isHovered = true"
                                 @mouseleave="isHovered = false">

                                <!-- Floating Badge -->
                                <div class="absolute top-4 right-4 z-10 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                                    {{ $category }}
                                </div>

                                <!-- Image Container -->
                                <div class="relative h-72 overflow-hidden cursor-pointer group" @click="showQuickView = true">
                                    <img src="{{ asset('storage/' . $menu->gambar) }}" 
                                         alt="{{ $menu->nama_menu }}"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- Quick View Button -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <button class="bg-white/90 backdrop-blur-sm text-blue-600 px-6 py-3 rounded-full font-semibold shadow-lg hover:bg-white hover:scale-105 transition-all duration-200">
                                            Quick View
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6 space-y-4">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-xl font-bold text-slate-800 group-hover:text-blue-600 transition-colors duration-300 leading-tight">
                                            {{ $menu->nama_menu }}
                                        </h3>
                                        <div class="text-right">
                                            <span class="text-2xl font-bold text-blue-600">
                                                Rp{{ number_format($menu->harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">
                                        {{ $menu->deskripsi }}
                                        @if(strlen($menu->deskripsi) > 100)
                                        <span class="text-blue-500 cursor-pointer hover:text-blue-700 font-medium ml-1" @click="showQuickView = true">
                                            Selengkapnya →
                                        </span>
                                        @endif
                                    </p>
                                    
                                    <!-- Add to Cart Form -->
                                    <form class="flex items-center justify-between pt-4 border-t border-blue-100/50" 
                                          x-data="{
                                              quantity: 1, 
                                              isAdding: false,
                                              addToCart() {
                                                  this.isAdding = true;
                                                  fetch('{{ route('admin.chart.add') }}', {
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
                                                  .catch(() => this.isAdding = false)
                                              }
                                          }"
                                          @submit.prevent="addToCart()">
                                          
                                        <!-- Quantity Selector -->
                                        <div class="flex items-center bg-blue-50/80 backdrop-blur-sm rounded-full border border-blue-200/50 overflow-hidden">
                                            <button type="button" @click="quantity > 1 ? quantity-- : null" 
                                                class="px-4 py-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100/50 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" x-model="quantity" min="1" 
                                                   class="w-12 text-center border-none bg-transparent focus:ring-0 text-slate-700 font-semibold">
                                            <button type="button" @click="quantity++" 
                                                    class="px-4 py-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100/50 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Add Button -->
                                        <button type="submit" 
                                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2"
                                                :disabled="isAdding"
                                                :class="{ 'opacity-70 cursor-not-allowed': isAdding }">
                                            <span x-show="!isAdding" class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                <span>Add</span>
                                            </span>
                                            <span x-show="isAdding" class="flex items-center space-x-2">
                                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span>Adding...</span>
                                            </span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Shine Effect -->
                                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Category CTA -->
                    <div class="mt-16 text-center">
                        <div class="bg-gradient-to-r from-blue-600/10 to-indigo-600/10 backdrop-blur-sm rounded-2xl p-8 border border-blue-200/30">
                            <p class="text-lg md:text-xl text-slate-700 mb-6 font-medium">
                                @if($category === 'Makanan')
                                    Masih lapar? Jelajahi menu lengkap kami untuk lebih banyak pilihan lezat yang menggoda selera! 🍽️
                                @elseif($category === 'Minuman')
                                    Haus? Temukan berbagai minuman segar dan spesial yang siap memanjakan harimu! 🥤
                                @else
                                    Bingung memilih? Coba paket pencuci mulut kami dan nikmati sedikit dari semuanya! 🍰
                                @endif
                            </p>

                            <button class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 inline-flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>View All {{ $category }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        @endforeach

        <!-- No Results Message -->
        <div id="no-results" class="hidden text-center py-16">
            <div class="bg-white/70 backdrop-blur-md rounded-3xl shadow-xl border border-blue-100/50 p-12 max-w-2xl mx-auto">
                <div class="text-8xl mb-6">🔍</div>
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Tidak ada hasil yang ditemukan</h3>
                <p class="text-slate-600 text-lg mb-6">Coba kata kunci lain atau jelajahi kategori menu yang tersedia.</p>
                <button onclick="clearSearch()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl">
                    Lihat Semua Menu
                </button>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notification', () => ({
            show: false,
            message: '',
            type: 'success',
            
            init() {
                if (window.Echo) {
                    window.Echo.private(`user.${this.userId}`)
                        .listen('OrderStatusUpdated', (e) => {
                            this.showNotification(`Status pesanan #${e.orderId} diperbarui ke ${e.status}`, 'success');
                        });
                }
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

    // Search and Filter Functions
    function filterMenus(searchQuery) {
        const menuCards = document.querySelectorAll('.menu-card');
        const sections = document.querySelectorAll('.category-section');
        const noResults = document.getElementById('no-results');
        let hasResults = false;

        menuCards.forEach(card => {
            const menuName = card.dataset.menuName;
            const menuDescription = card.dataset.menuDescription;
            const isMatch = menuName.includes(searchQuery.toLowerCase()) || 
                           menuDescription.includes(searchQuery.toLowerCase());
            
            if (isMatch) {
                card.style.display = 'block';
                card.style.animation = 'fadeInUp 0.5s ease-out';
                hasResults = true;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide sections based on results
        sections.forEach(section => {
            const visibleCards = section.querySelectorAll('.menu-card[style*="display: block"], .menu-card:not([style*="display: none"])');
            if (visibleCards.length === 0 && searchQuery.trim() !== '') {
                section.style.display = 'none';
            } else {
                section.style.display = 'block';
            }
        });

        // Show/hide no results message
        if (!hasResults && searchQuery.trim() !== '') {
            noResults.classList.remove('hidden');
            sections.forEach(section => section.style.display = 'none');
        } else {
            noResults.classList.add('hidden');
        }
    }

    function filterByCategory(category) {
        const sections = document.querySelectorAll('.category-section');
        const noResults = document.getElementById('no-results');
        
        noResults.classList.add('hidden');
        
        if (category === 'semua') {
            sections.forEach(section => {
                section.style.display = 'block';
                section.style.animation = 'fadeInUp 0.6s ease-out';
            });
        } else {
            sections.forEach(section => {
                if (section.dataset.category === category) {
                    section.style.display = 'block';
                    section.style.animation = 'fadeInUp 0.6s ease-out';
                } else {
                    section.style.display = 'none';
                }
            });
        }
    }

    function clearSearch() {
        const searchInput = document.querySelector('input[type="text"]');
        if (searchInput) {
            searchInput.value = '';
            filterMenus('');
        }
        filterByCategory('semua');
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
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
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
@endsection
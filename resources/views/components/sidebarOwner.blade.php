<!-- Overlay untuk mobile -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"></div>

<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-white via-gray-50 to-white shadow-2xl border-r border-gray-200 transform transition-all duration-300 ease-in-out"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <!-- Header Sidebar dengan Gradient -->
    <div class="relative flex items-center justify-between h-16 px-4 bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600 shadow-lg">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="7" cy="7" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        
        <div class="relative flex items-center group">
            <div class="relative">
                <img src="{{ asset('assets/img/mieme/Logo Mentaly.png') }}" 
                     class="h-10 mr-3 transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" 
                     alt="Logo">
                <!-- Glow effect on logo -->
                <div class="absolute inset-0 h-10 w-10 bg-white rounded-full opacity-0 group-hover:opacity-30 transition-opacity duration-300 blur-md"></div>
            </div>
            <div class="relative">
                <span class="text-xl font-bold text-white tracking-wider drop-shadow-sm">MieMe</span>
                <div class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-yellow-300 to-pink-300 group-hover:w-full transition-all duration-500"></div>
            </div>
        </div>

        <!-- Tombol Tutup untuk Mobile -->
        <button @click="sidebarOpen = false" 
                class="relative text-white hover:text-gray-200 focus:outline-none md:hidden p-2 rounded-lg hover:bg-white/20 transition-all duration-200 group">
            <i class="fas fa-times text-lg transform group-hover:rotate-90 transition-transform duration-300"></i>
        </button>

        <!-- Toggle Button untuk Desktop -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="hidden md:block relative text-white hover:text-gray-200 focus:outline-none p-2 rounded-lg hover:bg-white/20 transition-all duration-200 group">
            <i class="fas fa-chevron-left text-sm transform transition-transform duration-300"
               :class="sidebarOpen ? 'rotate-0' : 'rotate-180'"></i>
        </button>
    </div>

    <!-- Isi Sidebar dengan Scrollbar Custom -->
    <div class="overflow-y-auto h-full py-6 px-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        <nav class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('owner.dashboard') }}"
               class="group flex items-center p-3 text-base font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                      {{ request()->routeIs('owner.dashboard') ? 'text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 shadow-md border-l-4 border-blue-500' : 'text-gray-700 hover:text-blue-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50' }}">
                <div class="relative">
                    <i class="fas fa-home w-5 h-5 transition-all duration-300 
                            {{ request()->routeIs('owner.dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                    <!-- Icon glow effect -->
                    <div class="absolute inset-0 rounded-full bg-blue-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                </div>
                <span class="ml-4 transition-all duration-300 font-medium">Dashboard</span>
                <!-- Animated arrow -->
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all duration-300 text-gray-400"></i>
            </a>

            <!-- Menu -->
            <a href="{{ route('menu.index') }}"
               class="group flex items-center p-3 text-base font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                      {{ request()->routeIs('menu.index') ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-emerald-100 shadow-md border-l-4 border-emerald-500' : 'text-gray-700 hover:text-emerald-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50' }}">
                <div class="relative">
                    <i class="fas fa-utensils w-5 h-5 transition-all duration-300 
                            {{ request()->routeIs('menu.index') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }}"></i>
                    <div class="absolute inset-0 rounded-full bg-emerald-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                </div>
                <span class="ml-4 transition-all duration-300 font-medium">Menu</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all duration-300 text-gray-400"></i>
            </a>

            <!-- User -->
            <a href="{{ route('user.index') }}"
               class="group flex items-center p-3 text-base font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                      {{ request()->routeIs('user.index') ? 'text-orange-700 bg-gradient-to-r from-orange-50 to-orange-100 shadow-md border-l-4 border-orange-500' : 'text-gray-700 hover:text-orange-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50' }}">
                <div class="relative">
                    <i class="fas fa-users w-5 h-5 transition-all duration-300 
                            {{ request()->routeIs('user.index') ? 'text-orange-600' : 'text-gray-500 group-hover:text-orange-600' }}"></i>
                    <div class="absolute inset-0 rounded-full bg-orange-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                </div>
                <span class="ml-4 transition-all duration-300 font-medium">User</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all duration-300 text-gray-400"></i>
            </a>

            <!-- Keranjang dengan Badge Animasi -->
            {{-- <a href="{{ route('admin.chart') }}"
               class="group flex items-center p-3 text-base font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                      {{ request()->routeIs('admin.chart') ? 'text-purple-700 bg-gradient-to-r from-purple-50 to-purple-100 shadow-md border-l-4 border-purple-500' : 'text-gray-700 hover:text-purple-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50' }}">
                <div class="relative">
                    <i class="fas fa-shopping-cart w-5 h-5 transition-all duration-300 
                            {{ request()->routeIs('admin.chart') ? 'text-purple-600' : 'text-gray-500 group-hover:text-purple-600' }}"></i>
                    <div class="absolute inset-0 rounded-full bg-purple-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                </div>
                <span class="ml-4 transition-all duration-300 font-medium">Keranjang</span>
                <!-- Animated Cart Badge -->
                <span class="cart-count ml-auto relative inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform transition-all duration-300 bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg group-hover:scale-110">
                    {{ auth()->user()->charts()->sum('quantity') }}
                    <span class="absolute top-0 right-0 -mt-1 -mr-1 w-3 h-3 bg-yellow-400 rounded-full animate-ping"></span>
                </span>
            </a> --}}

            <!-- Promo -->
            {{-- <a href="{{ route('admin.order') }}"
               class="group flex items-center p-3 text-base font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                      {{ request()->routeIs('admin.order') ? 'text-yellow-700 bg-gradient-to-r from-yellow-50 to-yellow-100 shadow-md border-l-4 border-yellow-500' : 'text-gray-700 hover:text-yellow-700 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50' }}">
                <div class="relative">
                    <i class="fas fa-tasks w-5 h-5 transition-all duration-300 
                            {{ request()->routeIs('admin.order') ? 'text-yellow-600' : 'text-gray-500 group-hover:text-yellow-600' }}"></i>
                    <div class="absolute inset-0 rounded-full bg-yellow-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                </div>
                <span class="ml-4 transition-all duration-300 font-medium">Promo</span>
                <span class="ml-auto px-2 py-1 text-xs font-semibold text-yellow-800 bg-gradient-to-r from-yellow-200 to-yellow-300 rounded-full shadow-sm">New</span>
            </a> --}}

            <!-- Divider -->
            <div class="my-6 border-t border-gray-200"></div>

            <!-- Logout dengan Animasi -->
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit"
                        class="group flex items-center w-full p-3 text-base font-medium text-gray-700 rounded-xl hover:text-red-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="relative">
                        <i class="fas fa-sign-out-alt w-5 h-5 text-gray-500 group-hover:text-red-600 transition-all duration-300"></i>
                        <div class="absolute inset-0 rounded-full bg-red-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                    </div>
                    <span class="ml-4 transition-all duration-300 font-medium">Logout</span>
                    <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all duration-300 text-gray-400"></i>
                </button>
            </form>
        </nav>

        <!-- Footer Sidebar -->
        <div class="absolute bottom-4 left-4 right-4">
            <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl shadow-lg border border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->username }}</p>
                        <p class="text-xs text-gray-500">Dashboard</p>
                    </div>
                    <div class="w-2 h-2 bg-green-400 rounded-full shadow-sm"></div>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Hamburger Button untuk Mobile -->
<button @click="sidebarOpen = true" 
        class="fixed top-4 left-4 z-40 p-3 text-gray-700 bg-white rounded-xl shadow-lg hover:shadow-xl border border-gray-200 hover:bg-gray-50 focus:outline-none md:hidden transition-all duration-300 transform hover:scale-110"
        x-show="!sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75">
    <i class="fas fa-bars text-lg"></i>
    <div class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
</button>

<!-- Button untuk membuka Sidebar saat ditutup di Desktop -->
<button @click="sidebarOpen = true" 
        class="hidden md:block fixed top-4 left-4 z-40 p-3 text-gray-700 bg-white rounded-xl shadow-lg hover:shadow-xl border border-gray-200 hover:bg-gray-50 focus:outline-none transition-all duration-300 transform hover:scale-110"
        x-show="!sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75">
    <i class="fas fa-bars text-lg"></i>
    <div class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
</button>

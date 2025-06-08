<div class="flex">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-20 w-64 bg-white shadow-lg transition-transform duration-300 ease-in-out md:translate-x-0">
        <!-- Header Sidebar -->
        <div class="flex items-center justify-between h-16 px-4 bg-blue-600">
            <div class="flex items-center">
                <img src="{{ asset('assets/img/mieme/Logo Mentaly.png') }}" class="h-10 mr-2" alt="Logo">
                <span class="text-xl font-bold text-white">MieMe</span>
            </div>
            <!-- Tombol Tutup -->
            <button @click="sidebarOpen = false" class="text-white hover:text-gray-200 focus:outline-none md:hidden">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Isi Sidebar -->
        <div class="overflow-y-auto h-full py-4 px-3">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('owner.dashboard') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                            {{ request()->routeIs('owner.dashboard') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5 
                                {{ request()->routeIs('owner.dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                <a href="{{ route('admin.menu') }}"
               class="group flex items-center p-3 text-base font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                      {{ request()->routeIs('admin.menu') ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-emerald-100 shadow-md border-l-4 border-emerald-500' : 'text-gray-700 hover:text-emerald-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50' }}">
                <div class="relative">
                    <i class="fas fa-utensils w-5 h-5 transition-all duration-300 
                            {{ request()->routeIs('admin.menu') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }}"></i>
                    <div class="absolute inset-0 rounded-full bg-emerald-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                </div>
                <span class="ml-4 transition-all duration-300 font-medium">Menu</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all duration-300 text-gray-400"></i>
            </a>

            <!-- Pesanan Saya -->
            <a href="{{ route('admin.orders') }}"
               class="group flex items-center p-3 text-base font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg
                      {{ request()->routeIs('admin.orders') ? 'text-orange-700 bg-gradient-to-r from-orange-50 to-orange-100 shadow-md border-l-4 border-orange-500' : 'text-gray-700 hover:text-orange-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50' }}">
                <div class="relative">
                    <i class="fas fa-clipboard-list w-5 h-5 transition-all duration-300 
                            {{ request()->routeIs('admin.orders') ? 'text-orange-600' : 'text-gray-500 group-hover:text-orange-600' }}"></i>
                    <div class="absolute inset-0 rounded-full bg-orange-500 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                </div>
                <span class="ml-4 transition-all duration-300 font-medium">Pesanan Saya</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all duration-300 text-gray-400"></i>
            </a>

            <!-- Keranjang dengan Badge Animasi -->
            <a href="{{ route('admin.chart') }}"
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
            </a>
                
                <!-- Menu Management -->
                <li>
                    <a href="{{ route('menu.index') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                            {{ request()->routeIs('menu.index') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                        <i class="fas fa-utensils w-5 h-5 
                                {{ request()->routeIs('menu.index') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                        <span class="ml-3">Manajemen Menu</span>
                    </a>
                </li>
                <!-- Logout -->
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                                class="flex items-center w-full p-2 text-base font-medium text-gray-900 rounded-lg hover:bg-gray-100 group">
                            <i class="fas fa-sign-out-alt text-gray-500 group-hover:text-blue-600 w-5 h-5"></i>
                            <span class="ml-3">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>
</div>
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
            <li>
                <a href="{{ route('customer.dashboard') }}"
                class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                        {{ request()->routeIs('customer.dashboard') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                    <i class="fas fa-home w-5 h-5 
                            {{ request()->routeIs('customer.dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.menu') }}"
                class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                        {{ request()->routeIs('customer.menu') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                    <i class="fas fa-utensils w-5 h-5 
                            {{ request()->routeIs('customer.menu') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                    <span class="ml-3">Menu</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.orders') }}"
                class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                        {{ request()->routeIs('customer.orders') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                    <i class="fas fa-clipboard-list 
                            {{ request()->routeIs('customer.orders') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }} 
                            w-5 h-5"></i>
                    <span class="ml-3">Pesanan Saya</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.chart') }}"
                class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                        {{ request()->routeIs('customer.chart') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                    <i class="fas fa-shopping-cart w-5 h-5 
                            {{ request()->routeIs('customer.chart') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                    <span class="ml-3">Keranjang</span>
                    <span class="cart-count ml-auto bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">
                        {{ auth()->user()->charts()->sum('quantity') }}
                    </span>
                </a>
            </li>
            <li>
                <a href="#"
                class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                        {{ request()->routeIs('customer.promo') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                    <i class="fas fa-tag w-5 h-5 
                            {{ request()->routeIs('customer.promo') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                    <span class="ml-3">Promo</span>
                </a>
            </li>
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
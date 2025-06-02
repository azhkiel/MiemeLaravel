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
                    <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                            {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5 
                                {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                        <span class="ml-3 hover:text-blue-600">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.order') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                            {{ request()->routeIs('admin.order') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                        <i class="fas fa-utensils w-5 h-5 
                                {{ request()->routeIs('admin.order') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                        <span class="ml-3 hover:text-blue-600">Manajemen Order</span>
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
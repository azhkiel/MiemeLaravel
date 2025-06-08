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

                <!-- Manajemen User -->
                <li>
                    <a href="{{ route('user.index') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg hover:bg-gray-100 group 
                            {{ request()->routeIs('user.index') ? 'text-blue-600 bg-gray-100' : 'text-gray-900' }}">
                        <i class="fas fa-users w-5 h-5 
                                {{ request()->routeIs('user.index') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
                        <span class="ml-3">Manajemen User</span>
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

    <!-- Hamburger Button untuk mobile -->
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
    </button>

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

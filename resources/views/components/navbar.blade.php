<header 
    class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300 hover:shadow-md"
    x-data="{ mobileMenuOpen: false }"
    @scroll.window="
        const currentScroll = window.pageYOffset;
        if (currentScroll <= 0) {
            $el.classList.remove('shadow-md');
            $el.classList.remove('-translate-y-full');
        } else if (currentScroll > lastScroll && !$el.classList.contains('-translate-y-full')) {
            $el.classList.add('-translate-y-full');
        } else if (currentScroll < lastScroll && $el.classList.contains('-translate-y-full')) {
            $el.classList.remove('-translate-y-full');
            $el.classList.add('shadow-md');
        }
        lastScroll = currentScroll;
    "
    x-init="let lastScroll = 0; $nextTick(() => {
        const navLinks = $el.querySelectorAll('.nav-link');
        navLinks.forEach((link, index) => {
            link.style.opacity = '0';
            link.style.transform = 'translateY(-10px)';
            link.style.transition = `opacity 0.3s ease ${index * 0.1}s, transform 0.3s ease ${index * 0.1}s`;
            
            setTimeout(() => {
                link.style.opacity = '1';
                link.style.transform = 'translateY(0)';
            }, 100);
        });
    })"
>
    <nav>
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
            <!-- Logo with Animation -->
            <a href="{{ route('index') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                <img src="{{ asset('assets/img/mieme/Logo Mentaly.png') }}" 
                     class="h-12 transition-transform duration-300 group-hover:rotate-12" 
                     alt="MieMe Logo" />
                <span class="self-center text-2xl font-bold whitespace-nowrap bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                    MieMe
                </span>
            </a>

            <!-- Auth Buttons with Animation -->
            <div class="flex items-center md:order-2 space-x-2 md:space-x-3 rtl:space-x-reverse">
                    <a href="{{ route('login') }}" 
                       class="relative overflow-hidden border border-blue-600 text-blue-600 hover:text-white font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 focus:outline-none transition-all duration-300 group">
                       <span class="relative z-10">Masuk</span>
                       <span class="absolute inset-0 bg-blue-600 origin-left transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 z-0"></span>
                    </a>
                    <a href="{{ route('register') }}" 
                       class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 focus:outline-none transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                       <span class="relative z-10">Daftar</span>
                       <span class="absolute inset-0 bg-white/10 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    </a>
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-800 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-300"
                        aria-controls="mega-menu" 
                        :aria-expanded="mobileMenuOpen">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-90': mobileMenuOpen }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu -->
            <div id="mega-menu" 
                 class="items-center justify-between w-full md:flex md:w-auto md:order-1"
                 :class="{ 'hidden': !mobileMenuOpen }"
                 x-show="mobileMenuOpen || window.innerWidth >= 768" x-data="scrollNavigator">
                <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-6 rtl:space-x-reverse">
                    <li>
                        <a href="{{ route('index') }}" 
                           class="nav-link block py-2 px-3 text-blue-600 md:p-0 relative group"
                           :class="{ 'text-blue-600': request()->routeIs('home') }">
                           <span>Beranda</span>
                           <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"
                                 :class="{ 'scale-x-100': request()->routeIs('home') }"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('menu.index') }}"
                           class="nav-link block py-2 px-3 text-gray-700 hover:text-blue-600 md:p-0 relative group"
                           :class="{ 'text-blue-600': request()->routeIs('menu') }">
                            <span>Menu</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"
                                  :class="{ 'scale-x-100': request()->routeIs('menu') }"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#about"
                           class="nav-link block py-2 px-3 text-gray-700 hover:text-blue-600 md:p-0 relative group"
                           :class="{ 'text-blue-600': request()->routeIs('about') }" @click.prevent="scrollTo('about')">
                            <span>Tentang Kami</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"
                                  :class="{ 'scale-x-100': request()->routeIs('about') }"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index') }}"
                           class="nav-link block py-2 px-3 text-gray-700 hover:text-blue-600 md:p-0 relative group"
                           :class="{ 'text-blue-600': request()->routeIs('contact') }">
                            <span>Kontak</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"
                                  :class="{ 'scale-x-100': request()->routeIs('contact') }"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>    
</header>
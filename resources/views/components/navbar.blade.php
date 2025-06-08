<header 
    class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-xl border-b border-white/20 transition-all duration-500 ease-out"
    x-data="{ 
        mobileMenuOpen: false, 
        scrolled: false,
        lastScroll: 0,
        hidden: false
    }"
    x-init="
        // Scroll detection with enhanced effects
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            // Update scrolled state
            scrolled = currentScroll > 20;
            
            // Auto-hide navbar on scroll down
            if (currentScroll > lastScroll && currentScroll > 100 && !mobileMenuOpen) {
                hidden = true;
            } else if (currentScroll < lastScroll) {
                hidden = false;
            }
            
            lastScroll = currentScroll;
        });
        
        // Animate nav links on load
        $nextTick(() => {
            const navLinks = $el.querySelectorAll('.nav-link');
            navLinks.forEach((link, index) => {
                link.style.opacity = '0';
                link.style.transform = 'translateY(-20px)';
                link.style.transition = `all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) ${index * 0.1}s`;
                
                setTimeout(() => {
                    link.style.opacity = '1';
                    link.style.transform = 'translateY(0)';
                }, 200);
            });
        });
    "
    :class="{
        'shadow-2xl bg-white/95': scrolled,
        'bg-white/80': !scrolled,
        '-translate-y-full': hidden,
        'translate-y-0': !hidden
    }"
    @click.away="mobileMenuOpen = false"
>
    <nav class="relative">
        <div class="flex items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Logo with Enhanced Animation -->
            <a href="{{ route('index') }}" 
               class="flex items-center space-x-3 py-4 group relative overflow-hidden">
                <div class="relative">
                    <img src="{{ asset('assets/img/mieme/Logo Mentaly.png') }}" 
                         class="h-10 sm:h-12 transition-all duration-500 group-hover:scale-110 group-hover:rotate-12 filter drop-shadow-lg" 
                         alt="MieMe Logo" />
                    <!-- Logo glow effect -->
                    <div class="absolute inset-0 bg-blue-400/30 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
                </div>
                <div class="relative">
                    <span class="text-2xl sm:text-3xl font-black bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent group-hover:from-purple-600 group-hover:via-blue-600 group-hover:to-purple-800 transition-all duration-500">
                        MieMe
                    </span>
                    <!-- Text underline effect -->
                    <div class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-500"></div>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('index') }}" 
                   class="nav-link relative px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 group">
                   <span class="relative z-10">Beranda</span>
                   <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></div>
                   <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transform -translate-x-1/2 group-hover:w-3/4 transition-all duration-300"></div>
                </a>
                
                <a href="{{ route('menu.index') }}"
                   class="nav-link relative px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 group">
                    <span class="relative z-10">Menu</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></div>
                    <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transform -translate-x-1/2 group-hover:w-3/4 transition-all duration-300"></div>
                </a>
                
                <a href="#about"
                   class="nav-link relative px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 group"
                   @click.prevent="document.getElementById('about')?.scrollIntoView({behavior: 'smooth'})">
                    <span class="relative z-10">Tentang Kami</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></div>
                    <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transform -translate-x-1/2 group-hover:w-3/4 transition-all duration-300"></div>
                </a>
                
                <a href="{{ route('index') }}"
                   class="nav-link relative px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 group">
                    <span class="relative z-10">Kontak</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></div>
                    <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transform -translate-x-1/2 group-hover:w-3/4 transition-all duration-300"></div>
                </a>
            </div>

            <!-- Auth Buttons with Enhanced Animation -->
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('login') }}" 
                   class="relative overflow-hidden group px-6 py-2.5 border-2 border-blue-600 text-blue-600 font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                   <span class="relative z-10 group-hover:text-white transition-colors duration-300">Masuk</span>
                   <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                   <!-- Shine effect -->
                   <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>
                
                <a href="{{ route('register') }}" 
                   class="relative overflow-hidden group px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-purple-600 hover:to-blue-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                   <span class="relative z-10">Daftar</span>
                   <!-- Glow effect -->
                   <div class="absolute inset-0 bg-white/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                   <!-- Shine effect -->
                   <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    type="button" 
                    class="md:hidden relative inline-flex items-center justify-center p-2 w-12 h-12 text-gray-700 rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 group"
                    :class="{ 'bg-blue-50 text-blue-600': mobileMenuOpen }">
                <span class="sr-only">Menu</span>
                <!-- Animated Hamburger -->
                <div class="relative w-6 h-6">
                    <span class="absolute top-0 left-0 w-full h-0.5 bg-current transform origin-center transition-all duration-300"
                          :class="mobileMenuOpen ? 'rotate-45 translate-y-2.5' : 'rotate-0 translate-y-0'"></span>
                    <span class="absolute top-2.5 left-0 w-full h-0.5 bg-current transition-all duration-300"
                          :class="mobileMenuOpen ? 'opacity-0 scale-0' : 'opacity-100 scale-100'"></span>
                    <span class="absolute top-5 left-0 w-full h-0.5 bg-current transform origin-center transition-all duration-300"
                          :class="mobileMenuOpen ? '-rotate-45 -translate-y-2.5' : 'rotate-0 translate-y-0'"></span>
                </div>
            </button>
        </div>

        <!-- Mobile Menu with Enhanced Animation -->
        <div class="md:hidden overflow-hidden"
             x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-full"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-full">
            
            <div class="bg-white/95 backdrop-blur-xl border-t border-gray-200 shadow-2xl">
                <!-- Mobile Navigation Links -->
                <div class="px-4 py-6 space-y-2">
                    <a href="{{ route('index') }}" 
                       class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl font-medium transition-all duration-300 transform hover:translate-x-2"
                       @click="mobileMenuOpen = false">
                       <span class="flex items-center">
                           <span class="w-2 h-2 bg-blue-600 rounded-full mr-3 opacity-0 translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0"></span>
                           Beranda
                       </span>
                    </a>
                    
                    <a href="{{ route('menu.index') }}"
                       class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl font-medium transition-all duration-300 transform hover:translate-x-2 group"
                       @click="mobileMenuOpen = false">
                       <span class="flex items-center">
                           <span class="w-2 h-2 bg-blue-600 rounded-full mr-3 opacity-0 translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0"></span>
                           Menu
                       </span>
                    </a>
                    
                    <a href="#about"
                       class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl font-medium transition-all duration-300 transform hover:translate-x-2 group"
                       @click="mobileMenuOpen = false; document.getElementById('about')?.scrollIntoView({behavior: 'smooth'})">
                       <span class="flex items-center">
                           <span class="w-2 h-2 bg-blue-600 rounded-full mr-3 opacity-0 translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0"></span>
                           Tentang Kami
                       </span>
                    </a>
                    
                    <a href="{{ route('index') }}"
                       class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl font-medium transition-all duration-300 transform hover:translate-x-2 group"
                       @click="mobileMenuOpen = false">
                       <span class="flex items-center">
                           <span class="w-2 h-2 bg-blue-600 rounded-full mr-3 opacity-0 translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0"></span>
                           Kontak
                       </span>
                    </a>
                </div>

                <!-- Mobile Auth Buttons -->
                <div class="px-4 pb-6 space-y-3 border-t border-gray-200 pt-6">
                    <a href="{{ route('login') }}" 
                       class="block w-full px-4 py-3 text-center border-2 border-blue-600 text-blue-600 font-semibold rounded-xl transition-all duration-300 hover:bg-blue-600 hover:text-white transform hover:scale-105"
                       @click="mobileMenuOpen = false">
                       Masuk
                    </a>
                    
                    <a href="{{ route('register') }}" 
                       class="block w-full px-4 py-3 text-center bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg transform hover:scale-105"
                       @click="mobileMenuOpen = false">
                       Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>    
</header>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Mieme</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: rgb(209 213 219) rgb(243 244 246);
        }
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: rgb(243 244 246);
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgb(209 213 219);
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgb(156 163 175);
        }
        
        /* Smooth transitions */
        * {
            scroll-behavior: smooth;
        }
        
        /* Loading animation */
        .loading-overlay {
            backdrop-filter: blur(4px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50" 
      x-data="{ 
          sidebarOpen: window.innerWidth >= 768,
          loading: false 
      }"
      x-init="
          // Handle resize events properly
          const handleResize = () => {
              if (window.innerWidth >= 768) {
                  sidebarOpen = true;
              } else {
                  sidebarOpen = false;
              }
          };
          
          window.addEventListener('resize', handleResize);
          
          // Add loading states to links
          document.addEventListener('click', (e) => {
              if (e.target.tagName === 'A' && !e.target.href.includes('#')) {
                  loading = true;
              }
          });
      ">

    <!-- Loading Overlay -->
    <div x-show="loading" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 loading-overlay">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p class="mt-4 text-gray-600 font-medium">Loading...</p>
        </div>
    </div>

    <!-- Sidebar Component -->
    <x-sidebarOwner></x-sidebarOwner>
    
    <!-- Main Content -->
    <main class="transition-all duration-300 ease-in-out min-h-screen"
          :class="sidebarOpen && window.innerWidth >= 768 ? 'md:ml-64' : 'ml-0'">
        
        <!-- Content Wrapper dengan Background Pattern -->
        <div class="relative min-h-screen">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%2393c5fd" fill-opacity="0.1"%3E%3Ccircle cx="7" cy="7" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            
            <!-- Main Content -->
            <div class="relative z-10">
                <!-- Top Padding untuk Mobile (karena hamburger button) -->
                <div class="pt-20 md:pt-8 px-4 md:px-8">
                    <!-- Content Area dengan Card Style -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 min-h-[calc(100vh-8rem)] p-6 md:p-8">
                        @yield('content')
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="mt-8 px-4 md:px-8 pb-6">
                    <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 text-center text-gray-600 text-sm border border-gray-200/50 shadow-sm">
                        <p>&copy; {{ date('Y') }} MieMe. All rights reserved.</p>
                    </div>
                </footer>
            </div>
        </div>
    </main>

    <!-- Notification Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">
        <!-- Toast notifications will be added here dynamically -->
    </div>

    <!-- Scripts -->
    <script>
        Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `
                px-4 py-3 rounded-lg shadow-lg border transform transition-all duration-300 ease-in-out
                ${type === 'success' ? 'bg-green-500 text-white border-green-600' : 
                  type === 'error' ? 'bg-red-500 text-white border-red-600' : 
                  type === 'warning' ? 'bg-yellow-500 text-white border-yellow-600' : 
                  'bg-blue-500 text-white border-blue-600'}
                translate-x-full opacity-0
            `;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 
                                   type === 'error' ? 'fa-exclamation-circle' : 
                                   type === 'warning' ? 'fa-exclamation-triangle' : 
                                   'fa-info-circle'} mr-2"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.getElementById('toast-container').appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        Update cart count with animation
        function updateCartCount(count) {
            const cartBadge = document.querySelector('.cart-count');
            if (cartBadge) {
                cartBadge.classList.add('animate-bounce');
                cartBadge.textContent = count;
                setTimeout(() => {
                    cartBadge.classList.remove('animate-bounce');
                }, 1000);
            }
        }

        // Page transition effect
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('animate__animated', 'animate__fadeIn');
        });
    </script>

    @stack('scripts')
</body>
</html>
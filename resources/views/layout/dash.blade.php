<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Mieme</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="h-full" x-data="{ sidebarOpen: window.innerWidth >= 768 }">
    
    <x-sidebar></x-sidebar>
    <main class="md:ml-64 transition-all duration-300">
        @yield('content')
    </main>
    
    <!-- Notification -->
    <div x-data="notification" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-full"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-full"
        class="fixed top-4 right-4 z-50 bg-emerald-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2">
        <i x-show="type === 'success'" class="fas fa-check-circle"></i>
        <i x-show="type === 'error'" class="fas fa-exclamation-circle"></i>
        <span x-text="message"></span>
    </div>
    
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
    @stack('scripts')
</body>
</html>
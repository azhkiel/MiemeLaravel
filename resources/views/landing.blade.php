@extends('layout.app')
@section('title', 'Restoran Kami - Pengalaman Kuliner Terbaik')
@section('content')
<section class="relative h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-blue-700 to-purple-500">
    <!-- Video Background -->
    <div class="absolute inset-0 z-0 opacity-90">
        <video autoplay muted loop class="w-full h-full object-cover">
            <source src="{{ asset('videos/mieme-video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Main Content Section -->
    <div class="relative z-10 container mx-auto px-6 py-10">
        <div class="flex flex-col lg:flex-row items-center justify-between h-screen">
            <!-- Left Section (Text Content) -->
            <div class="lg:w-1/2 text-white mb-12 lg:mb-0" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 300)">
                <div :class="loaded ? 'slide-in-left' : ''" style="animation-delay: 0.2s;">
                    <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-6">
                        🍽️ Sistem Pemesanan Terdepan
                    </span>
                </div>
                
                <!-- Title -->
                <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight" :class="loaded ? 'slide-in-left' : ''" style="animation-delay: 0.4s;">
                    <span class="block">Mieme</span>
                    <span class="block text-blue-200">Website</span>
                </h1>

                <!-- Description -->
                <p class="text-xl lg:text-2xl mb-8 text-blue-100 leading-relaxed" :class="loaded ? 'slide-in-left' : ''" style="animation-delay: 0.6s;">
                    Solusi perut anda yang lapar dan ingin makan mie yang sehat
                </p>

                <!-- Buttons Section -->
                <div class="flex flex-col sm:flex-row gap-4" :class="loaded ? 'slide-in-left' : ''" style="animation-delay: 0.8s;">
                    <button class="group px-8 py-4 bg-white text-blue-600 rounded-2xl font-semibold text-lg hover:bg-blue-50 transform hover:scale-105 transition-all duration-300 hover-lift pulse-glow">
                        <span class="flex items-center justify-center gap-2">
                            <i class="fas fa-rocket group-hover:rotate-12 transition-transform duration-300"></i>
                            Pesan Sekarang
                        </span>
                    </button>
                    <button class="group px-8 py-4 border-2 border-white text-white rounded-2xl font-semibold text-lg hover:bg-white hover:text-blue-600 transform hover:scale-105 transition-all duration-300">
                        <span class="flex items-center justify-center gap-2">
                            <i class="fas fa-play-circle group-hover:scale-110 transition-transform duration-300"></i>
                            Lihat Menu
                        </span>
                    </button>
                </div>
            </div>

            <!-- Right Section (Floating Cards) -->
            <div class="lg:w-1/2 flex justify-center" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
                <div class="relative w-full" :class="loaded ? 'slide-in-right' : ''">
                    <!-- Main Card -->
                    <div class="glass-effect rounded-3xl p-8 backdrop-blur-lg floating" style="animation-delay: 0s;">
                        <div class="text-center text-white">
                            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-utensils text-3xl"><img src="{{ asset('assets/img/mieme/Logo Mentaly.png') }}" alt="logo"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Order Mudah Dengan Mieme</h3>
                            <p class="text-blue-100">Pesan makanan dengan teknologi AI</p>
                        </div>
                    </div>
                    
                    <!-- Floating Stats Cards -->
                    <div class="absolute -top-6 -right-6 glass-effect rounded-2xl p-4 text-white floating" style="animation-delay: 1s;">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-300">4.9★</div>
                            <div class="text-sm text-blue-100">Rating</div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-6 -left-6 glass-effect rounded-2xl p-4 text-white floating" style="animation-delay: 2s;">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-300">1000+</div>
                            <div class="text-sm text-blue-100">Orders</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
        <a href="#about" class="text-white bg-blue-600 bg-opacity-50 rounded-full p-2 inline-block hover:bg-opacity-70 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </a>
    </div>
</section>

<!-- Hot Line Animation (Will appear when scrolling) -->
<div class="fixed bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500 z-50 opacity-0 transition-opacity duration-300" id="hotLine" style="background-size: 200% auto; animation: hotScroll 2s linear infinite;"></div>  

    <!-- Footer -->
    <footer class="py-12 bg-gray-900 text-white">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <div class="text-3xl font-bold mb-4 text-blue-400">Mieme</div>
                <p class="text-gray-400 mb-6">Sistem Pemesanan Makanan Online/Offline Terdepan</p>
                <div class="flex justify-center space-x-6 text-2xl">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transform hover:scale-110 transition-all duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transform hover:scale-110 transition-all duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transform hover:scale-110 transition-all duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transform hover:scale-110 transition-all duration-300">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-800 text-gray-500">
                    © 2025 Mieme. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<style>
    /* Animation Classes */
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animate-fade-in {
        animation: fadeIn 1s ease-out forwards;
    }
    
    .animate-bounce {
        animation: bounce 2s infinite;
    }
    
    .animate-modal-enter {
        animation: modalEnter 0.4s cubic-bezier(0.165, 0.840, 0.440, 1.000) forwards;
    }
    
    /* Hot Scroll Animation */
    @keyframes hotScroll {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }
    
    /* Keyframes */
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
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
    }
    
    @keyframes modalEnter {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #2563eb);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #1d4ed8;
    }
    
    /* Swiper Customization */
    .swiper-container {
        padding: 20px 0 40px;
    }
    
    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: #d1d5db;
        opacity: 1;
    }
    
    .swiper-pagination-bullet-active {
        background: #3b82f6;
    }
    
    .swiper-button-next, 
    .swiper-button-prev {
        color: #3b82f6;
        background: rgba(255, 255, 255, 0.9);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .swiper-button-next:after, 
    .swiper-button-prev:after {
        font-size: 24px;
        font-weight: bold;
    }
    
    /* Font Smoothing */
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    /* Line Clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- YouTube IFrame API -->
<script src="https://www.youtube.com/iframe_api"></script>

<script>
    // =======================
    // Swiper Testimonial Slider
    // =======================
    const testimonialSlider = new Swiper('.testimonial-slider', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // =======================
    // YouTube Video Player
    // =======================
    let player;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('videoContainer', {
            events: {
                'onReady': onPlayerReady,
            }
        });
    }

    function onPlayerReady(event) {
        const playBtn = document.getElementById('playButton');
        playBtn.addEventListener('click', function () {
            this.style.display = 'none';
            document.getElementById('videoContainer').classList.remove('hidden');
            event.target.playVideo();
        });
    }

    // =======================
    // Animated Counter
    // =======================
    function animateCounters() {
        const counters = document.querySelectorAll('.animate-count');
        const speed = 200;

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            const count = +counter.innerText;
            const increment = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(animateCounters, 1);
            } else {
                counter.innerText = target;
            }
        });
    }

    // =======================
    // Scroll Hot Line
    // =======================
    window.addEventListener('scroll', function () {
        const hotLine = document.getElementById('hotLine');
        if (window.scrollY > 100) {
            hotLine.style.opacity = '1';
        } else {
            hotLine.style.opacity = '0';
        }
    });

    // =======================
    // Intersection Observer for Animations
    // =======================
    const observerOptions = { threshold: 0.1 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);

                // Jalankan counter hanya jika bagian 'about' terlihat
                if (entry.target.id === 'about') {
                    animateCounters();
                }
            }
        });
    }, observerOptions);

    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });

    // =======================
    // Quick View Modal
    // =======================
    function showQuickView(menu) {
        document.getElementById('modal-title').textContent = menu.namamenu;
        document.getElementById('modalPrice').textContent = 'Rp ' + menu.harga.toLocaleString('id-ID');
        document.getElementById('modalDescription').textContent = menu.deskripsi;
        document.getElementById('modalCategory').textContent = menu.kategori;
        document.getElementById('modalCode').textContent = menu.kodemenu;

        if (menu.gambar) {
            document.getElementById('modalImage').src = "{{ asset('storage/') }}/" + menu.gambar;
            document.getElementById('modalImage').alt = menu.namamenu;
        }

        document.getElementById('quickViewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('quickViewModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('quickViewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // =======================
    // Alpine.js Scroll Navigator
    // =======================
    document.addEventListener('alpine:init', () => {
        Alpine.data('scrollNavigator', () => ({
            scrollTo(id) {
                const element = document.getElementById(id);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                    history.pushState(null, null, `#${id}`);
                }
            }
        }));
    });
</script>
@endpush
@endsection
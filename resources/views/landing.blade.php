@extends('layout.app')
@section('title', 'Restoran Kami - Pengalaman Kuliner Terbaik')
@section('content')
<!-- Hero Section with Parallax Effect -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <video autoplay muted loop class="w-full h-full object-cover">
            <source src="{{ asset('videos/mieme-video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 bg-black opacity-40 z-10"></div>
    </div>
    
    <div class="relative z-10 text-center px-4 animate-fade-in-up" x-data="scrollNavigator">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Selamat Datang di Restoran Kami</h1>
        <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto">Pengalaman kuliner tak terlupakan dengan bahan-bahan pilihan terbaik</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4" x-data="scrollNavigator">
            <a href="#menu" class="px-8 py-3 bg-blue-600 hover:bg-blue-800 text-white rounded-full font-medium transition-all duration-300 transform hover:scale-105 shadow-lg" @click.prevent="scrollTo('menu')">
                Lihat Menu
            </a>
            <a href="#reservation" class="px-8 py-3 bg-white hover:bg-gray-100 text-blue-600 rounded-full font-medium transition-all duration-300 transform hover:scale-105 shadow-lg" @click.prevent="scrollTo('reservation')">
                Reservasi
            </a>
        </div>
    </div>
    
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#about" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </a>
    </div>
</section>

<!-- About Section with Animated Stats -->
<section id="about" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Tentang Kami</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Restoran kami telah melayani hidangan istimewa sejak 2010, dengan komitmen untuk menyajikan pengalaman kuliner terbaik bagi setiap pelanggan.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-gray-50 p-8 rounded-xl text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2">
                <div class="text-5xl font-bold text-blue-600 mb-4 animate-count" data-count="13">5</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Tahun Pengalaman</h3>
                <p class="text-gray-600">Dalam menyajikan hidangan terbaik</p>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-xl text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2">
                <div class="text-5xl font-bold text-blue-600 mb-4 animate-count" data-count="150">13</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Menu Spesial</h3>
                <p class="text-gray-600">Dari berbagai daerah dan negara</p>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-xl text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2">
                <div class="text-5xl font-bold text-blue-600 mb-4 animate-count" data-count="5000">725</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Pelanggan Puas</h3>
                <p class="text-gray-600">Setiap bulannya</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="relative z-10 rounded-xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('images/chef-cooking.jpg') }}" alt="Chef Kami" class="w-full h-auto">
                </div>
                <div class="absolute -bottom-6 -right-6 z-0 w-3/4 h-3/4 border-4 border-blue-600 rounded-xl"></div>
            </div>
            
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Kisah Kami</h3>
                <p class="text-gray-600 mb-6">Berdiri sejak 2010, restoran kami dimulai dari passion seorang chef yang ingin membawa cita rasa autentik kepada masyarakat. Dengan bahan-bahan segar pilihan dan teknik memasak yang sempurna, kami berkomitmen untuk memberikan pengalaman makan yang tak terlupakan.</p>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="ml-3 text-gray-700">Bahan-bahan segar dari petani lokal terpilih</p>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="ml-3 text-gray-700">Chef profesional dengan pengalaman internasional</p>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="ml-3 text-gray-700">Layanan ramah dan atmosfer yang nyaman</p>
                    </div>
                </div>
                
                <a href="#story" class="inline-block mt-8 px-6 py-3 border border-blue-600 text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300">
                    Baca Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Video Section with YouTube Embed -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Video Kami</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Lihat proses pembuatan hidangan spesial kami dan suasana restoran yang hangat</p>
        </div>
        
        <div class="relative aspect-w-16 aspect-h-9 max-w-4xl mx-auto rounded-xl overflow-hidden shadow-2xl animate-fade-in">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <button id="playButton" class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-800 transition-all transform hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </div>
            <div id="videoContainer" class="hidden">
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/1sqxVH6T8lk?si=qw67F0CRSnFAkFFP" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            {{-- <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="Video Thumbnail" class="w-full h-full object-cover"> --}}
        </div>
    </div>
</section>

<!-- Special Menu Section -->
<section id="menu" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Menu Spesial Kami</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Temukan hidangan istimewa yang dibuat dengan penuh cinta oleh chef kami</p>
        </div>
        
        <div class="flex justify-center mb-12">
            <div class="inline-flex rounded-full bg-gray-100 p-1">
                <button class="px-6 py-2 rounded-full bg-blue-600 text-white font-medium">Semua</button>
                <button class="px-6 py-2 rounded-full hover:bg-gray-200 transition-colors">Makanan</button>
                <button class="px-6 py-2 rounded-full hover:bg-gray-200 transition-colors">Minuman</button>
                <button class="px-6 py-2 rounded-full hover:bg-gray-200 transition-colors">Dessert</button>
            </div>
        </div>
        
        <!-- Menu Grid (Same as your existing menu grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($menu as $item)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ $loop->index * 50 }}ms">
                <!-- Badge Kategori -->
                <div class="absolute top-3 left-3 z-10">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $item->kategori === 'makanan' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white' }}">
                        {{ ucfirst($item->kategori) }}
                    </span>
                </div>
                
                <!-- Favorite Button -->
                <button class="absolute top-3 right-3 z-10 p-2 bg-white bg-opacity-80 rounded-full hover:bg-red-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                
                <!-- Gambar Menu -->
                <div class="h-48 overflow-hidden relative">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->namamenu }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Detail Menu -->
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $item->namamenu }}</h3>
                        <span class="text-lg font-bold text-blue-800">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex items-center mb-2">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 fill-current {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 ml-1">(24)</span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $item->deskripsi }}</p>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <button class="p-1 bg-gray-100 rounded-full hover:bg-gray-200" onclick="showQuickView({{ json_encode($item) }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <span class="text-xs text-gray-500">Lihat Detail</span>
                        </div>
                        
                        <button class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Tambah
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="/menu" class="inline-block px-8 py-3 border border-blue-600 text-blue-600 rounded-full font-medium hover:bg-blue-600 hover:text-white transition-all duration-300">
                Lihat Semua Menu
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Apa Kata Mereka</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Testimoni dari pelanggan setia kami</p>
        </div>
        
        <div class="relative">
            <div class="swiper-container testimonial-slider">
                <div class="swiper-wrapper">
                    <!-- Testimonial 1 -->
                    <div class="swiper-slide">
                        <div class="bg-white p-8 rounded-xl shadow-md max-w-2xl mx-auto">
                            <div class="flex items-center mb-6">
                                <img src="{{ asset('images/testimonial-1.jpg') }}" alt="Customer" class="w-16 h-16 rounded-full object-cover">
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold">Budi Santoso</h4>
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 italic">"Makanan di sini selalu segar dan lezat. Pelayanannya juga sangat ramah. Sudah menjadi tempat favorit keluarga kami untuk makan bersama."</p>
                        </div>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="swiper-slide">
                        <div class="bg-white p-8 rounded-xl shadow-md max-w-2xl mx-auto">
                            <div class="flex items-center mb-6">
                                <img src="{{ asset('images/testimonial-2.jpg') }}" alt="Customer" class="w-16 h-16 rounded-full object-cover">
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold">Anita Wijaya</h4>
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 italic">"Saya sangat menyukai suasana restoran ini. Makanannya autentik dan harga sangat reasonable untuk kualitas yang diberikan. Pasti akan kembali lagi!"</p>
                        </div>
                    </div>
                    
                    <!-- Testimonial 3 -->
                    <div class="swiper-slide">
                        <div class="bg-white p-8 rounded-xl shadow-md max-w-2xl mx-auto">
                            <div class="flex items-center mb-6">
                                <img src="{{ asset('images/testimonial-3.jpg') }}" alt="Customer" class="w-16 h-16 rounded-full object-cover">
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold">David Kurniawan</h4>
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 italic">"Sebagai food blogger, saya sudah mencoba banyak restoran. Tapi tempat ini benar-benar spesial. Setiap hidangan dibuat dengan penuh perhatian dan cita rasa yang konsisten."</p>
                        </div>
                    </div>
                </div>
                
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="swiper-button-next hidden md:flex"></div>
            <div class="swiper-button-prev hidden md:flex"></div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Lokasi Kami</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Kunjungi restoran kami untuk pengalaman makan yang tak terlupakan</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Jam Operasional</h3>
                <div class="space-y-3 mb-8">
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-700">Senin - Kamis</span>
                        <span class="font-medium">10:00 - 22:00</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-700">Jumat - Sabtu</span>
                        <span class="font-medium">10:00 - 23:00</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-700">Minggu</span>
                        <span class="font-medium">10:00 - 21:00</span>
                    </div>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-blue-600 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="ml-3 text-gray-700">Jl. Restoran Indah No. 123, Kota Anda, 12345</p>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <p class="ml-3 text-gray-700">(021) 1234-5678</p>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="ml-3 text-gray-700">info@restorankami.com</p>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2 h-96 lg:h-full rounded-xl overflow-hidden shadow-xl">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613507864!3d-6.194741395493371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1629297212923!5m2!1sen!2sid" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section id="reservation" class="py-20 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Menikmati Makanan Lezat?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Reservasi sekarang dan dapatkan pengalaman makan terbaik di kota Anda</p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="tel:+622112345678" class="px-8 py-3 bg-white hover:bg-gray-100 text-blue-600 rounded-full font-medium transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Hubungi Kami
            </a>
            <a href="/reservation" class="px-8 py-3 border-2 border-white hover:bg-white hover:bg-opacity-20 rounded-full font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                Reservasi Online
            </a>
        </div>
    </div>
</section>

<!-- Hot Line Animation (Will appear when scrolling) -->
<div class="fixed bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-blue-800 z-50 opacity-0 transition-opacity duration-300" id="hotLine"></div>

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
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #f97316, #ea580c);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #c2410c;
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
        background: #f97316;
    }
    
    .swiper-button-next, 
    .swiper-button-prev {
        color: #f97316;
        background: rgba(255, 255, 255, 0.8);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .swiper-button-next:after, 
    .swiper-button-prev:after {font-size: 24px;
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
    // Scroll Line Animation
    // =======================
    window.addEventListener('scroll', function () {
        const hotLine = document.getElementById('hotLine');
        if (window.scrollY > 100) {
            hotLine.style.opacity = '1';
            hotLine.style.animation = 'hotScroll 2s linear infinite';
        } else {
            hotLine.style.opacity = '0';
            hotLine.style.animation = 'none';
        }
    });

    // =======================
    // Scroll Reveal Animation
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
    }

    function closeModal() {
        document.getElementById('quickViewModal').classList.add('hidden');
    }
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
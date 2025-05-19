@extends('layout.app')

@section('title', 'Landing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header dengan search dan filter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Menu Kami</h1>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <div class="relative flex-grow">
                <input type="text" placeholder="Cari menu favorit..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            
            <select class="bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="">Semua Kategori</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="snack">Snack</option>
            </select>
            
            <select class="bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="">Urutkan</option>
                <option value="popular">Terpopuler</option>
                <option value="newest">Terbaru</option>
                <option value="price-low">Harga: Rendah ke Tinggi</option>
                <option value="price-high">Harga: Tinggi ke Rendah</option>
            </select>
        </div>
    </div>

    <!-- Grid Menu Items -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($menu as $item)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
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
                    <span class="text-lg font-bold text-orange-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
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
                        <button class="p-1 bg-gray-100 rounded-full hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <span class="text-xs text-gray-500">Lihat Detail</span>
                    </div>
                    
                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center transition-colors">
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

    <!-- Pagination -->
    <div class="mt-10 flex justify-center">
        <nav class="flex items-center space-x-2">
            <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
            <button class="px-3 py-1 rounded border border-orange-500 bg-orange-500 text-white">1</button>
            <button class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">2</button>
            <button class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">3</button>
            <button class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">4</button>
            <button class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">5</button>
            <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
        </nav>
    </div>
</div>

<!-- Modal Quick View -->
<div class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="quickViewModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <div class="flex justify-between items-start">
                            <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-title">
                                Nama Menu
                            </h3>
                            <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal()">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-100 rounded-lg overflow-hidden">
                                <img src="" alt="Menu Image" class="w-full h-64 object-cover" id="modalImage">
                            </div>
                            
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 fill-current {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500 ml-2">(24 reviews)</span>
                                </div>
                                
                                <p class="text-gray-800 font-semibold text-xl mb-4" id="modalPrice">Rp 25.000</p>
                                
                                <p class="text-gray-600 mb-6" id="modalDescription">Deskripsi menu akan muncul di sini.</p>
                                
                                <div class="flex items-center mb-6">
                                    <span class="text-gray-700 mr-3">Jumlah:</span>
                                    <div class="flex border border-gray-300 rounded-md">
                                        <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200">-</button>
                                        <input type="number" value="1" min="1" class="w-12 text-center border-x border-gray-300">
                                        <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200">+</button>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-3 px-4 rounded-md font-medium flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                    <button class="px-4 py-3 border border-orange-500 text-orange-500 rounded-md hover:bg-orange-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Informasi Tambahan</h4>
                                    <p class="text-sm text-gray-500">Kategori: <span id="modalCategory" class="text-gray-700">Makanan</span></p>
                                    <p class="text-sm text-gray-500">Kode Menu: <span id="modalCode" class="text-gray-700">M001</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk menampilkan modal quick view
    function showQuickView(menu) {
        document.getElementById('modal-title').textContent = menu.namamenu;
        document.getElementById('modalPrice').textContent = 'Rp ' + menu.harga.toLocaleString('id-ID');
        document.getElementById('modalDescription').textContent = menu.deskripsi;
        document.getElementById('modalCategory').textContent = menu.kategori;
        document.getElementById('modalCode').textContent = menu.kodemenu;
        
        if(menu.gambar) {
            document.getElementById('modalImage').src = "{{ asset('storage/') }}" + '/' + menu.gambar;
            document.getElementById('modalImage').alt = menu.namamenu;
        }
        
        document.getElementById('quickViewModal').classList.remove('hidden');
    }
    
    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('quickViewModal').classList.add('hidden');
    }
    
    // Event listener untuk tombol close
    document.querySelectorAll('[data-close-modal]').forEach(button => {
        button.addEventListener('click', closeModal);
    });
    
    // Event listener untuk klik di luar modal
    document.getElementById('quickViewModal').addEventListener('click', function(e) {
        if(e.target === this) {
            closeModal();
        }
    });
</script>
@endpush
@endsection
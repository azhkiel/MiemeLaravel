@extends('layout.owner')

@section('title', 'Menu')
<!-- Letakkan notifikasi di bagian atas konten -->
@section('content')
    <!-- Notifikasi Sukses -->
    @if (session('success'))
    <div x-data="{ show: true }" 
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed bottom-6 right-6 z-50">
        <div class="bg-gradient-to-r from-emerald-500 to-green-500 text-white px-6 py-4 rounded-xl shadow-2xl border border-emerald-300/30 backdrop-blur-sm flex items-center space-x-4 max-w-md animate-pulse">
            <div class="bg-white/20 rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-1 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Notifikasi Gagal -->
    @if ($errors->any())
    <div x-data="{ show: true }" 
        x-show="show"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        x-init="setTimeout(() => show = false, 8000)"
        class="fixed top-6 right-6 z-50 max-w-md w-full">
        <div class="bg-gradient-to-br from-red-50 to-pink-50 border-l-4 border-red-500 rounded-r-xl p-4 shadow-2xl backdrop-blur-sm border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <div class="bg-red-100 rounded-full p-2">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan dalam pengisian form</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-4">
                        <button @click="show = false" class="text-sm font-medium text-red-700 hover:text-red-600 hover:bg-red-100 px-3 py-1 rounded-lg transition-all duration-200 focus:outline-none">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Background dengan gradient -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-4 py-8" x-data="{ open: {{ isset($menuShow)?'true':'false' }} }">
            <!-- Header yang lebih menarik -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Manajemen Menu</h1>
                        <p class="text-gray-600 mt-1">Kelola menu restoran Anda dengan mudah</p>
                    </div>
                </div>
                <button 
                    @click="open = true"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl flex items-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 group"
                >
                    <div class="bg-white/20 rounded-full p-1 mr-3 group-hover:bg-white/30 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="font-semibold">Tambah Menu</span>
                </button>
            </div>

            <!-- Pop-up Form yang lebih modern -->
            <div 
                x-show="open" 
                class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div 
                    @click.away="open = false"
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-lg border border-blue-100"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                >
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-2xl">
                        <h3 class="text-xl font-bold text-white">{{ isset($menuShow)?'Edit Menu':'Tambah Menu' }}</h3>
                        <button @click="{{ isset($menuShow) 
                            ? "window.location.href = '" . route('menu.index') . "'" 
                            : "open = false"; }}" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ isset($menuShow)?route('menu.update',['id'=>$menuShow->id]):route('menu.simpan')}}" method="post" class="p-6 space-y-4" enctype="multipart/form-data">
                        @csrf
                        @if (isset($menuShow))
                            @method('put')                        
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="kode_menu" class="block text-sm font-semibold text-gray-700 mb-2">Kode Menu</label>
                                <input 
                                    type="text" 
                                    id="kode_menu" 
                                    name="kode_menu" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                    placeholder="MKN001"
                                    value="{{ old('kode_menu',$menuShow->kode_menu??'') }}"
                                    required
                                >
                            </div>
                            
                            <div>
                                <label for="nama_menu" class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu</label>
                                <input 
                                    type="text" 
                                    id="nama_menu" 
                                    name="nama_menu" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                    value="{{ old('nama_menu',$menuShow->nama_menu??'') }}"
                                    placeholder="Nama menu"
                                    required
                                >
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
                                <input 
                                    type="number" 
                                    id="harga" 
                                    name="harga" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                    value="{{ old('harga',$menuShow->harga??'') }}"
                                    placeholder="10000"
                                    required
                                >
                            </div>
                            
                            <div>
                                <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                                <select 
                                    id="kategori" 
                                    name="kategori" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                    value="{{ old('kategori',$menuShow->kategori??'') }}"
                                    required
                                >
                                    <option value="">Pilih Kategori</option>
                                    <option value="makanan" {{ (old('kategori', $menuShow->kategori ?? '') == 'makanan') ? 'selected' : '' }}>Makanan</option>
                                    <option value="minuman" {{ (old('kategori', $menuShow->kategori ?? '') == 'minuman') ? 'selected' : '' }}>Minuman</option>
                                    <option value="dessert" {{ (old('kategori', $menuShow->kategori ?? '') == 'dessert') ? 'selected' : '' }}>Dessert</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="3" 
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white resize-none"
                                placeholder="Deskripsi menu"
                            >{{ old('deskripsi',$menuShow->deskripsi??'') }}</textarea>
                        </div>

                        <div>
                            <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">Gambar Menu</label>
                            <input 
                                type="file" 
                                id="gambar" 
                                name="gambar" 
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="image/*"
                            >
                            @if(isset($menuShow) && $menuShow->gambar)
                                <div class="mt-3 flex items-center space-x-3">
                                    <img src="{{ asset('storage/' . $menuShow->gambar) }}" alt="Gambar Menu" class="h-16 w-16 object-cover rounded-lg border-2 border-blue-200">
                                    <p class="text-sm text-gray-600">Gambar saat ini</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-8 pt-4 border-t border-gray-100">
                            <button 
                                type="button" 
                                @click="{{ isset($menuShow) 
                                    ? "window.location.href = '" . route('menu.index') . "'" 
                                    : "open = false"; }}" 
                                class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200 font-medium"
                            >
                                Batal
                            </button>

                            <button 
                                type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        
            <!-- Tabel yang lebih modern -->
            <div class="bg-white/80 backdrop-blur-sm shadow-2xl rounded-2xl overflow-hidden border border-blue-100">
                <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 rounded-lg p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-white">Daftar Menu</h2>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kode Menu</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Menu</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Gambar</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($menu as $item)
                                <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">{{ $item->kode_menu }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama_menu }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-semibold">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                            {{ $item->kategori === 'makanan' ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200' : 
                                               ($item->kategori === 'minuman' ? 'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200' : 
                                               'bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-200') }}">
                                            {{ ucfirst($item->kategori) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $item->deskripsi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->gambar)
                                        <h1>{{ $item->gambar }}</h1>
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Menu" class="h-14 w-14 object-cover rounded-xl border-2 border-blue-200 group-hover:border-blue-300 transition-all duration-200 shadow-sm group-hover:shadow-md">
                                        @else
                                            <div class="h-14 w-14 bg-gray-100 rounded-xl border-2 border-gray-200 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('menu.edit',['kodeMenu'=>$item->kode_menu]) }}" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-lg px-3 py-2 flex items-center transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105 group">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 group-hover:rotate-12 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                <span class="text-xs font-semibold">Edit</span>
                                            </a>
                                            <form action="{{ route('menu.hapus', ['kodeMenu'=>$item->kode_menu]) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white rounded-lg px-3 py-2 flex items-center transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105 group">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 group-hover:rotate-12 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs font-semibold">Hapus</span>
                                                </button>
                                            </form>
                                            
                                            @push('scripts')
                                            <script>
                                            function confirmDelete(button) {
                                                Swal.fire({
                                                    title: 'Apakah Anda yakin?',
                                                    text: "Data yang dihapus tidak dapat dikembalikan!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Ya, Hapus!',
                                                    cancelButtonText: 'Batal',
                                                    reverseButtons: true
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        // Submit the form when confirmed
                                                        button.closest('form').submit();
                                                    }
                                                });
                                            }
                                            </script>
                                            @endpush
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <div class="bg-blue-100 rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="font-medium">Menampilkan {{ count($menu) }} menu</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-4 py-2 rounded-full text-xs font-bold">
                                Total: {{ count($menu) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
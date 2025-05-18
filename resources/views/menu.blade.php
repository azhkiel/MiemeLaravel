@extends('layout.app')

@section('title', 'Menu')
<!-- Letakkan notifikasi di bagian atas konten -->
@section('content')
    <!-- Notifikasi Sukses -->
    @if (session('success'))
    <div x-data="{ show: true }" 
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-4"
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed bottom-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-4 max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-white hover:text-green-100">
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
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-init="setTimeout(() => show = false, 8000)"
        class="fixed top-4 right-4 z-50 max-w-md w-full">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
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
                        <button @click="show = false" class="text-sm font-medium text-red-700 hover:text-red-600 focus:outline-none">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="container mx-auto px-4 py-8" x-data="{ open: {{ isset($menuShow)?'true':'false' }} }">
        <!-- Header dan Tombol Tambah -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Menu</h1>
            <button 
                @click="open = true"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Menu
            </button>
        </div>
        <!-- Pop-up Form Tambah Menu -->
        <div 
            x-show="open" 
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div 
                @click.away="open = false"
                class="bg-white rounded-lg shadow-xl w-full max-w-md"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">{{ isset($menuShow)?'Edit Menu':'Tambah' }}</h3>
                    <button @click="{{ isset($menuShow) 
                        ? "window.location.href = '" . route('menu.index') . "'" 
                        : "open = false"; }}" class="text-gray-400 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ isset($menuShow)?route('menu.update',['id'=>$menuShow->id]):route('menu.simpan')}}" method="post" class="p-6 enctype="multipart/form-data">
                    @csrf
                    @if (isset($menuShow))
                        @method('put')                        
                    @endif
                    <div class="mb-4">
                        <label for="kodemenu" class="block text-sm font-medium text-gray-700 mb-1">Kode Menu</label>
                        <input 
                            type="text" 
                            id="kodemenu" 
                            name="kodemenu" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="MKN001"
                            value="{{ old('kodemenu',$menuShow->kodemenu??'') }}"
                            required
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="namamenu" class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
                        <input 
                            type="text" 
                            id="namamenu" 
                            name="namamenu" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            value="{{ old('namamenu',$menuShow->namamenu??'') }}"
                            placeholder="Nama menu"
                            required
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <input 
                            type="number" 
                            id="harga" 
                            name="harga" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            value="{{ old('harga',$menuShow->harga??'') }}"
                            placeholder="10000"
                            required
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select 
                            id="kategori" 
                            name="kategori" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            value="{{ old('kategori',$menuShow->kategori??'') }}"
                            required
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="dessert">Dessert</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            value="{{ old('deskripsi',$menuShow->deskripsi??'') }}"
                            placeholder="Deskripsi menu"
                        ></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Menu</label>
                        <input 
                            type="file" 
                            id="gambar" 
                            name="gambar" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            accept="image/*"
                        >
                        @if(isset($menuShow) && $menuShow->gambar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $menuShow->gambar) }}" alt="Gambar Menu" class="h-20">
                                <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button 
                            type="button" 
                            @click="{{ isset($menuShow) 
                                ? "window.location.href = '" . route('menu.index') . "'" 
                                : "open = false"; }}" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            Batal
                        </button>

                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Menu</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Menu</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Menu</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($menu as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->kodemenu }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->namamenu }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $item->kategori === 'makanan' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $item->kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->deskripsi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Menu" class="h-12 w-12 object-cover rounded">
                                    @else
                                        <span class="text-gray-400">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('menu.edit',['id'=>$item->id]) }}" class="text-indigo-600 hover:text-indigo-900 rounded-md px-3 py-1 flex transition-colors duration-200">
                                            <!-- Edit Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>Edit
                                        </a>
                                        <form action="{{ route('menu.hapus', ['id' => $item->id]) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-sm bg-red-600 hover:bg-red-700 text-white rounded-md px-3 py-1 flex items-center transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Hapus
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
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-sm text-gray-500">
                Menampilkan {{ count($menu) }} menu
            </div>
        </div>
    </div>
@endsection
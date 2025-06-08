@extends('layout.app')

@section('title', 'Absensi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50" x-data="{ showModal: false, imageUrl: '' }">
    <!-- Header Section with Gradient Background -->
    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 text-white">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-4xl font-bold tracking-tight">Staff Attendance</h1>
                    <p class="text-blue-100 text-lg">
                        Welcome back, 
                        <span class="font-semibold text-yellow-300 bg-yellow-300/20 px-3 py-1 rounded-full">
                            {{ Auth::user()->fullname }}
                        </span>
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <div class="text-2xl font-bold" id="current-time"></div>
                        <div class="text-sm text-blue-100" id="current-date"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8 -mt-4">
        <!-- Main Attendance Card -->
        <div class="bg-white rounded-2xl shadow-2xl border border-blue-100 overflow-hidden transform hover:scale-[1.01] transition-all duration-300">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold">Today's Attendance</h2>
                </div>
            </div>

            <div class="p-8">
                @if($attendance)
                    <!-- Current Status Display -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div class="space-y-2">
                                <p class="text-xl text-gray-700">
                                    Current Status: 
                                    <span class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                    @if($attendance->shift)
                                        <span class="ml-3 px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full font-medium">
                                            Shift: {{ $attendance->shift }}
                                        </span>
                                    @endif
                                </p>

                                @if($attendance->attendance_time)
                                    <p class="text-gray-600 flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Check-in: {{ \Carbon\Carbon::parse($attendance->attendance_time)->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                                    </p>
                                @endif

                                @if($attendance->checkout_time)
                                    <p class="text-gray-600 flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Check-out: {{ \Carbon\Carbon::parse($attendance->checkout_time)->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                                    </p>
                                @endif
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="hidden md:block">
                                <div class="relative">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-green-400 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images Display -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        @if($attendance->image)
                            <div class="group cursor-pointer" @click="showModal = true; imageUrl = '{{ Storage::url($attendance->image) }}'">
                                <div class="relative overflow-hidden rounded-xl shadow-lg group-hover:shadow-2xl transition-all duration-300">
                                    <img src="{{ Storage::url($attendance->image) }}" alt="Check-in Image" 
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="absolute bottom-4 left-4 text-white">
                                            <p class="font-semibold">Check-in Image</p>
                                            <p class="text-sm opacity-90">Click to view full size</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($attendance->checkout_image)
                            <div class="group cursor-pointer" @click="showModal = true; imageUrl = '{{ Storage::url($attendance->checkout_image) }}'">
                                <div class="relative overflow-hidden rounded-xl shadow-lg group-hover:shadow-2xl transition-all duration-300">
                                    <img src="{{ Storage::url($attendance->checkout_image) }}" alt="Checkout Image" 
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="absolute bottom-4 left-4 text-white">
                                            <p class="font-semibold">Checkout Image</p>
                                            <p class="text-sm opacity-90">Click to view full size</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if(!$attendance->checkout_time)
                        <!-- Checkout Form -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="bg-purple-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Ready to Check Out?</h3>
                            </div>
                            
                            <form action="{{ route('staff.attendance.checkout') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                        Upload Checkout Image <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="file" name="image" id="image" required
                                            class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                                            accept="image/*">
                                        <div class="absolute right-3 top-3 text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('image')
                                        <span class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <span class="flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Submit Checkout</span>
                                    </span>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Completion Message -->
                        <div class="text-center p-8 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                            <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Great Job!</h3>
                            <p class="text-gray-600">You have completed your attendance for today.</p>
                        </div>
                    @endif
                @else
                    <!-- Check-in Form -->
                    <div class="space-y-6">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2">Ready to Start Your Day?</h3>
                            <p class="text-gray-600">Please select your shift and upload your attendance image</p>
                        </div>

                        <form action="{{ route('staff.attendance.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <!-- Shift Selection -->
                            <div>
                                <label for="shift" class="block text-sm font-medium text-gray-700 mb-3">Select Your Shift</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="shift" value="Pagi" {{ old('shift') == 'Pagi' ? 'checked' : '' }} 
                                               class="sr-only peer" required>
                                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition-all duration-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">Morning Shift</p>
                                                    <p class="text-sm text-gray-600">Before 07:00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="shift" value="Siang" {{ old('shift') == 'Siang' ? 'checked' : '' }} 
                                               class="sr-only peer" required>
                                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition-all duration-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">Day Shift</p>
                                                    <p class="text-sm text-gray-600">Before 14:00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="shift" value="Sore" {{ old('shift') == 'Sore' ? 'checked' : '' }} 
                                               class="sr-only peer" required>
                                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition-all duration-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">Evening Shift</p>
                                                    <p class="text-sm text-gray-600">Before 18:00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('shift')
                                    <span class="text-red-500 text-sm flex items-center mt-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Attendance Image <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="image" id="image" required
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                        accept="image/*">
                                    <div class="absolute right-3 top-3 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="text-red-500 text-sm flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6 rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Submit Attendance</span>
                                </span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Attendance Calendar -->
        <div class="mt-12 bg-white rounded-2xl shadow-2xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold">Attendance Calendar</h3>
                </div>
            </div>
            
            <div class="p-6">
                <div id="attendance-calendar" class="mb-6"></div>
                
                <!-- Legend -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 shadow-sm"></div>
                        <span class="text-sm font-medium text-gray-700">Present</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 shadow-sm"></div>
                        <span class="text-sm font-medium text-gray-700">Late</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded-full bg-gradient-to-r from-red-400 to-pink-500 shadow-sm"></div>
                        <span class="text-sm font-medium text-gray-700">Absent</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Management Section -->
        <div class="mt-12 bg-white rounded-2xl shadow-2xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H5m14 8H5"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold">Table Management</h3>
                </div>
            </div>

            <div class="p-6">
                @if($mejas->whereIn('ketersediaan', ['reserved', 'not available'])->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-blue-50">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Table Number</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Capacity</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($mejas->whereIn('ketersediaan', ['reserved', 'not available']) as $meja)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-white font-bold text-sm">{{ $meja->nomor_meja }}</span>
                                            </div>
                                            <span class="font-semibold text-gray-900">Table {{ $meja->nomor_meja }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-900">{{ $meja->kapasitas }} people</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($meja->ketersediaan === 'reserved') 
                                                bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border border-yellow-200
                                            @else 
                                                bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200
                                            @endif">
                                            @if($meja->ketersediaan === 'reserved')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                </svg>
                                            @endif
                                            {{ ucfirst($meja->ketersediaan) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('staff.meja.makeAvailable', $meja->id) }}">
                                            @csrf
                                            <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Set Available
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">All Tables Available!</h4>
                        <p class="text-gray-600">No tables are currently reserved or unavailable.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" @click="showModal = false"></div>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">Attendance Image</h3>
                        <button @click="showModal = false" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <img :src="imageUrl" alt="Attendance Image" class="w-full h-auto rounded-xl shadow-lg">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Alerts -->
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3B82F6',
                confirmButtonText: 'Great!',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    title: 'text-gray-800',
                    content: 'text-gray-600',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'Try Again',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    title: 'text-gray-800',
                    content: 'text-gray-600',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            });
        });
    </script>
@endif
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
    <style>
        .fc-event {
            border: none !important;
            border-radius: 8px !important;
            padding: 2px 6px !important;
            font-weight: 500 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        }
        .fc-event:hover {
            transform: scale(1.05) !important;
            transition: transform 0.2s ease !important;
        }
        .fc-day-today {
            background: linear-gradient(135deg, #EBF8FF 0%, #DBEAFE 100%) !important;
        }
        .fc-daygrid-day:hover {
            background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%) !important;
            transition: background 0.2s ease !important;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Real-time clock
        function updateClock() {
            const now = new Date();
            const timeOptions = { 
                timeZone: 'Asia/Jakarta', 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            };
            const dateOptions = { 
                timeZone: 'Asia/Jakarta', 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            
            const timeElement = document.getElementById('current-time');
            const dateElement = document.getElementById('current-date');
            
            if (timeElement) timeElement.textContent = now.toLocaleTimeString('id-ID', timeOptions);
            if (dateElement) dateElement.textContent = now.toLocaleDateString('id-ID', dateOptions);
        }
        
        updateClock();
        setInterval(updateClock, 1000);

        // Calendar setup
        const calendarEl = document.getElementById('attendance-calendar');
        if (!calendarEl) return;

        function getJakartaDate() {
            const d = new Date();
            const utc = d.getTime() + (d.getTimezoneOffset() * 60000);
            const jakartaTime = new Date(utc + 7 * 3600000);
            return jakartaTime.toISOString().split('T')[0];
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 600,
            initialDate: getJakartaDate(),
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: [
                @foreach($history as $entry)
                    @php
                        $status = ucfirst($entry->status);
                        $color = match ($entry->status) {
                            'present' => '#10B981',
                            'absent'  => '#EF4444',
                            'late'    => '#F59E0B',
                            default   => '#8B5CF6',
                        };

                        $tooltip = "Staff: {$entry->user->fullname}\\nStatus: $status";
                        if ($entry->shift) $tooltip .= "\\nShift: " . $entry->shift;
                        if ($entry->attendance_time) {
                            $tooltip .= "\\nCheck-in: " . \Carbon\Carbon::parse($entry->attendance_time)->timezone('Asia/Jakarta')->format('H:i') . " WIB";
                        }
                        if ($entry->checkout_time) {
                            $tooltip .= "\\nCheck-out: " . \Carbon\Carbon::parse($entry->checkout_time)->timezone('Asia/Jakarta')->format('H:i') . " WIB";
                        }
                        $tooltip .= "\\nClick to view image";

                        $imageUrl = $entry->checkout_image 
                            ? Storage::url($entry->checkout_image) 
                            : ($entry->image ? Storage::url($entry->image) : '#');
                    @endphp
                    {
                        title: '{{ $status }}',
                        start: '{{ $entry->attendance_date->format('Y-m-d') }}',
                        color: '{{ $color }}',
                        url: '{{ $imageUrl }}',
                        extendedProps: {
                            tooltip: `{!! addslashes($tooltip) !!}`
                        }
                    },
                @endforeach
            ],

            eventDidMount: function(info) {
                const tooltip = document.createElement('div');
                tooltip.className = 'fixed bg-gray-800 text-white text-sm rounded-lg px-3 py-2 z-50 shadow-xl border border-gray-600 hidden pointer-events-none';
                tooltip.style.maxWidth = '250px';
                tooltip.innerHTML = info.event.extendedProps.tooltip.replace(/\\n/g, '<br>');
                document.body.appendChild(tooltip);

                info.el.addEventListener('mouseenter', function(e) {
                    tooltip.classList.remove('hidden');
                    tooltip.style.left = (e.pageX + 10) + 'px';
                    tooltip.style.top = (e.pageY - 10) + 'px';
                });

                info.el.addEventListener('mouseleave', function() {
                    tooltip.classList.add('hidden');
                });

                info.el.addEventListener('mousemove', function(e) {
                    tooltip.style.left = (e.pageX + 10) + 'px';
                    tooltip.style.top = (e.pageY - 10) + 'px';
                });
            },

            eventClick: function(info) {
                if (info.event.url && info.event.url !== "#") {
                    // Use Alpine.js to show modal
                    Alpine.store('imageModal', {
                        show: true,
                        url: info.event.url
                    });
                    info.jsEvent.preventDefault();
                }
            }
        });

        calendar.render();
    });
</script>
@endpush
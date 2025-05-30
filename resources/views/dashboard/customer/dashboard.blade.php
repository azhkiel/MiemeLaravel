@extends('layout.dash')
@section('title','dashboard')
@section('content')
<header class="bg-gradient-to-r from-blue-50 to-indigo-50 shadow-lg sticky top-0 z-10 backdrop-blur-sm bg-opacity-90 border-b border-blue-100">
    <!-- Your existing header code -->
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Promo Carousel -->
    <div class="relative rounded-2xl overflow-hidden shadow-lg mb-8 h-80">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-amber-400 opacity-90"></div>
        <div class="relative h-full flex items-center px-10">
            <div class="text-white max-w-lg">
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold mb-3 inline-block">Limited Time!</span>
                <h2 class="text-4xl font-bold mb-3">Special Ramen Combo</h2>
                <p class="text-lg mb-5">Get our signature Spicy Tonkotsu Ramen with free drink and side dish for only Rp 75.000</p>
                <button class="bg-white text-orange-600 px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-md">
                    Order Now <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
            <img src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                 alt="Special Ramen" class="absolute right-0 h-full object-cover w-1/2">
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Balance Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Your Balance</h3>
                <div class="bg-indigo-100 p-2 rounded-full">
                    <i class="fas fa-wallet text-indigo-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-2">Rp 125.000</p>
            <div class="flex space-x-2">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Top Up
                </button>
                <button class="border border-indigo-600 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-50 transition">
                    History
                </button>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Current Order</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div class="bg-amber-100 p-3 rounded-full">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
                <div>
                    <p class="font-medium">Spicy Miso Ramen</p>
                    <p class="text-sm text-gray-500">Preparing your order</p>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-amber-400 h-2 rounded-full" style="width: 60%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2 text-right">Estimated delivery: 12:30 PM</p>
        </div>

        <!-- Loyalty Points -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Loyalty Points</h3>
                <div class="bg-rose-100 p-2 rounded-full">
                    <i class="fas fa-crown text-rose-600"></i>
                </div>
            </div>
            <div class="flex items-end mb-2">
                <p class="text-3xl font-bold text-gray-800 mr-2">450</p>
                <span class="text-sm text-gray-500 mb-1">/ 1000 points</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-rose-400 to-pink-500 h-2 rounded-full" style="width: 45%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-3">550 more points for free meal!</p>
        </div>
    </div>

    <!-- Quick Categories -->
    <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">What are you craving?</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="#" class="category-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1 flex flex-col items-center">
                <div class="bg-orange-100 p-3 rounded-full mb-3">
                    <i class="fas fa-fire text-orange-600 text-xl"></i>
                </div>
                <span class="font-medium">Spicy Ramen</span>
                <span class="text-xs text-gray-500">10+ options</span>
            </a>
            <a href="#" class="category-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1 flex flex-col items-center">
                <div class="bg-blue-100 p-3 rounded-full mb-3">
                    <i class="fas fa-fish text-blue-600 text-xl"></i>
                </div>
                <span class="font-medium">Seafood</span>
                <span class="text-xs text-gray-500">Premium taste</span>
            </a>
            <a href="#" class="category-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1 flex flex-col items-center">
                <div class="bg-green-100 p-3 rounded-full mb-3">
                    <i class="fas fa-leaf text-green-600 text-xl"></i>
                </div>
                <span class="font-medium">Vegetarian</span>
                <span class="text-xs text-gray-500">Healthy choice</span>
            </a>
            <a href="#" class="category-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1 flex flex-col items-center">
                <div class="bg-purple-100 p-3 rounded-full mb-3">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <span class="font-medium">Chef's Special</span>
                <span class="text-xs text-gray-500">Limited edition</span>
            </a>
        </div>
    </div>

    <!-- Recommended For You -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Recommended For You</h3>
            <a href="#" class="text-indigo-600 text-sm font-medium flex items-center">
                View All <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Menu Item 1 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1617093727343-374698b1b188?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                         alt="Tonkotsu Ramen" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md">
                        <i class="fas fa-heart text-rose-400"></i>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-lg">Tonkotsu Ramen</h4>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Popular</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">Rich pork broth with chashu pork</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-orange-600">Rp 65.000</span>
                        <button class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu Item 2 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                         alt="Spicy Miso Ramen" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md">
                        <i class="far fa-heart text-gray-400 hover:text-rose-400"></i>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-lg">Spicy Miso Ramen</h4>
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Hot!</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">Spicy miso broth with ground pork</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-orange-600">Rp 70.000</span>
                        <button class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu Item 3 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1585032226651-759b368d7246?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                         alt="Vegetable Ramen" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md">
                        <i class="far fa-heart text-gray-400 hover:text-rose-400"></i>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-lg">Vegetable Ramen</h4>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Healthy</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">Vegetable broth with seasonal veggies</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-orange-600">Rp 55.000</span>
                        <button class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Recent Orders</h3>
            <a href="#" class="text-indigo-600 text-sm font-medium flex items-center">
                View All <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-100">
                <!-- Order 1 -->
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 p-2 rounded-full">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Order #MIE-7892</p>
                                <p class="text-sm text-gray-500">May 15, 2023 • 12:30 PM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">Rp 125.000</p>
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800">Delivered</span>
                        </div>
                    </div>
                    <div class="pl-12">
                        <p class="text-sm text-gray-600">Tonkotsu Ramen, Gyoza (3pcs), Green Tea</p>
                        <button class="text-indigo-600 text-sm font-medium mt-2 flex items-center">
                            Reorder <i class="fas fa-redo ml-1 text-xs"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Order 2 -->
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i class="fas fa-truck text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Order #MIE-7854</p>
                                <p class="text-sm text-gray-500">May 14, 2023 • 6:45 PM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">Rp 95.000</p>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800">On the way</span>
                        </div>
                    </div>
                    <div class="pl-12">
                        <p class="text-sm text-gray-600">Spicy Miso Ramen, Edamame</p>
                        <button class="text-indigo-600 text-sm font-medium mt-2 flex items-center">
                            Track Order <i class="fas fa-map-marker-alt ml-1 text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Floating Action Button -->
<div class="fixed bottom-6 right-6 z-20">
    <button class="bg-gradient-to-r from-orange-500 to-amber-500 text-white p-4 rounded-full shadow-xl hover:shadow-2xl transition-all transform hover:scale-110">
        <i class="fas fa-utensils text-xl"></i>
    </button>
</div>
@endsection
@extends('layout.own')

@section('title', 'Dashboard Owner')

@section('content')
<div class="flex">
    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Welcome to the Owner Dashboard</h2>

        <!-- Add widgets or important information here -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Example widget -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800">Total Orders</h3>
                <p class="text-gray-600 mt-2">Display total number of orders or any other data you want to showcase.</p>
            </div>

            <!-- Another widget example -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800">New Menu Added</h3>
                <p class="text-gray-600 mt-2">Display the latest menu or any relevant data.</p>
            </div>

            <!-- Additional widgets -->
        </div>
    </div>
</div>
@endsection

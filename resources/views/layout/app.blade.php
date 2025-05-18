<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>@yield('title') | Mieme</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</head>
<body>
    <div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 5000)"
     ...>
     <main>
        @yield('content') <!-- DI SINI isi dari section 'content' akan muncul -->
    </main>
</body>
</html>
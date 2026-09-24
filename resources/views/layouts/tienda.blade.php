<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body 
    x-data="{ cartOpen: false }" 
    @toggle-cart.window="cartOpen = !cartOpen"
    class="bg-gray-50 dark:bg-gray-900">

    <x-tienda.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-tienda.footer />

    {{-- El carrito siempre debe estar dentro del body para heredar estilos y JS --}}
    <x-carrito-sidebar />

    <script>
        // Función global para cargar y abrir
        function openCartAndLoad() {
            window.dispatchEvent(new CustomEvent('toggle-cart'));
            if (typeof loadCartItems === 'function') {
                loadCartItems();
            }
        }
    </script>
</body>
</html>
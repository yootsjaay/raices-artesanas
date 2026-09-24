<!DOCTYPE html>
{{-- Sincronizamos el tema oscuro con la variable 'dark' de Alpine --}}
<html :class="{ 'dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', config('app.name'))</title>

<meta name="description" content="@yield('description','Artesanías hechas a mano desde Oaxaca.')">

<meta name="theme-color" content="#7c3aed">

<link rel="icon" href="{{ asset('favicon.ico') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

@vite(['resources/css/app.css','resources/js/app.js'])

@stack('css')

</head>
<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

        @include('layouts.navegation-menu')

        <div class="flex flex-col flex-1 w-full">
            @include('layouts.navegation-header')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('js')
</body>
</html>
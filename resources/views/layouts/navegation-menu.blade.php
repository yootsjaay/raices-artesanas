<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0 shadow-xl">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ route('dashboard') }}">
            Raíces Artesanas
        </a>
        
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if(request()->routeIs('dashboard'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'text-gray-800 dark:text-gray-100' : '' }}"
                    href="{{ route('dashboard') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>

        <hr class="my-4 border-gray-200 dark:border-gray-700">

        <ul>
            {{-- SECCIÓN EXCLUSIVA PARA ADMIN --}}
            @role('Admin')
            <li class="relative px-6 py-3">
                @if(request()->routeIs('admin.categorias.*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('admin.categorias.*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
                    href="{{ route('admin.categorias.index') }}">
                    <i class="fa-solid fa-tags"></i>
                    <span class="ml-4">Categorías</span>
                </a>
            </li>
            
            <li class="relative px-6 py-3">
                @if(request()->routeIs('admin.presentaciones.*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('admin.presentaciones.*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
                    href="{{ route('admin.presentaciones.index') }}">
                    <i class="fa-solid fa-box-archive"></i>
                    <span class="ml-4">Presentaciones</span>
                </a>
            </li>
            @endrole

            {{-- SECCIÓN COMPARTIDA: ADMIN Y ARTESANOS --}}
            @hasanyrole('Admin|Artesano')
            <li class="relative px-6 py-3">
                @if(request()->routeIs('artesano.productos.*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('artesano.productos.*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
                    href="{{ route('artesano.productos.index') }}">
                    <i class="fa-solid fa-shirt"></i>
                    <span class="ml-4">
                        @role('Admin') Todos los Productos @else Mis Productos @endrole
                    </span>
                </a>
            </li>

            <li class="relative px-6 py-3">
                @if(request()->routeIs('artesano.ventas.*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('artesano.ventas.*') ? 'text-gray-800 dark:text-gray-100' : '' }}"
                    href="{{ route('artesano.ventas.index') }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="ml-4">
                        @role('Admin') Ventas Globales @else Mis Ventas @endrole
                    </span>
                </a>
            </li>
            @endhasanyrole
        </ul>

        {{-- BOTÓN DE ACCIÓN RÁPIDA --}}
        @can('publicar.artesania')
        <div class="px-6 my-6">
            <a href="{{ route('artesano.productos.create') }}"
                class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Nuevo Producto
                <span class="ml-2" aria-hidden="true">+</span>
            </a>
        </div>
        @endcan
    </div>
</aside>
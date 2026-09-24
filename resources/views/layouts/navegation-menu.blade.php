{{-- resources/views/layouts/navegation-menu.blade.php --}}

{{-- Overlay móvil --}}
<div x-show="isSideMenuOpen"
     @click="isSideMenuOpen = false"
     x-transition:enter="transition ease-in-out duration-150"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in-out duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-10 bg-black/50 md:hidden">
</div>

{{-- Sidebar --}}
<aside
    :class="isSideMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    class="fixed inset-y-0 left-0 z-20 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700
           flex flex-col transition-transform duration-300 ease-in-out md:static md:translate-x-0">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100 dark:border-gray-700">
        <div class="w-9 h-9 bg-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-hand-sparkles text-white text-sm"></i>
        </div>
        <div>
            <p class="text-sm font-black text-gray-800 dark:text-white leading-tight">Raíces</p>
            <p class="text-xs text-purple-600 font-bold leading-tight">Artesanas</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                  {{ request()->routeIs('dashboard')
                     ? 'bg-purple-600 text-white shadow-md shadow-purple-500/25'
                     : 'text-gray-600 dark:text-gray-400 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400' }}">
            <i class="fas fa-home w-4 text-center flex-shrink-0"></i>
            <span>Dashboard</span>
        </a>

        <div class="pt-3 pb-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Catálogo</p>
        </div>

        <a href="{{ route('administrador.productos.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                  {{ request()->routeIs('administrador.productos.*')
                     ? 'bg-purple-600 text-white shadow-md shadow-purple-500/25'
                     : 'text-gray-600 dark:text-gray-400 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400' }}">
            <i class="fas fa-box w-4 text-center flex-shrink-0"></i>
            <span>Productos</span>
        </a>

        <a href="{{ route('administrador.categorias.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                  {{ request()->routeIs('administrador.categorias.*')
                     ? 'bg-purple-600 text-white shadow-md shadow-purple-500/25'
                     : 'text-gray-600 dark:text-gray-400 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400' }}">
            <i class="fas fa-folder-open w-4 text-center flex-shrink-0"></i>
            <span>Categorías</span>
        </a>

        <a href="{{ route('administrador.presentaciones.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                  {{ request()->routeIs('administrador.presentaciones.*')
                     ? 'bg-purple-600 text-white shadow-md shadow-purple-500/25'
                     : 'text-gray-600 dark:text-gray-400 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400' }}">
            <i class="fas fa-tags w-4 text-center flex-shrink-0"></i>
            <span>Presentaciones</span>
        </a>

        <div class="pt-3 pb-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Envíos</p>
        </div>

        <a href="{{ route('administrador.paquetes.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                  {{ request()->routeIs('administrador.paquetes.*')
                     ? 'bg-purple-600 text-white shadow-md shadow-purple-500/25'
                     : 'text-gray-600 dark:text-gray-400 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400' }}">
            <i class="fas fa-box-open w-4 text-center flex-shrink-0"></i>
            <span>Paquetes</span>
        </a>

        @role('administrador')
        <div class="pt-3 pb-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Configuración</p>
        </div>

        <a href="{{ route('administrador.roles.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                  {{ request()->routeIs('administrador.roles.*')
                     ? 'bg-purple-600 text-white shadow-md shadow-purple-500/25'
                     : 'text-gray-600 dark:text-gray-400 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400' }}">
            <i class="fas fa-shield-halved w-4 text-center flex-shrink-0"></i>
            <span>Roles y Permisos</span>
        </a>
        @endrole

    </nav>

    {{-- Footer --}}
    <div class="px-3 py-4 border-t border-gray-100 dark:border-gray-700">
        <a href="{{ route('tienda.index') }}" target="_blank"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-gray-500 dark:text-gray-400
                  hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 transition-all duration-200">
            <i class="fas fa-store w-4 text-center flex-shrink-0"></i>
            <span>Ver Tienda</span>
            <i class="fas fa-external-link-alt text-xs ml-auto opacity-50"></i>
        </a>
    </div>

</aside>
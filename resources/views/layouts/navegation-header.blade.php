{{-- resources/views/layouts/navegation-header.blade.php --}}
<header class="z-10 py-3 px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm flex-shrink-0">
    <div class="flex items-center justify-between">

        {{-- --}}
        <button @click="isSideMenuOpen = !isSideMenuOpen"
                class="p-2 rounded-lg md:hidden text-gray-500 dark:text-gray-400
                       hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                aria-label="Abrir menú">
            <i class="fas fa-bars text-lg"></i>
        </button>

        {{-- Título --}}
        <div class="hidden md:block">
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                @yield('title', 'Panel Administrativo')
            </span>
        </div>

        {{-- Acciones --}}
        <div class="flex items-center gap-2 ml-auto">

            {{-- Dark mode --}}
            <button @click="toggleTheme()"
                    class="p-2 rounded-lg text-gray-500 dark:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                    aria-label="Cambiar tema">
                <i x-show="!dark" class="fas fa-moon"></i>
                <i x-show="dark" class="fas fa-sun text-yellow-400"></i>
            </button>

            {{-- Separador --}}
            <div class="w-px h-6 bg-gray-200 dark:bg-gray-700 mx-1"></div>

            {{-- Avatar dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-2 py-1.5 rounded-xl
                               hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    {{-- Inicial del nombre --}}
                    <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-sm font-black flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 max-w-[120px] truncate leading-tight">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-[10px] text-gray-400 capitalize leading-tight">
                            {{ Auth::user()->getRoleNames()->first() ?? 'usuario' }}
                        </p>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] text-gray-400 hidden sm:block transition-transform duration-200"
                       :class="{ 'rotate-180': open }"></i>
                </button>

                {{-- Dropdown --}}
                <div x-show="open"
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-800 rounded-2xl shadow-xl
                            border border-gray-100 dark:border-gray-700 py-2 z-50">

                    <div class="px-4 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-gray-400 truncate mt-0.5">{{ Auth::user()->email }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 dark:text-gray-400
                              hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 transition-colors duration-150">
                        <i class="fas fa-user-circle text-xs w-4 text-center"></i>
                        Mi Perfil
                    </a>

                    <a href="{{ route('tienda.index') }}" target="_blank"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 dark:text-gray-400
                              hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-600 transition-colors duration-150">
                        <i class="fas fa-store text-xs w-4 text-center"></i>
                        Ver Tienda
                    </a>

                    <div class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-red-500
                                       hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-150">
                                <i class="fas fa-sign-out-alt text-xs w-4 text-center"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
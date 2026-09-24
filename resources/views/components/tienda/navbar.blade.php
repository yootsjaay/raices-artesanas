<nav x-data="{ mobileOpen: false }" 
     class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2 font-black text-lg text-purple-600">
            <i class="fas fa-hand-sparkles" aria-hidden="true"></i>
            Raíces Artesanas
        </a>

        {{-- Menú desktop --}}
        <div class="hidden md:flex items-center gap-6 text-sm font-bold text-gray-600 dark:text-gray-300">
            <a href="#productos" class="flex items-center gap-1 hover:text-purple-600 transition-colors duration-200">
                <i class="fas fa-store" aria-hidden="true"></i> Productos
            </a>
            <a href="" class="flex items-center gap-1 hover:text-purple-600 transition-colors duration-200">
                <i class="fas fa-map-marked-alt" aria-hidden="true"></i> Regiones
            </a>
            <a href="" class="flex items-center gap-1 hover:text-purple-600 transition-colors duration-200">
                <i class="fas fa-info-circle" aria-hidden="true"></i> Nosotros
            </a>
        </div>

        {{-- Acciones --}}
        <div class="flex items-center gap-3">

            {{-- Carrito --}}
            <button 
                @click="window.dispatchEvent(new CustomEvent('toggle-cart'))"
                aria-label="Abrir carrito"
                class="relative group p-2 transition-colors">
                <i class="fas fa-shopping-cart text-lg text-gray-600 dark:text-gray-300 group-hover:text-purple-600" aria-hidden="true"></i>
                <span id="cart-count"
                      class="absolute top-0 right-0 bg-purple-600 text-white text-[10px] font-black w-5 h-5 
                             items-center justify-center rounded-full border-2 border-white dark:border-gray-900 
                             transform translate-x-1 -translate-y-1 hidden">
                    0
                </span>
            </button>

            {{-- Auth --}}
            @auth
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-circle text-purple-600 text-lg" aria-hidden="true"></i>
                    <span class="text-sm font-bold max-w-[120px] truncate" title="{{ Auth::user()->name }}">
                        {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center gap-1 text-red-500 text-sm hover:text-red-700 transition-colors duration-200">
                            <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Salir
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   class="hidden sm:flex items-center gap-1 text-sm font-bold hover:text-purple-600 transition-colors duration-200">
                    <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login
                </a>
                <a href="{{ route('register') }}"
                   class="flex items-center gap-1 bg-purple-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-purple-700 transition-colors duration-200">
                    <i class="fas fa-user-plus" aria-hidden="true"></i> Registro
                </a>
            @endauth

            {{-- Hamburguesa móvil --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:text-purple-600 transition-colors duration-200"
                    aria-label="Abrir menú">
                <i x-show="!mobileOpen" class="fas fa-bars text-lg" aria-hidden="true"></i>
                <i x-show="mobileOpen" class="fas fa-times text-lg" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    {{-- Menú móvil --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-4 flex flex-col gap-4 text-sm font-bold text-gray-600 dark:text-gray-300">
        <a href="#productos" @click="mobileOpen = false"
           class="flex items-center gap-2 hover:text-purple-600 transition-colors duration-200">
            <i class="fas fa-store" aria-hidden="true"></i> Productos
        </a>
        <a href="" @click="mobileOpen = false"
           class="flex items-center gap-2 hover:text-purple-600 transition-colors duration-200">
            <i class="fas fa-map-marked-alt" aria-hidden="true"></i> Regiones
        </a>
        <a href="" @click="mobileOpen = false"
           class="flex items-center gap-2 hover:text-purple-600 transition-colors duration-200">
            <i class="fas fa-info-circle" aria-hidden="true"></i> Nosotros
        </a>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route("carrito.load") }}')
            .then(res => res.json())
            .then(data => {
                if (data.items) {
                    const total = data.items.reduce((sum, item) => sum + item.cantidad, 0);
                    window.updateCartCount(total);
                }
            })
            .catch(err => console.error("Error inicializando contador:", err));
    });

    window.updateCartCount = function (count) {
        const badge = document.getElementById('cart-count');
        if (!badge) return;
        badge.innerText = count;
        // Mostrar u ocultar según si hay items
        badge.classList.toggle('hidden', count <= 0);
        badge.classList.toggle('flex', count > 0);
    };
</script>
@endpush
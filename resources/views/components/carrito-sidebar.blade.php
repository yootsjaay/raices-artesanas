{{-- resources/views/components/carrito-sidebar.blade.php --}}
<div x-data="{
        open: false,
        loading: false,
        items: [],
        total: 0,

        init() {
            window.addEventListener('toggle-cart', () => {
                this.open = true;
                this.loadItems();
            });
        },

        async loadItems() {
            this.loading = true;
            try {
                const res = await fetch('{{ route('carrito.load') }}');
                const data = await res.json();
                this.items = data.items ?? [];
                this.total = this.items.reduce((s, i) => s + i.precio * i.cantidad, 0);
            } finally {
                this.loading = false;
            }
        },

        async updateQty(id, action) {
            await fetch('{{ route('carrito.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ producto_id: id, action })
            });
            await this.loadItems();
            this.syncBadge();
        },

        async remove(id) {
            await fetch('{{ route('carrito.remove') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ producto_id: id })
            });
            await this.loadItems();
            this.syncBadge();
        },

        syncBadge() {
            const total = this.items.reduce((s, i) => s + i.cantidad, 0);
            const badge = document.getElementById('cart-count');
            if (!badge) return;
            badge.textContent = total;
            badge.classList.toggle('hidden', total <= 0);
            badge.classList.toggle('flex', total > 0);
        }
     }"
     x-cloak
     class="relative z-[100]">

    {{-- Overlay --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"
         @click="open = false">
    </div>

    {{-- Panel --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 w-full max-w-md bg-white dark:bg-gray-900 shadow-2xl flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between p-6 border-b dark:border-gray-800">
            <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                <i class="fas fa-shopping-cart text-purple-600 mr-2"></i> Tu Carrito
            </h2>
            <button @click="open = false"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Lista --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-4">

            {{-- Spinner --}}
            <div x-show="loading" class="flex flex-col items-center justify-center py-20 text-gray-400">
                <i class="fas fa-circle-notch fa-spin text-3xl mb-4 text-purple-500"></i>
                <p class="text-sm">Cargando tu carrito...</p>
            </div>

            {{-- Vacío --}}
            <div x-show="!loading && items.length === 0"
                 class="flex flex-col items-center justify-center py-20 text-gray-400">
                <i class="fas fa-shopping-basket text-5xl mb-4 opacity-20"></i>
                <p class="text-sm font-medium">Tu carrito está vacío</p>
                <p class="text-xs text-gray-300 mt-1">¡Agrega alguna pieza artesanal!</p>
            </div>

            {{-- Items --}}
            <template x-for="item in items" :key="item.id">
                <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-3 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <img :src="item.imagen ? '/storage/' + item.imagen : '/img/default.jpg'"
                         :alt="item.nombre"
                         class="w-16 h-16 object-cover rounded-xl flex-shrink-0">

                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-900 dark:text-white text-xs truncate" x-text="item.nombre"></h4>
                        <p class="font-black text-purple-600 dark:text-purple-400 text-sm mt-0.5"
                           x-text="'$' + item.precio.toFixed(2)"></p>

                        {{-- Controles cantidad --}}
                        <div class="flex items-center gap-2 mt-2">
                            <button @click="updateQty(item.id, 'decrement')"
                                    class="w-6 h-6 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-purple-100 dark:hover:bg-purple-900 text-xs font-bold transition-colors duration-150">
                                <i class="fas fa-minus" style="font-size:9px"></i>
                            </button>
                            <span class="text-xs font-bold w-4 text-center dark:text-white" x-text="item.cantidad"></span>
                            <button @click="updateQty(item.id, 'increment')"
                                    class="w-6 h-6 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-purple-100 dark:hover:bg-purple-900 text-xs font-bold transition-colors duration-150">
                                <i class="fas fa-plus" style="font-size:9px"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Eliminar --}}
                    <button @click="remove(item.id)"
                            title="Eliminar producto"
                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-xl bg-red-50 dark:bg-red-900/30 text-red-400 hover:bg-red-100 dark:hover:bg-red-800/50 hover:text-red-600 transition-colors duration-150">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </div>
            </template>
        </div>

        {{-- Footer --}}
        <div class="p-6 border-t dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 space-y-4">
            <div class="flex justify-between items-center text-lg font-bold">
                <span class="text-gray-500 dark:text-gray-400 font-medium">Subtotal</span>
                <span class="text-purple-600 dark:text-purple-400 text-2xl font-black"
                      x-text="'$' + total.toLocaleString('en-US', { minimumFractionDigits: 2 })"></span>
            </div>
            <a href="{{ route('checkout.index') }}"
               class="flex items-center justify-center gap-2 w-full py-4 bg-gray-950 dark:bg-purple-600 text-white rounded-2xl font-bold hover:opacity-90 transition-opacity duration-200 shadow-xl">
                <i class="fas fa-lock text-sm"></i> Finalizar Compra
            </a>
            <button @click="open = false"
                    class="flex items-center justify-center gap-2 w-full text-center text-sm font-bold text-gray-500 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xs"></i> Continuar comprando
            </button>
        </div>
    </div>
</div>
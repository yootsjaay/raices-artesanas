<div x-data="{ adding: false, added: false }"
     class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow hover:shadow-xl transition-shadow duration-300">

    <div class="relative overflow-hidden">
        <img src="{{ asset('storage/'.$producto->img_url) }}"
             alt="{{ $producto->nombre }}"
             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">

        <a href="{{ route('productos.show', $producto->id) }}"
           class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-white px-4 py-2 rounded-xl text-sm font-bold shadow
                  opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
            Ver detalle
        </a>
    </div>

    <div class="p-4">
        <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $producto->nombre }}</h3>
        <p class="text-purple-600 font-black text-lg mt-1">${{ number_format($producto->precio_venta, 2) }}</p>

        <button
            @click="
                if (adding) return;
                adding = true;
                fetch('{{ route('carrito.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ producto_id: {{ $producto->id }}, cantidad: 1 })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        added = true;
                        if (typeof window.updateCartCount === 'function') window.updateCartCount(data.count);
                        setTimeout(() => {
                            window.dispatchEvent(new CustomEvent('toggle-cart'));
                            added = false;
                        }, 600);
                    }
                })
                .finally(() => { adding = false; })
            "
            :disabled="adding"
            class="mt-3 w-full py-2 rounded-xl text-sm font-bold transition-all duration-200
                   disabled:opacity-60 disabled:cursor-not-allowed"
            :class="added
                ? 'bg-green-500 text-white scale-95'
                : 'bg-purple-600 hover:bg-purple-700 text-white hover:scale-[1.02]'">

            <span x-show="!adding && !added">
                <i class="fas fa-cart-plus mr-1"></i> Agregar
            </span>
            <span x-show="adding">
                <i class="fas fa-circle-notch fa-spin mr-1"></i> Agregando...
            </span>
            <span x-show="added">
                <i class="fas fa-check mr-1"></i> ¡Agregado!
            </span>
        </button>
    </div>
</div>
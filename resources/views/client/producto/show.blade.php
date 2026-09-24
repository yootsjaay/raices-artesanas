<x-tienda-layout>
    <x-slot name="title">{{ $producto->nombre }} - Boutique Artesanal | Raíces</x-slot>

    {{-- Estilos para el Zoom y Personalización --}}
    <style>
        .zoom-container { overflow: hidden; cursor: zoom-in; }
        .zoom-container img { transition: transform 0.2s ease-out; transform-origin: center center; }
        .zoom-container:hover img { transform: scale(1.6); }
        
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
        [x-cloak] { display: none !important; }
    </style>

    <div class="py-6 md:py-12 bg-white dark:bg-gray-950" 
         x-data="{ 
            activeImage: '{{ $producto->img_url ? asset('storage/'.$producto->img_url) : asset('img/default.jpg') }}',
            qty: 1,
            images: [
                '{{ $producto->img_url ? asset('storage/'.$producto->img_url) : asset('img/default.jpg') }}',
                @if($producto->imagenes_secundarias)
                    @foreach($producto->imagenes_secundarias as $img)
                        '{{ asset('storage/'.$img) }}',
                    @endforeach
                @endif
            ]
         }">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumbs --}}
            <nav class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-8 pb-4 border-b border-gray-100 dark:border-gray-800">
                <a href="{{ route('tienda.index') }}" class="hover:text-purple-600 transition"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right text-[8px]"></i>
                <span class="truncate text-gray-900 dark:text-gray-200 font-medium">{{ $producto->nombre }}</span>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
                
                {{-- COLUMNA IZQUIERDA: GALERÍA --}}
                <div class="space-y-6">
                    {{-- Imagen Principal --}}
                    <div class="relative aspect-square rounded-3xl overflow-hidden bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 zoom-container shadow-sm"
                         @mousemove="zoom($event)" @mouseleave="resetZoom($event)">
                         <img :src="activeImage"
                              class="w-full h-full object-cover"
                              alt="{{ $producto->nombre }}">
                        
                        @if($producto->persona && $producto->persona->municipio)
                            <span class="absolute top-4 left-4 bg-white/90 dark:bg-black/60 backdrop-blur-md text-gray-900 dark:text-white text-[10px] font-bold px-3 py-1.5 rounded-full z-10 tracking-wider uppercase shadow-sm">
                                <i class="fas fa-map-marker-alt mr-1.5 text-purple-500"></i>{{ $producto->persona->municipio }}
                            </span>
                        @endif
                    </div>

                    {{-- Miniaturas Reales --}}
                    <div x-show="images.length > 1" class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                        <template x-for="(img, index) in images" :key="index">
                            <button @click="activeImage = img" 
                                    class="w-20 h-20 rounded-2xl overflow-hidden border-2 transition-all flex-shrink-0 shadow-sm"
                                    :class="activeImage === img ? 'border-purple-500 ring-4 ring-purple-500/10' : 'border-transparent opacity-70 hover:opacity-100'">
                                <img :src="img" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: INFO --}}
                <div class="flex flex-col">
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-[10px] font-black text-purple-600 uppercase tracking-widest bg-purple-50 dark:bg-purple-900/30 px-2.5 py-1 rounded-md">Pieza de Autor</span>
                            <span class="text-xs text-gray-400">Ref: {{ str_pad($producto->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-gray-950 dark:text-white leading-tight">
                            {{ $producto->nombre }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-100 dark:border-gray-800">
                        <span class="text-4xl font-black text-purple-600 dark:text-purple-400 tracking-tighter">
                            ${{ number_format($producto->precio_venta, 2) }}
                        </span>
                        <div class="h-10 w-[1px] bg-gray-100 dark:bg-gray-800"></div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-0.5">Disponibilidad</p>
                            <p class="text-sm font-bold {{ $producto->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $producto->stock > 0 ? $producto->stock . ' unidades' : 'Agotado' }}
                            </p>
                        </div>
                    </div>

                    {{-- ACCIONES DE COMPRA --}}
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            {{-- Selector Cantidad --}}
                            <div class="flex items-center bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-1 shadow-inner">
                                <button @click="if(qty > 1) qty--" class="w-11 h-11 hover:bg-white dark:hover:bg-gray-800 rounded-xl text-gray-500 transition shadow-sm font-bold text-xl">-</button>
                                <input type="number" x-model="qty" readonly class="w-12 text-center border-none bg-transparent focus:ring-0 text-lg font-black dark:text-white">
                                <button @click="if(qty < {{ $producto->stock }}) qty++" class="w-11 h-11 hover:bg-white dark:hover:bg-gray-800 rounded-xl text-gray-500 transition shadow-sm font-bold text-xl">+</button>
                            </div>

                            {{-- Botón Carrito --}}
                            <button @click.prevent="window.addToCart({{ $producto->id }}, qty)" 
                                    type="button"
                                    {{ $producto->stock <= 0 ? 'disabled' : '' }}
                                    class="flex-1 h-14 bg-gray-950 dark:bg-purple-600 text-white rounded-2xl font-bold text-base hover:opacity-90 transition shadow-xl shadow-purple-500/10 flex items-center justify-center gap-3 active:scale-95 disabled:opacity-50 disabled:grayscale">
                                <i class="fas fa-shopping-bag"></i>
                                <span>{{ $producto->stock > 0 ? 'Añadir al Carrito' : 'Sin Stock' }}</span>
                            </button>
                        </div>

                        {{-- Badges de Confianza --}}
                        <div class="grid grid-cols-3 gap-4 py-4 px-6 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-800">
                            <div class="text-center">
                                <i class="fas fa-truck text-purple-500 mb-1"></i>
                                <p class="text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase">Envío Gratis</p>
                            </div>
                            <div class="text-center border-x border-gray-200 dark:border-gray-800">
                                <i class="fas fa-shield-alt text-purple-500 mb-1"></i>
                                <p class="text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase">Pago Seguro</p>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-certificate text-purple-500 mb-1"></i>
                                <p class="text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase">Original</p>
                            </div>
                        </div>
                    </div>

                    {{-- Artesano Card --}}
                    @if($producto->persona)
                        <div class="mt-10 flex items-center gap-4 p-4 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm group cursor-pointer hover:border-purple-200 transition">
                            <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 text-2xl">
                                <i class="fas fa-hand-sparkles"></i>
                            </div>
                            <div>
                                <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest">Creado por el maestro</p>
                                <h4 class="text-base font-black text-gray-950 dark:text-white">
                                    {{ $producto->persona->nombre }} {{ $producto->persona->apellido }}
                                </h4>
                                <a href="{{ route('artesanos.show', $producto->persona->id) }}" class="text-xs font-bold text-purple-600 hover:underline">Visitar taller</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Descripción Inferior --}}
            <div class="mt-20 pt-12 border-t border-gray-100 dark:border-gray-800 grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <h3 class="text-xl font-black text-gray-950 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-8 h-1 bg-purple-600 rounded-full"></span>
                        Historia y Detalles
                    </h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-relaxed text-lg">
                        {{ $producto->descripcion ?? 'Esta obra maestra representa el corazón de nuestra cultura. Elaborada con materiales sostenibles y técnicas ancestrales.' }}
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-900 p-8 rounded-3xl">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6 uppercase text-xs tracking-widest">Especificaciones Técnicas</h4>
                    <ul class="space-y-4">
                        <li class="flex justify-between text-sm border-b border-gray-200 dark:border-gray-800 pb-2">
                            <span class="text-gray-500">Técnica</span>
                            <span class="font-bold text-gray-900 dark:text-white">Artesanal</span>
                        </li>
                        <li class="flex justify-between text-sm border-b border-gray-200 dark:border-gray-800 pb-2">
                            <span class="text-gray-500">Dimensiones</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $producto->medida ?? 'N/A' }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-500">Origen</span>
                            <span class="font-bold text-gray-900 dark:text-white">Oaxaca, México</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Lógica de Zoom
        function zoom(e) {
            const container = e.currentTarget;
            const img = container.querySelector('img');
            const rect = container.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / container.offsetWidth) * 100;
            const y = ((e.clientY - rect.top) / container.offsetHeight) * 100;
            img.style.transformOrigin = `${x}% ${y}%`;
        }

        function resetZoom(e) {
            const img = e.currentTarget.querySelector('img');
            img.style.transformOrigin = 'center center';
        }

     
    </script>
   <script>
document.addEventListener('DOMContentLoaded', function() {
    window.addToCart = function(id, quantity) {
        console.log("Agregando producto:", id, "Cantidad:", quantity);
        
        fetch("{{ route('carrito.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({ producto_id: id, cantidad: quantity })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Abrir el sidebar
                window.dispatchEvent(new CustomEvent('toggle-cart'));
                
                // Recargar el contenido del sidebar
                if (typeof window.loadCartItems === 'function') {
                    window.loadCartItems();
                }

                // Actualizar contador global
                const badge = document.getElementById('cart-count');
                if (badge) badge.innerText = data.count;
            }
        })
        .catch(err => console.error("Error en la petición:", err));
    };
});
</script>
</x-tienda-layout>
<x-app-layout>
    @section('title', 'Detalle de Producto')

    <div class="px-6 py-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                    Ficha Técnica: {{ $producto->nombre }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Consulta los detalles específicos y stock de esta pieza.</p>
            </div>
            <a href="{{ route('productos.index') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-600 border border-purple-600 rounded-lg hover:bg-purple-600 hover:text-white transition-all shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Inventario
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 border border-gray-100 dark:border-gray-700">
                    
                    <div class="swiper mySwiper rounded-lg overflow-hidden mb-4 cursor-zoom-in group">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a data-fancybox="gallery" href="{{ $producto->img_url ? asset('storage/'.$producto->img_url) : asset('img/no-image.png') }}">
                                    <img class="w-full h-96 object-cover transform group-hover:scale-110 transition-transform duration-500" 
                                         src="{{ $producto->img_url ? asset('storage/'.$producto->img_url) : asset('img/no-image.png') }}" 
                                         alt="{{ $producto->nombre }}">
                                </a>
                            </div>
                            </div>
                        <div class="swiper-button-next !text-white after:!text-2xl"></div>
                        <div class="swiper-button-prev !text-white after:!text-2xl"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <div class="p-4 bg-purple-600 rounded-lg shadow-lg text-white mb-4">
                        <p class="text-[10px] uppercase font-black tracking-[0.2em] opacity-80">Medida / Talla</p>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-black italic">{{ $producto->medida ?? 'ÚNICA' }}</span>
                            <i class="fas fa-ruler-combined text-2xl opacity-50"></i>
                        </div>
                    </div>

                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-dashed border-gray-300 dark:border-gray-500 text-center">
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase font-bold">Código Interno</p>
                        <p class="text-xl font-mono font-bold text-gray-700 dark:text-gray-200 tracking-widest">{{ $producto->codigo }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center mb-4 border-b dark:border-gray-700 pb-2">
                        <i class="fas fa-file-alt mr-2 text-purple-500"></i>
                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 uppercase tracking-tight">Información General</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[11px] font-bold text-gray-400 uppercase">Artesano a Cargo</label>
                            <div class="mt-1 flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-2">
                                    <i class="fas fa-user-tie text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $producto->artesano->persona->nombre }}</p>
                                    <p class="text-[11px] text-purple-500 font-semibold">{{ $producto->artesano->nombre_taller }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="text-[11px] font-bold text-gray-400 uppercase">Clasificación / Técnica</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($producto->categorias as $cat)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 text-[10px] font-black uppercase rounded-full">
                                        <i class="fas fa-tag mr-1"></i> {{ $cat->caracteristica->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <label class="text-[11px] font-bold text-gray-400 uppercase">Historia / Descripción</label>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed italic text-justify">
                                "{{ $producto->descripcion ?? 'Esta pieza es una obra única de artesanía local. No hay descripción adicional registrada.' }}"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 border-b dark:border-gray-600">
                        <h3 class="text-sm font-black text-gray-500 dark:text-gray-300 uppercase tracking-widest">Control de Inventario</h3>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Costo Adquisición</span>
                            <span class="text-2xl font-bold text-gray-700 dark:text-gray-300">${{ number_format($producto->precio_artesano, 2) }}</span>
                        </div>

                        <div class="flex flex-col p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-100 dark:border-green-800">
                            <span class="text-[10px] font-bold text-green-600 dark:text-green-400 uppercase">Precio de Venta</span>
                            <span class="text-3xl font-black text-green-700 dark:text-green-300">${{ number_format($producto->precio_venta, 2) }}</span>
                        </div>

                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Existencia Actual</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black {{ $producto->stock <= 5 ? 'text-red-500' : 'text-purple-600 dark:text-purple-400' }}">
                                    {{ $producto->stock }}
                                </span>
                                <span class="text-xs font-bold text-gray-400 uppercase">Unidades</span>
                            </div>
                            @if($producto->stock <= 5)
                                <span class="text-[10px] font-bold text-red-500 animate-pulse uppercase mt-1">
                                    <i class="fas fa-exclamation-triangle"></i> Reabastecer pronto
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center border-t dark:border-gray-600">
                        <span class="text-xs font-bold text-gray-500 uppercase">Estado del producto:</span>
                        @if($producto->estado)
                            <span class="flex items-center text-xs font-black text-blue-600 uppercase">
                                <span class="w-2 h-2 rounded-full bg-blue-600 mr-2"></span> Disponible para venta
                            </span>
                        @else
                            <span class="flex items-center text-xs font-black text-red-500 uppercase">
                                <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span> Desactivado
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('productos.edit', $producto->id) }}" 
                       class="flex-1 text-center px-6 py-3 bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-800 rounded-xl font-bold hover:opacity-90 transition-opacity shadow-lg">
                        <i class="fas fa-edit mr-2"></i> Editar Información
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .swiper-pagination-bullet-active { background: white !important; }
        .swiper-button-next, .swiper-button-prev { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }
    </style>
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        });

        Fancybox.bind("[data-fancybox]", {
            // Animación suave de apertura
            showClass: "f-fadeIn",
            hideClass: "f-fadeOut"
        });
    </script>
    @endpush
</x-app-layout>
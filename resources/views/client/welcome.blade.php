<x-tienda-layout>
    <x-slot name="title">Raíces Artesanas | Inicio</x-slot>

    {{-- HERO --}}
    <x-tienda.hero />

    {{-- CONFIANZA --}}
    <section class="py-12 bg-white dark:bg-gray-800 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="group">
                <div class="w-12 h-12 mx-auto bg-purple-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors">
                    <i class="fas fa-hand-holding-heart text-purple-600 group-hover:text-white"></i>
                </div>
                <p class="text-sm font-bold text-gray-700 dark:text-gray-200">Apoyo directo</p>
            </div>
            {{-- Repetir estructura para los otros 3 ítems --}}
        </div>
    </section>

    {{-- PRODUCTOS --}}
    <section class="py-20" id="productos">
        <div class="max-w-7xl mx-auto px-4">

            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 dark:text-white mb-2">
                        Nuestras Piezas
                    </h2>
                    <p class="text-gray-500">Explora lo mejor del arte oaxaqueño.</p>
                </div>

                <div class="flex gap-2">
                    <select class="border-none bg-gray-100 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-purple-600">
                        <option>Más recientes</option>
                        <option>Precio: Menor a Mayor</option>
                        <option>Precio: Mayor a Menor</option>
                    </select>
                </div>
            </div>

            {{-- Grid de Productos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($productos as $producto)
                    <x-tienda.product-card :producto="$producto" />
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-20">
                {{ $productos->links() }}
            </div>

        </div>
    </section>

    {{-- Eliminamos x-tienda.modal --}}
</x-tienda-layout>
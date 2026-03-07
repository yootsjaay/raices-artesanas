<x-app-layout>
    @section('title', 'Productos')

    <div class="px-6 py-2 border-b border-gray-100 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    <span class="inline-flex items-center">
                        <i class="fas fa-boxes mr-3 text-purple-500"></i>
                        Gestión de Productos
                    </span>
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Administra el inventario de artesanías y productos locales
                </p>
            </div>

            <a href="{{ route('artesano.productos.create') }}"
                class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple transition-colors md:mt-0">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Producto
            </a>
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-xs mt-6">
        <div class="w-full overflow-x-auto">
            <div class="card">
                <div class="card-body">
<table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">Artesano / Proveedor</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Precio Venta</th>
                        <th class="px-4 py-3 text-center">Stock</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($productos as $producto)
                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div class="relative hidden w-10 h-10 mr-3 rounded-full md:block border dark:border-gray-600">
                                    <img class="object-cover w-full h-full rounded-full"
                                        src="{{ $producto->img_url ? asset('storage/'.$producto->img_url) : asset('img/no-image.png') }}"
                                        alt="{{ $producto->nombre }}" loading="lazy" />
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $producto->nombre }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Cod: {{ $producto->codigo ?? 'N/A' }}</p>
                                    <p class="text-[11px] font-medium text-purple-600 dark:text-purple-400">
                                        <i class="fas fa-ruler-combined mr-1"></i> {{ $producto->medida ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $producto->artesano->persona->nombre }}</span>
                                <span class="text-xs text-purple-600 dark:text-purple-400">{{ $producto->artesano->nombre_taller }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <div class="flex flex-wrap gap-1">
                                @foreach($producto->categorias as $cat)
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $cat->caracteristica->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-gray-800 dark:text-gray-200">
                            ${{ number_format($producto->precio_venta, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-center">
                            {{ $producto->stock }} pzas
                        </td>
                        <td class="px-4 py-3 text-xs text-center">
                            @if($producto->estado)
                                <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100">
                                    Activo
                                </span>
                            @else
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center space-x-3 text-sm">
                                <a href="{{ route('productos.edit', $producto->id) }}"
                                    class="text-purple-600 hover:text-purple-900 dark:hover:text-purple-400 transition-colors"
                                    title="Editar">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <a href="{{ route('productos.show', $producto->id) }}" 
                                class="p-2 text-blue-600 hover:bg-blue-100 rounded-md transition-colors dark:hover:bg-blue-900/30"
                                title="Ver Detalle">
                                    <i class="fas fa-eye fa-lg"></i>
                                </a>
                                <button @click="confirmarEliminar({{ $producto->id }}, '{{ $producto->nombre }}')"
                                    class="text-red-600 hover:text-red-900 dark:hover:text-red-400 transition-colors"
                                    title="Eliminar">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            No hay productos registrados aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
                </div>
            </div>
            
        </div>
    </div>

    @push('js')
    <script>
        function confirmarEliminar(id, nombre) {
            if (confirm(`¿Estás seguro de eliminar el producto "${nombre}"? Esta acción no se puede deshacer.`)) {
                
                // Usamos la URL generada por Laravel para evitar problemas de rutas
                const url = `{{ url('productos') }}/${id}`;

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success || data.mensaje) {
                        alert(data.mensaje || '¡Eliminado con éxito!');
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'No se pudo eliminar'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Algo salió mal al intentar eliminar.');
                });
            }
        }
    </script>
    @endpush 
</x-app-layout>
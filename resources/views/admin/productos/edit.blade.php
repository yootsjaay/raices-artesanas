<x-app-layout>
    @section('title', 'Editar Producto')

    <div class="px-6 py-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                <i class="fas fa-edit mr-2 text-purple-600"></i>Editar Pieza: {{ $producto->nombre }}
            </h2>
            <a href="{{ route('administrador.productos.index') }}" class="text-sm font-medium text-purple-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Cancelar y volver
            </a>
        </div>

        <form action="{{ route('administrador.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                
                {{-- Columna Izquierda --}}
                <div class="space-y-4">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Nombre del Producto</span>
                        <input name="nombre" value="{{ old('nombre', $producto->nombre) }}" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md focus:border-purple-400">
                        @error('nombre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </label>

                    {{-- Dueño del Producto (Solo lectura para artesanos, editable para admin) --}}
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Artesano Responsable</span>
                        @if(auth()->user()->hasRole('administrador'))
                            <select name="persona_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                @foreach($artesanos as $artesano)
                                    <option value="{{ $artesano->id }}" {{ $producto->persona_id == $artesano->id ? 'selected' : '' }}>
                                        {{ $artesano->nombre_taller ?? ($artesano->nombre . ' ' . $artesano->apellido) }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" readonly class="block w-full mt-1 text-sm bg-gray-100 dark:bg-gray-600 dark:text-gray-300 border-none rounded-md cursor-not-allowed" 
                                value="{{ $producto->persona->nombre_taller ?? ($producto->persona->nombre . ' ' . $producto->persona->apellido) }}">
                            <input type="hidden" name="persona_id" value="{{ $producto->persona_id }}">
                        @endif
                    </label>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Categoría</span>
                            <select name="categoria_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ $producto->categorias->contains($cat->id) ? 'selected' : '' }}>
                                        {{ $cat->caracteristica->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Presentación</span>
                            <select name="presentacione_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                @foreach($presentaciones as $pres)
                                    <option value="{{ $pres->id }}" {{ $producto->presentacione_id == $pres->id ? 'selected' : '' }}>
                                        {{ $pres->caracteristica->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="mr-4">
                            <p class="text-[10px] text-gray-500 uppercase font-bold mb-1">Actual:</p>
                            <img src="{{ $producto->img_url ? asset('storage/'.$producto->img_url) : asset('img/no-image.png') }}" 
                                 class="w-20 h-20 object-cover rounded shadow-sm border border-white">
                        </div>
                        <label class="block text-sm flex-1">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Reemplazar Imagen</span>
                            <input type="file" name="imagen" accept="image/*" class="block w-full mt-1 text-xs dark:text-gray-300">
                            @error('imagen') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </label>
                    </div>
                </div>

                {{-- Columna Derecha --}}
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Precio Artesano ($)</span>
                            <input type="number" step="0.01" id="precio_base" name="precio_artesano" value="{{ old('precio_artesano', $producto->precio_artesano) }}" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md">
                        </label>
                        <label class="block text-sm">
                            <span class="text-purple-600 dark:text-purple-400 font-bold">Precio Venta (Final)</span>
                            <input type="number" id="precio_venta" readonly class="block w-full mt-1 text-sm bg-gray-100 dark:bg-gray-600 font-bold border-dashed rounded-md cursor-not-allowed">
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Stock Actual</span>
                            <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md">
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Medida / Talla</span>
                            <input name="medida" value="{{ old('medida', $producto->medida) }}" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md" placeholder="Ej: Talla M, 20x30cm...">
                        </label>
                    </div>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Descripción / Historia</span>
                        <textarea name="descripcion" rows="4" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </label>

                    <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-100 dark:border-purple-800">
                        <label class="block text-sm">
                            <span class="text-purple-700 dark:text-purple-300 font-bold italic text-xs uppercase">Código de Identificación</span>
                            <input type="text" readonly value="{{ $producto->codigo }}" class="block w-full mt-1 text-sm bg-transparent border-none font-mono font-bold tracking-widest text-purple-600 dark:text-purple-400">
                            <p class="text-[9px] text-purple-400 mt-1">* El código no es editable por motivos de trazabilidad.</p>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="px-8 py-3 font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-colors shadow-lg">
                    <i class="fas fa-sync-alt mr-2"></i> Actualizar Producto
                </button>
            </div>
        </form>
    </div>

    @push('js')
    <script>
        const pBaseInput = document.getElementById('precio_base');
        const pVentaInput = document.getElementById('precio_venta');
        
        // Comisión fija definida para Raíces Artesanas
        const COMISION_SISTEMA = 50.00; 

        function calcularPrecioFinal() {
            const base = parseFloat(pBaseInput.value) || 0;
            if(base > 0) {
                pVentaInput.value = (base + COMISION_SISTEMA).toFixed(2);
            } else {
                pVentaInput.value = '';
            }
        }

        pBaseInput.addEventListener('input', calcularPrecioFinal);
        
        // Ejecutar al cargar la página
        window.addEventListener('load', calcularPrecioFinal);
    </script>
    @endpush
</x-app-layout>
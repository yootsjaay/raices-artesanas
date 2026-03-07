<x-app-layout>
    @section('title', 'Editar Producto')

    <div class="px-6 py-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                <i class="fas fa-edit mr-2 text-purple-600"></i>Editar Pieza: {{ $producto->nombre }}
            </h2>
            <a href="{{ route('productos.index') }}" class="text-sm font-medium text-purple-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Cancelar y volver
            </a>
        </div>

        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                
                <div class="space-y-4">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Nombre del Producto</span>
                        <input name="nombre" value="{{ old('nombre', $producto->nombre) }}" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md focus:border-purple-400">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Maestro(a) Artesano(a)</span>
                        <select id="proveedore_id" name="proveedore_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                            @foreach($artesanos as $artesano)
                                <option value="{{ $artesano->id }}" 
                                    data-comision="{{ $artesano->comision_fija_sistema }}"
                                    {{ $producto->proveedore_id == $artesano->id ? 'selected' : '' }}>
                                    {{ $artesano->persona->nombre }} ({{ $artesano->nombre_taller }})
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <div class="grid grid-cols-2 gap-4">
                        
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Categoría</span>
                            <select name="categoria_id" class="block w-full mt-1 text-sm dark:bg-gray-700">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoria_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->caracteristica->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="mr-4">
                            <p class="text-xs text-gray-500">Imagen Actual:</p>
                            <img src="{{ $producto->img_url ? asset('storage/'.$producto->img_url) : asset('img/no-image.png') }}" 
                                 class="w-20 h-20 object-cover rounded border shadow-sm">
                        </div>
                        <label class="block text-sm flex-1">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Cambiar Imagen</span>
                            <input type="file" name="imagen" accept="image/*" class="block w-full mt-1 text-xs dark:text-gray-300">
                        </label>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Precio Artesano ($)</span>
                            <input type="number" step="0.01" id="precio_artesano" name="precio_artesano" value="{{ old('precio_artesano', $producto->precio_artesano) }}" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input">
                        </label>
                        <label class="block text-sm">
                            <span class="text-purple-600 dark:text-purple-400 font-bold">Precio Venta ($)</span>
                            <input type="number" id="precio_venta" name="precio_venta" value="{{ $producto->precio_venta }}" readonly class="block w-full mt-1 text-sm bg-gray-100 dark:bg-gray-600 font-bold border-dashed rounded-md">
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Stock Actual</span>
                            <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input">
                        </label>
                        <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Medida / Talla</span>
                        <input name="medida" value="{{ old('medida', $producto->medida ?? '') }}" 
                            class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md" 
                            placeholder="Ej: Talla M, 30x20cm, 2 Litros...">
                        <span class="text-[10px] text-gray-500 italic">* Especifica según el tipo de artesanía</span>
                    </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Código</span>
                            <input name="codigo" value="{{ old('codigo', $producto->codigo) }}" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input">
                        </label>
                    </div>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Descripción</span>
                        <textarea name="descripcion" rows="4" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </label>
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
        const artesanoSel = document.getElementById('proveedore_id');
        const pArtesanoInput = document.getElementById('precio_artesano');
        const pVentaInput = document.getElementById('precio_venta');

        function calcularPrecioFinal() {
            const selected = artesanoSel.options[artesanoSel.selectedIndex];
            const comision = parseFloat(selected.getAttribute('data-comision')) || 0;
            const base = parseFloat(pArtesanoInput.value) || 0;
            pVentaInput.value = (base + comision).toFixed(2);
        }

        artesanoSel.addEventListener('change', calcularPrecioFinal);
        pArtesanoInput.addEventListener('input', calcularPrecioFinal);
        
        // Ejecutar al cargar para validar precios actuales
        window.onload = calcularPrecioFinal;
    </script>
    @endpush
</x-app-layout>
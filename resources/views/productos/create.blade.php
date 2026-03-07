<x-app-layout>
    @section('title', 'Crear Producto')

    <div class="px-6 py-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                <i class="fas fa-plus-circle mr-2 text-purple-600"></i>Nuevo Producto Artesanal
            </h2>
            <a href="{{ route('artesano.productos.index') }}" class="text-sm font-medium text-purple-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Regresar al inventario
            </a>
        </div>

        <form action="{{ route('artesano.productos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6">
            @csrf

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                
                <div class="space-y-4">
                    {{-- Nombre --}}
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Nombre del Producto</span>
                        <input name="nombre" value="{{ old('nombre') }}" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md focus:border-purple-400" placeholder="Ej: Blusa Tlahui Bordada">
                        @error('nombre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </label>

                    {{-- Selección de Artesano (Lógica de Rol) --}}
                    <label class="block text-sm">
    <span class="text-gray-700 dark:text-gray-400 font-bold">Maestro(a) Artesano(a)</span>
    
    @role('Admin')
        {{-- El Admin sí elige --}}
        <select id="proveedore_id" name="proveedore_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
            <option value="">Seleccione al artesano...</option>
            @foreach($artesanos as $artesano)
                <option value="{{ $artesano->id }}" data-comision="{{ $artesano->comision_fija_sistema }}">
                    {{ $artesano->persona->nombre }}
                </option>
            @endforeach
        </select>
    @else
        {{-- El Artesano solo ve su nombre, el sistema ya sabe quién es --}}
        <div class="p-2 mt-1 bg-gray-100 dark:bg-gray-700 rounded-md text-gray-600 dark:text-gray-300 border border-gray-300">
            {{ auth()->user()->persona->nombre }} ({{ auth()->user()->persona->nombre_taller ?? 'Mi Taller' }})
        </div>
        {{-- Enviamos el ID oculto para que el controlador lo reciba --}}
        <input type="hidden" name="proveedore_id" id="proveedore_id" 
               value="{{ auth()->user()->proveedor->id }}" 
               data-comision="{{ auth()->user()->proveedor->comision_fija_sistema ?? 0 }}">
    @endrole
</label>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Categoría</span>
                            <select name="categoria_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->caracteristica->nombre }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Presentación</span>
                            <select name="presentacione_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                @foreach($presentaciones as $pres)
                                    <option value="{{ $pres->id }}">{{ $pres->caracteristica->nombre }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Precios --}}
                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Precio Artesano ($)</span>
                            <input type="number" step="0.01" id="precio_artesano" name="precio_artesano" value="{{ old('precio_artesano') }}" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md" placeholder="0.00">
                        </label>
                        <label class="block text-sm">
                            <span class="text-purple-600 dark:text-purple-400 font-bold">Precio Venta (Público)</span>
                            <input type="number" id="precio_venta" name="precio_venta" readonly class="block w-full mt-1 text-sm bg-gray-100 dark:bg-gray-600 font-bold dark:text-gray-200 border-dashed rounded-md cursor-not-allowed">
                        </label>
                    </div>

                    {{-- Stock y Medida --}}
                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Stock Inicial</span>
                            <input type="number" name="stock" value="{{ old('stock', 1) }}" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md">
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Medida / Talla</span>
                            <input name="medida" value="{{ old('medida') }}" 
                                class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md" 
                                placeholder="Ej: Talla M, 30x20cm...">
                            <span class="text-[10px] text-gray-500 italic">* Especifica talla o dimensiones</span>
                        </label>
                    </div>

                    {{-- Imagen --}}
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Imagen del Producto</span>
                        <input type="file" name="imagen" accept="image/*" class="block w-full mt-1 text-sm dark:text-gray-300 border border-gray-300 rounded-md p-2">
                    </label>

                    {{-- Descripción --}}
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Descripción / Historia</span>
                        <textarea name="descripcion" rows="3" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md" placeholder="Cuéntanos sobre el origen y materiales de esta pieza...">{{ old('descripcion') }}</textarea>
                    </label>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="px-8 py-3 font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none transition-colors shadow-lg">
                    <i class="fas fa-save mr-2"></i>Publicar Producto
                </button>
            </div>
        </form>
    </div>

    <script>
        const artesanoEl = document.getElementById('proveedore_id');
        const pArtesanoInput = document.getElementById('precio_artesano');
        const pVentaInput = document.getElementById('precio_venta');

        function calcularPrecioFinal() {
            let comision = 0;
            
            // Si es un select (Admin), buscamos el atributo del option
            if (artesanoEl.tagName === 'SELECT') {
                const selected = artesanoEl.options[artesanoEl.selectedIndex];
                comision = parseFloat(selected?.getAttribute('data-comision')) || 0;
            } else {
                // Si es un input hidden (Artesano), tomamos su data-comision
                comision = parseFloat(artesanoEl.getAttribute('data-comision')) || 0;
            }

            const base = parseFloat(pArtesanoInput.value) || 0;
            
            if(base > 0) {
                pVentaInput.value = (base + comision).toFixed(2);
            } else {
                pVentaInput.value = '';
            }
        }

        // Escuchar cambios según el tipo de elemento
        if (artesanoEl.tagName === 'SELECT') {
            artesanoEl.addEventListener('change', calcularPrecioFinal);
        }
        
        pArtesanoInput.addEventListener('input', calcularPrecioFinal);

        // Ejecutar al cargar por si hay valores antiguos (old)
        window.addEventListener('load', calcularPrecioFinal);
    </script>
</x-app-layout>
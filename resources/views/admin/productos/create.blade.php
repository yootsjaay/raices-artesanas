<x-app-layout>
    @section('title', 'Crear Producto')

    @if ($errors->any())
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="px-6 py-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                <i class="fas fa-plus-circle mr-2 text-purple-600"></i>Nuevo Producto Artesanal
            </h2>
            <a href="{{ route('administrador.productos.index') }}" class="text-sm font-medium text-purple-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Regresar al inventario
            </a>
        </div>

        <form action="{{ route('administrador.productos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6">
            @csrf

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                
                {{-- Columna Izquierda: Información Básica y Logística --}}
                <div class="space-y-4">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Nombre del Producto</span>
                        <input name="nombre" value="{{ old('nombre') }}" required 
                            class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md focus:border-purple-400" 
                            placeholder="Ej: Blusa Tlahui Bordada">
                    </label>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Categoría</span>
                            <select name="categoria_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                <option value="">Seleccionar...</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->caracteristica->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Presentación</span>
                            <select name="presentacione_id" required class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                <option value="">Seleccionar...</option>
                                @foreach($presentaciones as $pres)
                                    <option value="{{ $pres->id }}" {{ old('presentacione_id') == $pres->id ? 'selected' : '' }}>
                                        {{ $pres->caracteristica->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    {{-- SECCIÓN DE LOGÍSTICA / ENVÍO --}}
                    <div class="p-4 bg-purple-50 dark:bg-gray-700 rounded-lg border border-purple-100 dark:border-gray-600">
                        <h3 class="text-sm font-bold text-purple-700 dark:text-purple-400 mb-3">
                            <i class="fas fa-truck mr-1"></i> Datos de Envío (Envia.com)
                        </h3>

                        <label class="block text-sm mb-4">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Tipo de Empaque Predeterminado</span>
                            <select id="paquete_id" name="paquete_id" class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-select border-gray-300 rounded-md">
                                <option value="">Ingresar medidas manualmente...</option>
                                @foreach($paquetes as $paquete)
                                    <option value="{{ $paquete->id }}" 
                                        data-peso="{{ $paquete->peso }}" 
                                        data-largo="{{ $paquete->largo }}" 
                                        data-ancho="{{ $paquete->ancho }}" 
                                        data-alto="{{ $paquete->alto }}">
                                        {{ $paquete->nombre }} ({{ $paquete->peso }}kg)
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Peso (kg)</span>
                                <input type="number" name="peso" id="log_peso" step="0.1" value="{{ old('peso', 0.5) }}" required
                                    class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-md">
                            </label>
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Largo (cm)</span>
                                <input type="number" name="largo" id="log_largo" value="{{ old('largo', 10) }}" required
                                    class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-md">
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Ancho (cm)</span>
                                <input type="number" name="ancho" id="log_ancho" value="{{ old('ancho', 10) }}" required
                                    class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-md">
                            </label>
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Alto (cm)</span>
                                <input type="number" name="alto" id="log_alto" value="{{ old('alto', 10) }}" required
                                    class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-md">
                            </label>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <input type="checkbox" name="es_fragil" id="es_fragil" {{ old('es_fragil') ? 'checked' : '' }}
                                class="rounded text-purple-600 focus:ring-purple-500">
                            <label for="es_fragil" class="text-sm font-bold text-red-600 dark:text-red-400">
                                ¿Es un producto frágil?
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Precios e Inventario --}}
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold">Precio Artesano ($)</span>
                            <input type="number" step="0.01" id="precio_base" name="precio_artesano" value="{{ old('precio_artesano') }}" required 
                                class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md" placeholder="0.00">
                        </label>
                        <label class="block text-sm">
                            <span class="text-purple-600 dark:text-purple-400 font-bold">Precio Venta (Final)</span>
                            <input type="number" id="precio_venta" readonly 
                                class="block w-full mt-1 text-sm bg-gray-100 dark:bg-gray-600 font-bold dark:text-gray-200 border-dashed rounded-md cursor-not-allowed">
                        </label>
                    </div>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Stock Inicial</span>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" required
                            class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Imagen del Producto</span>
                        <input type="file" name="imagen" accept="image/*" 
                            class="block w-full mt-1 text-sm dark:text-gray-300 border border-gray-300 rounded-md p-2">
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold">Descripción / Historia</span>
                        <textarea name="descripcion" rows="4" 
                            class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input border-gray-300 rounded-md" 
                            placeholder="Cuéntanos sobre el origen y materiales de esta pieza...">{{ old('descripcion') }}</textarea>
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
        // Cálculo de Precios
        const pBaseInput = document.getElementById('precio_base');
        const pVentaInput = document.getElementById('precio_venta');
        const COMISION_SISTEMA = 50.00; 

        function calcularPrecioFinal() {
            const base = parseFloat(pBaseInput.value) || 0;
            if(base > 0) {
                pVentaInput.value = (base + COMISION_SISTEMA).toFixed(2);
            } else {
                pVentaInput.value = '';
            }
        }

        // Lógica de Autocompletado de Paquetes
        const paqueteSelect = document.getElementById('paquete_id');
        const inputsLogistica = {
            peso: document.getElementById('log_peso'),
            largo: document.getElementById('log_largo'),
            ancho: document.getElementById('log_ancho'),
            alto: document.getElementById('log_alto')
        };

        paqueteSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value !== "") {
                inputsLogistica.peso.value = selectedOption.dataset.peso;
                inputsLogistica.largo.value = selectedOption.dataset.largo;
                inputsLogistica.ancho.value = selectedOption.dataset.ancho;
                inputsLogistica.alto.value = selectedOption.dataset.alto;
            }
        });

        pBaseInput.addEventListener('input', calcularPrecioFinal);
        window.addEventListener('load', calcularPrecioFinal);
    </script>
</x-app-layout>
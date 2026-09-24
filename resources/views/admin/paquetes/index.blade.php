<x-app-layout>

    @section('title', 'Paquetes')

    <!-- Header Section -->
    <div class="px-6 py-2 border-b border-gray-100 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    <span class="inline-flex items-center">
                        <i class="fas fa-box-open mr-3 text-purple-500"></i>
                        Gestión de Paquetes
                    </span>
                </h2>
                <p class="mt-1 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                    Administra los paquetes de envío para tus productos
                </p>
            </div>

            <!-- Breadcrumb -->
            <nav class="mt-4 md:mt-0" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <span class="text-gray-500 dark:text-gray-400">Configuración</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Paquetes</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Card Container --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs mt-3">
        <div class="w-full overflow-x-auto">
            <div class="bg-white rounded-lg shadow-md dark:bg-gray-800">

                {{-- Card Header --}}
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                        <i class="fas fa-table mr-2"></i>
                        <span>Registros</span>
                    </div>
                    <button
                        class="flex items-center justify-center p-3 bg-purple-600 hover:bg-purple-700 text-white rounded-full
                               shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                        type="button"
                        data-modal-target="crearPaqueteModal"
                        data-modal-toggle="crearPaqueteModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                {{-- Tabla --}}
                <div class="p-4">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b
                                           dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Nombre</th>
                                    <th class="px-4 py-3">Peso (kg)</th>
                                    <th class="px-4 py-3">Dimensiones (cm)</th>
                                    <th class="px-4 py-3">ID Envia.com</th>
                                    <th class="px-4 py-3">Estado</th>
                                    <th class="px-4 py-3"><i class="fa-solid fa-wrench"></i></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($paquetes as $paquete)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-2">
                                        <strong class="text-gray-900 dark:text-gray-200">{{ $paquete->nombre }}</strong>
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fas fa-weight-hanging text-purple-400 text-xs"></i>
                                            {{ $paquete->peso }} kg
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ $paquete->largo }} × {{ $paquete->ancho }} × {{ $paquete->alto }}
                                        </span>
                                        <span class="text-xs text-gray-400 ml-1">L×A×Al</span>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($paquete->envia_package_id)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                {{ $paquete->envia_package_id }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                <i class="fas fa-clock mr-1"></i>
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($paquete->activo)
                                            <i class="fa-solid fa-circle-check text-green-500"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-gray-400"></i>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="p-2 text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors"
                                            type="button"
                                            data-modal-toggle="editarPaqueteModal"
                                            data-id="{{ $paquete->id }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>

                                        @if ($paquete->activo)
                                        <button
                                            class="p-2 text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-gray-700 transition-colors"
                                            onclick="abrirModalConfirmacion({{ $paquete->id }}, 1)">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        @else
                                        <button
                                            class="p-2 text-yellow-500 rounded-lg hover:bg-yellow-50 dark:hover:bg-gray-700 transition-colors"
                                            onclick="abrirModalConfirmacion({{ $paquete->id }}, 0)">
                                            <i class="fa-solid fa-arrow-rotate-right"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                                        <i class="fas fa-box-open text-4xl mb-3 opacity-30 block"></i>
                                        No hay paquetes registrados aún.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== MODAL CREAR ===== --}}
    <div id="crearPaqueteModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-lg">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-box mr-2 text-purple-500"></i>
                        Nuevo Paquete
                    </h3>
                    <button type="button" data-modal-hide="crearPaqueteModal"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 space-y-4">
                    <form id="form-crear-paquete">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombre" required placeholder="Ej. Caja pequeña artesanías"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500
                                       focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                       dark:text-white transition-all duration-200">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Peso (kg) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="peso" step="0.01" min="0.1" required placeholder="Ej. 1.5"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500
                                       focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                       dark:text-white transition-all duration-200">
                        </div>

                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Largo (cm) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="largo" step="0.1" min="1" required placeholder="30"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500
                                           focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                           dark:text-white transition-all duration-200">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Ancho (cm) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="ancho" step="0.1" min="1" required placeholder="20"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500
                                           focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                           dark:text-white transition-all duration-200">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Alto (cm) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="alto" step="0.1" min="1" required placeholder="15"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500
                                           focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                           dark:text-white transition-all duration-200">
                            </div>
                        </div>

                        <div id="crear-error" class="hidden mb-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-600 dark:text-red-400"></div>

                        <div class="flex justify-center pt-4 border-t dark:border-gray-700">
                            <button type="submit"
                                class="flex items-center px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg text-sm
                                       focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all duration-200">
                                <i class="far fa-floppy-disk mr-2"></i>
                                Guardar Paquete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL EDITAR ===== --}}
    <div id="editarPaqueteModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-lg">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-box mr-2 text-blue-500"></i>
                        Editar Paquete
                    </h3>
                    <button type="button" data-modal-hide="editarPaqueteModal"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 space-y-4">
                    <form id="form-editar-paquete">
                        <input type="hidden" id="editar-paquete-id">

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="editar-nombre" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                       focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                       dark:text-white transition-all duration-200">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Peso (kg) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="editar-peso" step="0.01" min="0.1" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                       focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                       dark:text-white transition-all duration-200">
                        </div>

                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Largo (cm)</label>
                                <input type="number" id="editar-largo" step="0.1" min="1" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                           focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                           dark:text-white transition-all duration-200">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ancho (cm)</label>
                                <input type="number" id="editar-ancho" step="0.1" min="1" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                           focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                           dark:text-white transition-all duration-200">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alto (cm)</label>
                                <input type="number" id="editar-alto" step="0.1" min="1" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                           focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                           dark:text-white transition-all duration-200">
                            </div>
                        </div>

                        <div id="editar-error" class="hidden mb-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-600 dark:text-red-400"></div>

                        <div class="flex justify-center pt-4 border-t dark:border-gray-700">
                            <button type="submit"
                                class="flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                <i class="far fa-floppy-disk mr-2"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL CONFIRMACIÓN ===== --}}
    <div id="confirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-md">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-exclamation-circle mr-2 text-yellow-500"></i>
                        Confirmación
                    </h3>
                    <button type="button" onclick="cerrarModal('confirmModal')"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-gray-700 dark:text-gray-300" id="confirmModalBody"></p>
                </div>
                <div class="flex items-center justify-end p-4 border-t dark:border-gray-700 space-x-3">
                    <button type="button" onclick="cerrarModal('confirmModal')"
                        class="py-2 px-4 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-600
                               dark:text-gray-300 dark:hover:bg-gray-700 transition-all duration-200">
                        Cancelar
                    </button>
                    <button type="button" id="confirmarAccion" data-id="" data-estado=""
                        class="py-2 px-4 text-sm font-medium text-white rounded-lg transition-all duration-200">
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ===== SETUP MODALES =====
        document.addEventListener('DOMContentLoaded', function () {
            setupModal('crearPaqueteModal', '[data-modal-toggle="crearPaqueteModal"]');
            setupModal('editarPaqueteModal');
        });

        function setupModal(modalId, toggleSelector = null) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            if (toggleSelector) {
                document.querySelectorAll(toggleSelector).forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        modal.classList.remove('hidden');
                        modal.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    });
                });
            }

            const closeBtn = modal.querySelector('[data-modal-hide]');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => cerrarModal(modalId));
            }

            modal.addEventListener('click', (e) => {
                if (e.target === modal) cerrarModal(modalId);
            });
        }

        function cerrarModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // ===== CREAR =====
        document.getElementById('form-crear-paquete').addEventListener('submit', async function (e) {
            e.preventDefault();
            const errorEl = document.getElementById('crear-error');
            errorEl.classList.add('hidden');

            const data = {
                nombre: this.nombre.value,
                peso:   this.peso.value,
                largo:  this.largo.value,
                ancho:  this.ancho.value,
                alto:   this.alto.value,
            };

            try {
                const res = await fetch('{{ route('administrador.paquetes.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const json = await res.json();

                if (json.success) {
                    cerrarModal('crearPaqueteModal');
                    this.reset();
                    setTimeout(() => location.reload(), 800);
                } else {
                    errorEl.textContent = json.message || 'Error al guardar.';
                    errorEl.classList.remove('hidden');
                }
            } catch (err) {
                errorEl.textContent = 'Error de conexión.';
                errorEl.classList.remove('hidden');
            }
        });

        // ===== ABRIR EDITAR =====
        document.querySelectorAll('[data-modal-toggle="editarPaqueteModal"]').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = this.getAttribute('data-id');
                const modal = document.getElementById('editarPaqueteModal');

                try {
                    const res = await fetch(`/administrador/paquetes/${id}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const json = await res.json();

                    if (json.success) {
                        const p = json.data;
                        document.getElementById('editar-paquete-id').value = p.id;
                        document.getElementById('editar-nombre').value = p.nombre;
                        document.getElementById('editar-peso').value   = p.peso;
                        document.getElementById('editar-largo').value  = p.largo;
                        document.getElementById('editar-ancho').value  = p.ancho;
                        document.getElementById('editar-alto').value   = p.alto;

                        modal.classList.remove('hidden');
                        modal.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    }
                } catch (err) {
                    console.error('Error al cargar paquete:', err);
                }
            });
        });

        // ===== GUARDAR EDITAR =====
        document.getElementById('form-editar-paquete').addEventListener('submit', async function (e) {
            e.preventDefault();
            const errorEl = document.getElementById('editar-error');
            errorEl.classList.add('hidden');

            const id = document.getElementById('editar-paquete-id').value;
            const data = {
                nombre: document.getElementById('editar-nombre').value,
                peso:   document.getElementById('editar-peso').value,
                largo:  document.getElementById('editar-largo').value,
                ancho:  document.getElementById('editar-ancho').value,
                alto:   document.getElementById('editar-alto').value,
            };

            try {
                const res = await fetch(`/administrador/paquetes/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const json = await res.json();

                if (json.success) {
                    cerrarModal('editarPaqueteModal');
                    setTimeout(() => location.reload(), 800);
                } else {
                    errorEl.textContent = json.message || 'Error al actualizar.';
                    errorEl.classList.remove('hidden');
                }
            } catch (err) {
                errorEl.textContent = 'Error de conexión.';
                errorEl.classList.remove('hidden');
            }
        });

        // ===== CONFIRMACIÓN ELIMINAR/RESTAURAR =====
        function abrirModalConfirmacion(id, estado) {
            const modal    = document.getElementById('confirmModal');
            const btn      = document.getElementById('confirmarAccion');
            const body     = document.getElementById('confirmModalBody');

            if (estado === 1) {
                body.innerHTML = `¿Seguro que quieres <strong>desactivar</strong> este paquete?`;
                btn.textContent = 'Desactivar';
                btn.className = 'py-2 px-4 text-sm font-medium text-white rounded-lg transition-all duration-200 bg-red-600 hover:bg-red-700';
            } else {
                body.innerHTML = `¿Seguro que quieres <strong>restaurar</strong> este paquete?`;
                btn.textContent = 'Restaurar';
                btn.className = 'py-2 px-4 text-sm font-medium text-white rounded-lg transition-all duration-200 bg-yellow-500 hover:bg-yellow-600';
            }

            btn.setAttribute('data-id', id);
            btn.setAttribute('data-estado', estado);

            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        document.getElementById('confirmarAccion').addEventListener('click', async function () {
            const id = this.getAttribute('data-id');

            try {
                const res = await fetch(`/administrador/paquetes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const json = await res.json();

                if (json.success) {
                    cerrarModal('confirmModal');
                    setTimeout(() => location.reload(), 800);
                }
            } catch (err) {
                console.error('Error:', err);
            }
        });
    </script>
    @endpush

</x-app-layout>
<x-app-layout>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Crear Nuevo Rol
        </h2>

        <form action="{{ route('administrador.roles.store') }}" method="POST">
            @csrf
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                
                <label class="block text-sm mb-4">
                    <span class="text-gray-700 dark:text-gray-400 font-bold">Nombre del Rol</span>
                    <input name="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input" 
                    placeholder="Ej: supervisor_ventas" required>
                    <span class="text-xs text-gray-500 italic">Usa minúsculas y guiones bajos (ej: editor_web).</span>
                </label>

                <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-200">Asignar Permisos Iniciales</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permissions as $permission)
                    <div class="flex items-center p-3 border rounded-lg dark:border-gray-700">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            class="w-4 h-4 text-purple-600 form-checkbox">
                        <label class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                            {{ str_replace('.', ' ', ucwords($permission->name, '.')) }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-10 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                        Crear Rol
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
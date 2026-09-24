<x-app-layout>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Configurar Permisos para: <span class="text-purple-600">{{ strtoupper($role->name) }}</span>
        </h2>

        <form action="{{ route('administrador.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    Marca las casillas de las funciones que este rol podrá ver o realizar en el sistema.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($permissions as $permission)
                    <div class="flex items-center p-4 border rounded-lg dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            class="w-5 h-5 text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                        <label class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ str_replace('.', ' ', ucwords($permission->name, '.')) }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('administrador.roles.index') }}" class="px-4 py-2 mr-4 text-sm font-medium text-gray-600 transition-colors duration-150 border border-gray-300 rounded-lg hover:bg-gray-100">
                        Cancelar
                    </a>
                    <button type="submit" class="px-10 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
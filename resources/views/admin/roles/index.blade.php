<x-app-layout>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Gestión de Roles y Permisos
        </h2>


        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <div class="flex justify-between items-center my-6">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Roles</h2>
                    <a href="{{ route('administrador.roles.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                        + Nuevo Rol
                    </a>
                </div>
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Rol</th>
                            <th class="px-4 py-3">Permisos Asignados</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($roles as $role)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 font-semibold">{{ strtoupper($role->name) }}</td>
                            <td class="px-4 py-3 text-sm">
                                @foreach($role->permissions as $permission)
                                    <span class="px-2 py-1 font-semibold leading-tight text-purple-700 bg-purple-100 rounded-full dark:bg-purple-700 dark:text-purple-100 text-xs mr-1">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('administrador.roles.edit', $role->id) }}" class="text-purple-600 hover:text-purple-900">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar Permisos
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
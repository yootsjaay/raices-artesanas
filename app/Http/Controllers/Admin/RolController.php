<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolController extends Controller
{
    public function index()
    {
        // Traemos los roles con sus permisos para evitar múltiples consultas
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        // Obtenemos todos los permisos que creamos en el Seeder
        $permissions = Permission::all();
        // Obtenemos solo los IDs de los permisos que ya tiene este rol
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
// ... dentro de RolController.php

public function create()
{
    // Solo necesitamos ver los permisos para asignarlos de una vez al crear
    $permissions = Permission::all();
    return view('admin.roles.create', compact('permissions'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name|max:50',
        'permissions' => 'array'
    ]);

    // Creamos el rol
    $role = Role::create(['name' => $request->name]);

    // Le asignamos los permisos seleccionados
    if ($request->has('permissions')) {
        $role->syncPermissions($request->input('permissions'));
    }

    return redirect()->route('administrador.roles.index')
        ->with('success', "Rol '{$role->name}' creado exitosamente.");
}
    public function update(Request $request, Role $role)
    {
        // Validamos que al menos se envíe un array (pueden ser permisos vacíos)
        $request->validate([
            'permissions' => 'array'
        ]);

        // Spatie se encarga de quitar los que no están y poner los nuevos
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('administrador.roles.index')
            ->with('success', "Permisos actualizados para el rol: {$role->name}");
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Limpiar caché de permisos para evitar errores de duplicados
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definir TODOS los permisos que quieres controlar en tu vista
        $permisos = [
            // Gestión de Productos
            'productos.index',
            'productos.crear',
            'productos.editar.propios',
            'productos.eliminar.propios',
            'productos.eliminar.todos', // Solo para ti
            
            // Navegación (Lo que controla el Sidebar)
            'ver.categorias',
            'ver.presentaciones',
            'ver.roles',
            'ver.usuarios',
            'ver.dashboard',
            
            // Especiales
            'acceso.total',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // 2. Crear y Configurar Roles
        
        // Super Administrador (Braulio)
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $adminRole->syncPermissions(Permission::all());

        // Artesano (Acceso limitado)
        $artesanoRole = Role::firstOrCreate(['name' => 'artesano']);
        $artesanoRole->syncPermissions([
            'productos.index',
            'productos.crear',
            'productos.editar.propios',
            'productos.eliminar.propios',
            'ver.dashboard',
        ]);

        // Cliente
        $clienteRole = Role::firstOrCreate(['name' => 'cliente']);

        // 3. Crear usuario Super Admin
        $braulio = User::firstOrCreate(
            ['email' => 'admin@raices.com'],
            [
                'name'     => 'Braulio Cardozo Vasquez',
                'password' => Hash::make('Cardozo@98'), 
            ]
        );
        $braulio->assignRole($adminRole);
        $braulio->persona()->updateOrCreate(
            ['user_id' => $braulio->id],
            [
                'nombre'       => 'Braulio',
                'apellido'     => 'Cardozo Vasquez',
                'tipo_persona' => 'administrador',
                'municipio'    => 'Santa María Tlahuitoltepec',
                'comunidad'    => 'Agencia de Guadalupe Victoria',
                'estado'       => 1
            ]
        );

        // 4. Usuario Artesano de Ejemplo
        $artesanoUser = User::firstOrCreate(
            ['email' => 'artesano1@raices.com'],
            [
                'name'     => 'Maestro Artesano Ejemplo',
                'password' => Hash::make('Artesano@2024'),
            ]
        );

        // 5. Usuario Cliente de Ejemplo
$clienteUser = User::firstOrCreate(
    ['email' => 'cliente1@raices.com'],
    [
        'name'     => 'Cliente Ejemplo',
        'password' => Hash::make('Cliente@2024'),
    ]
);
$clienteUser->assignRole($clienteRole);

        $artesanoUser->assignRole($artesanoRole);
        $artesanoUser->persona()->updateOrCreate(
            ['user_id' => $artesanoUser->id],
            [
                'nombre'       => 'Juan',
                'apellido'     => 'Pérez',
                'tipo_persona' => 'artesano',
                'municipio'    => 'Tlahuitoltepec',
                'comunidad'    => 'Centro',
                'estado'       => 1
            ]
        );
    }
}
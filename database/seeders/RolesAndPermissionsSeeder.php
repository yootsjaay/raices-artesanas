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
        // 1. Crear Roles (Usando los nombres finales)
        $adminRole    = Role::create(['name' => 'Admin']);
        $artesanoRole = Role::create(['name' => 'Artesano']);
        $clienteRole  = Role::create(['name' => 'Cliente']);

        // 2. Crear Permisos iniciales
        Permission::create(['name' => 'acceso.total']);
        Permission::create(['name' => 'publicar.artesania']);

        // 3. Asignar permisos al Admin
        $adminRole->givePermissionTo(Permission::all());
        $artesanoRole->givePermissionTo('publicar.artesania');

        // 4. CREAR EL USUARIO ADMINISTRADOR
        $user = User::create([
            'name'     => 'Braulio Cardozo Vasquez',
            'email'    => 'admin@raices.com',
            'password' => Hash::make('Cardozo@98'), 
        ]);

        // 5. CREAR SU PERFIL EN LA TABLA PERSONAS (Obligatorio)
        $user->persona()->create([
            'nombre'       => 'Braulio',
            'apellido'     => 'Cardozo Vasquez',
            'tipo_persona' => 'Admin',
            'municipio'    => 'Tlahuitoltepec', // Ejemplo de comunidad Mixe
            'comunidad'    => 'Agencia de guadalupe',
            'estado'       => 1
        ]);

        // 6. Asignar el Rol de Spatie
        $user->assignRole($adminRole);
    }
}
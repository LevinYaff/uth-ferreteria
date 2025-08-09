<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $roles = [
            'admin',
            'vendedor',
            'inventario',
            'compras',
            'supervisor'
        ];




        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }

        // Asignar roles basados en el campo role existente
        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole($user->role);
        }
    }
}

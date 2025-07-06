<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            [
                'nombre' => 'Ferreterías Unidas, S.A.',
                'contacto' => 'Juan Pérez',
                'telefono' => '555-1234',
                'email' => 'contacto@ferreterias-unidas.com',
                'direccion' => 'Calle Principal #123, Zona Industrial',
                'activo' => true,
            ],
            [
                'nombre' => 'Distribuidora de Herramientas, S.A.',
                'contacto' => 'María González',
                'telefono' => '555-5678',
                'email' => 'ventas@distherramientas.com',
                'direccion' => 'Avenida Central #456, Sector Comercial',
                'activo' => true,
            ],
            [
                'nombre' => 'Materiales de Construcción El Constructor',
                'contacto' => 'Roberto Sánchez',
                'telefono' => '555-9012',
                'email' => 'info@elconstructor.com',
                'direccion' => 'Carretera Norte Km 5, Bodega #8',
                'activo' => true,
            ],
            [
                'nombre' => 'Importadora de Herramientas Eléctricas',
                'contacto' => 'Ana Martínez',
                'telefono' => '555-3456',
                'email' => 'ventas@importadoraelectricas.com',
                'direccion' => 'Boulevard Los Próceres #789, Zona 10',
                'activo' => true,
            ],
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }
    }
}

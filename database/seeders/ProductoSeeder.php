<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Martillo de Carpintero',
                'descripcion' => 'Martillo de acero con mango ergonómico',
                'categoria_id' => 1, // Herramientas Manuales
                'precio_compra' => 8.50,
                'precio_venta' => 12.99,
                'stock' => 25,
                'codigo' => 'HM001',
                'activo' => true,
            ],
            [
                'nombre' => 'Taladro Eléctrico 750W',
                'descripcion' => 'Taladro eléctrico de alto rendimiento',
                'categoria_id' => 2, // Herramientas Eléctricas
                'precio_compra' => 45.00,
                'precio_venta' => 65.99,
                'stock' => 10,
                'codigo' => 'HE001',
                'activo' => true,
            ],
            [
                'nombre' => 'Llave Inglesa 12"',
                'descripcion' => 'Llave ajustable de 12 pulgadas',
                'categoria_id' => 1, // Herramientas Manuales
                'precio_compra' => 7.25,
                'precio_venta' => 11.50,
                'stock' => 30,
                'codigo' => 'HM002',
                'activo' => true,
            ],
            [
                'nombre' => 'Tubo PVC 1/2" (metro)',
                'descripcion' => 'Tubo de PVC para instalaciones de agua',
                'categoria_id' => 3, // Plomería
                'precio_compra' => 1.20,
                'precio_venta' => 2.50,
                'stock' => 100,
                'codigo' => 'PL001',
                'activo' => true,
            ],
            [
                'nombre' => 'Cable Eléctrico 12 AWG (metro)',
                'descripcion' => 'Cable para instalaciones eléctricas residenciales',
                'categoria_id' => 4, // Electricidad
                'precio_compra' => 0.85,
                'precio_venta' => 1.50,
                'stock' => 200,
                'codigo' => 'EL001',
                'activo' => true,
            ],
            [
                'nombre' => 'Pintura Látex Blanco 1 Galón',
                'descripcion' => 'Pintura de alta cobertura para interiores',
                'categoria_id' => 5, // Pinturas
                'precio_compra' => 14.50,
                'precio_venta' => 22.99,
                'stock' => 15,
                'codigo' => 'PI001',
                'activo' => true,
            ],
            [
                'nombre' => 'Cemento Portland 42.5 kg',
                'descripcion' => 'Cemento para construcción general',
                'categoria_id' => 6, // Construcción
                'precio_compra' => 6.75,
                'precio_venta' => 9.99,
                'stock' => 50,
                'codigo' => 'CO001',
                'activo' => true,
            ],
            [
                'nombre' => 'Sierra Circular 1200W',
                'descripcion' => 'Sierra eléctrica para cortes precisos',
                'categoria_id' => 2, // Herramientas Eléctricas
                'precio_compra' => 75.00,
                'precio_venta' => 109.99,
                'stock' => 8,
                'codigo' => 'HE002',
                'activo' => true,
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}

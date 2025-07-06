<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Herramientas Manuales', 'descripcion' => 'Herramientas que no requieren electricidad'],
            ['nombre' => 'Herramientas Eléctricas', 'descripcion' => 'Herramientas que funcionan con electricidad'],
            ['nombre' => 'Plomería', 'descripcion' => 'Artículos para instalaciones de agua'],
            ['nombre' => 'Electricidad', 'descripcion' => 'Componentes eléctricos'],
            ['nombre' => 'Pinturas', 'descripcion' => 'Pinturas y accesorios'],
            ['nombre' => 'Construcción', 'descripcion' => 'Materiales para construcción'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}

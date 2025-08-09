<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Primero convertimos la columna a string para poder modificar los valores
        DB::statement('ALTER TABLE users MODIFY role VARCHAR(255)');

        // Luego la convertimos de nuevo a ENUM con los nuevos valores
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'vendedor', 'inventario', 'compras', 'supervisor', 'cliente') NOT NULL DEFAULT 'cliente'");
    }

    public function down(): void
    {
        // Primero convertimos la columna a string
        DB::statement('ALTER TABLE users MODIFY role VARCHAR(255)');

        // Luego la convertimos de nuevo al ENUM original
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'vendedor', 'cliente') NOT NULL DEFAULT 'cliente'");
    }
};

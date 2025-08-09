<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Primero convertimos la columna a string para evitar problemas con el ENUM
            DB::statement('ALTER TABLE users MODIFY role VARCHAR(255)');

            // Actualizamos los valores existentes si es necesario
            DB::table('users')->where('role', 'cliente')->update(['role' => 'cliente']);

            // Ahora creamos el nuevo ENUM
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'vendedor', 'inventario', 'compras', 'supervisor', 'cliente') NOT NULL");
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Convertimos de nuevo a VARCHAR primero
            DB::statement('ALTER TABLE users MODIFY role VARCHAR(255)');

            // Actualizamos valores que no existan en el ENUM original
            DB::table('users')
                ->whereNotIn('role', ['admin', 'vendedor', 'cliente'])
                ->update(['role' => 'cliente']);

            // Volvemos al ENUM original
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'vendedor', 'cliente') NOT NULL DEFAULT 'cliente'");
        });
    }
};

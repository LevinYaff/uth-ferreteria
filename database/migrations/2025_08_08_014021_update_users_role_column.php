<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero modificamos el ENUM en MySQL o actualizamos la restricción CHECK en otros motores
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'vendedor', 'inventario', 'compras', 'supervisor') NOT NULL DEFAULT 'vendedor'");
        } else {
            // Para otros motores (PostgreSQL, SQLite, etc.)
            Schema::table('users', function (Blueprint $table) {
                // Eliminar restricciones anteriores si existen
                $table->dropColumn('role');
            });

            Schema::table('users', function (Blueprint $table) {
                // Recrear la columna con nuevas restricciones
                $table->string('role')->default('vendedor');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'vendedor') NOT NULL DEFAULT 'vendedor'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('vendedor');
            });
        }
    }
};

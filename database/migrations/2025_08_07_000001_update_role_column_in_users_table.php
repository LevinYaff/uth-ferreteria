<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Modificar la columna role para aceptar los nuevos roles
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'vendedor', 'inventario', 'compras', 'supervisor') NOT NULL DEFAULT 'vendedor'");
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir a los roles originales
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'vendedor') NOT NULL DEFAULT 'vendedor'");
        });
    }
};

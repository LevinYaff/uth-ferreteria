<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_proveedor', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');

            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->string('codigo_proveedor')->nullable();
            $table->boolean('es_proveedor_principal')->default(false);

            $table->timestamps();

            $table->unique(['producto_id', 'proveedor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_proveedor');
    }
};

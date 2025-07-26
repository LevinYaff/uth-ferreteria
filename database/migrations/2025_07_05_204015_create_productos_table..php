<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->decimal('precio_compra', 8, 2);
            $table->decimal('precio_venta', 8, 2);
            $table->integer('stock')->default(0);
            $table->string('codigo')->unique();
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

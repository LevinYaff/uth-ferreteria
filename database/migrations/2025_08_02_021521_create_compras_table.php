<?php

use App\Models\Proveedor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->foreignId('user_id')->constrained(); // Usuario que registra la compra
            $table->string('numero_factura')->nullable();
            $table->string('numero_orden')->nullable();
            $table->date('fecha_compra');
            $table->date('fecha_recepcion')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'recibida', 'parcial', 'cancelada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->string('archivo_factura')->nullable(); // Para almacenar el archivo de factura escaneado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};

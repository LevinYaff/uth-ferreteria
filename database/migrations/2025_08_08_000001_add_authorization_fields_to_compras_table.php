<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('compras', function (Blueprint $table) {
            if (!Schema::hasColumn('compras', 'autorizada_por')) {
                $table->foreignId('autorizada_por')->nullable()->constrained('users');
            }
            if (!Schema::hasColumn('compras', 'fecha_autorizacion')) {
                $table->timestamp('fecha_autorizacion')->nullable();
            }
            if (!Schema::hasColumn('compras', 'rechazada_por')) {
                $table->foreignId('rechazada_por')->nullable()->constrained('users');
            }
            if (!Schema::hasColumn('compras', 'fecha_rechazo')) {
                $table->timestamp('fecha_rechazo')->nullable();
            }
            if (!Schema::hasColumn('compras', 'motivo_rechazo')) {
                $table->text('motivo_rechazo')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn(['estado', 'autorizada_por', 'fecha_autorizacion', 'rechazada_por', 'fecha_rechazo', 'motivo_rechazo']);
        });
    }
};

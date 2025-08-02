<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'cantidad_recibida'
    ];

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    // Estado de recepción
    public function getEstadoRecepcionAttribute()
    {
        if ($this->cantidad_recibida === 0) {
            return 'Pendiente';
        } elseif ($this->cantidad_recibida < $this->cantidad) {
            return 'Parcial';
        } else {
            return 'Completo';
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id',
        'user_id',
        'numero_factura',
        'numero_orden',
        'fecha_compra',
        'fecha_recepcion',
        'subtotal',
        'impuestos',
        'descuento',
        'total',
        'estado',
        'observaciones',
        'archivo_factura'
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_recepcion' => 'date',
    ];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCompra::class);
    }

    // Estado de la compra formateado
    public function getEstadoFormateadoAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'Pendiente',
            'recibida' => 'Recibida',
            'parcial' => 'Recibida Parcialmente',
            'cancelada' => 'Cancelada',
            default => 'Desconocido'
        };
    }
}

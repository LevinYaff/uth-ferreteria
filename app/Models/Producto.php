<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_id',
        'precio_compra',
        'precio_venta',
        'stock',
        'codigo',
        'imagen',
        'activo'
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function detalleVentas(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }

    // Relación con proveedores
    public function proveedores(): BelongsToMany
    {
        return $this->belongsToMany(Proveedor::class, 'producto_proveedor')
                    ->withPivot('precio_compra', 'codigo_proveedor', 'es_proveedor_principal')
                    ->withTimestamps();
    }

    // Relación con detalles de compra
    public function detalleCompras(): HasMany
    {
        return $this->hasMany(DetalleCompra::class);
    }

    // Obtener el proveedor principal
    public function proveedorPrincipal()
    {
        return $this->proveedores()
                    ->wherePivot('es_proveedor_principal', true)
                    ->first();
    }

    // Obtener el último proveedor que vendió este producto
    public function ultimo_proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'ultimo_proveedor_id');
    }

    // Obtener el último precio de compra
    public function getUltimoPrecioCompraAttribute()
    {
        $ultimaCompra = $this->detalleCompras()
            ->join('compras', 'detalle_compras.compra_id', '=', 'compras.id')
            ->where('compras.estado', 'recibida')
            ->orderBy('compras.created_at', 'desc')
            ->first();

        return $ultimaCompra ? $ultimaCompra->precio_unitario : null;
    }
}
